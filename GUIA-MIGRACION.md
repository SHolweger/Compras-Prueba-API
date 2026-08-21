# Guía de migración — Sistema Municipal de Compras

Documento de referencia para migrar el sistema legacy (PHP nativo + Vue 2 + MySQL)
al stack nuevo (Laravel 13 + Eloquent + PostgreSQL + Angular 22).

---

## 1. Qué es cada proyecto

```
Sistema de Compras/
├── Docker/                    ← SISTEMA VIEJO (solo se lee, nunca se modifica)
│   ├── backend-legacy/        PHP 7.3 + Apache · MySQL 5.6
│   │   └── src/
│   │       ├── mantigua_compras-master/   = RUTA   (sistema de compras)
│   │       └── seguridad/                 = RUTA2  (login, menú, permisos)
│   ├── compras-legacy/        Vue 2 + Vuetify 2 (frontend viejo)
│   └── *.sql                  dumps MySQL: ma_compras, ma_seguridad, ma_rrhh, SigDB
│
└── NuevosDesarrollos/         ← SISTEMA NUEVO (aquí se trabaja)
    ├── backend/
    │   ├── api-compras-pg/    Laravel 13.18 · BD ma_purchases   ← NUESTRO FOCO
    │   └── seguridad-api-pg/  Laravel 13.26 · BD ma_security · JWT (no lo tocamos)
    ├── frontend/compras/      Angular 22 standalone + Material + Tailwind v4
    └── backups/               dumps PostgreSQL del esquema nuevo
```

### Puertos

| Servicio | Puerto | Cómo se levanta |
|---|---|---|
| Backend legacy (PHP) | 8080 | `docker-compose up -d --build` en `Docker/backend-legacy` |
| Frontend legacy (Vue) | 8081 | `docker compose up --build -d` en `Docker/compras-legacy` |
| MySQL legacy | 3306 | (incluido en el compose del backend) |
| **api-security** (nuevo) | 8000 | `php artisan serve --port=8000` |
| **api-compras** (nuevo) | 8001 | `php artisan serve --port=8001` |
| Angular (nuevo) | 4200 | `ng serve` |

`api-compras` **no tiene login propio**: delega en `api-security` vía `API_SECURITY_URL`.

---

## 2. El procedimiento: cómo migrar una pantalla

Este es el flujo que se repite para cada pantalla del menú.

```
Pantalla del menú
   ↓  (la ruta del navegador dice el nombre del archivo)
   ↓  http://localhost:8081/#/principal/1/ingreso  →  ingreso.vue
   ↓
Docker/compras-legacy/src/components/<pantalla>.vue
   ↓  buscar en <script>:  mounted() → watch → methods
   ↓  cada método hace:  axios.post(RUTA + '/assets/backend/<archivo>.php', { accion: N })
   ↓
Docker/backend-legacy/src/mantigua_compras-master/src/assets/backend/<archivo>.php
   ↓  buscar:  if($data['accion']==N){ ... }
   ↓  ahí está el SQL crudo
   ↓
Traducir el SQL a Eloquent en NuevosDesarrollos/backend/api-compras-pg
   ↓  Model (scope) → Service (lógica) → Controller (HTTP) → routes/api.php
```

### Los 4 archivos del backend legacy

| Archivo | Qué contiene | Acciones |
|---|---|---|
| `consulta.php` | **Todas las lecturas** (1909 líneas) | 60 activas (1–56, más 4.1, 4.2, 35.1) |
| `ingresa.php` | INSERTs | 11 |
| `actualiza.php` | UPDATEs | 19 |
| `borra.php` | DELETEs | 6 |

No usan `switch`: son `if` sueltos encadenados. Los parámetros llegan como **JSON en el body**
(`json_decode(file_get_contents("php://input"))`), nunca por `$_POST`.

### Dato crítico: de dónde sale el usuario

En el legacy, `$idusuario` **nunca viaja en el body** — sale de la sesión PHP:

```php
session_name('munantapp'); session_start();
$idusuario = $_SESSION['idusuario'];
```

En el sistema nuevo el equivalente exacto es el usuario que el middleware deja en el request:

```php
$userId = $request->attributes->get('api-security-user')['id'];
```

**Nunca aceptes `user_id` desde el cliente.** Si lo haces, cualquiera puede crear solicitudes a nombre de otro.

---

## 3. Mapa de tablas: legacy → nuevo

El esquema nuevo está **completamente renombrado a inglés** y sigue convenciones Laravel
(`id` bigint, `created_at`/`updated_at`/`deleted_at`, nombres en plural snake_case).

| MySQL `ma_compras` | PostgreSQL `ma_purchases` |
|---|---|
| `expediente` | `procurement_cases` |
| `producto` | `case_products` |
| `insumo` | `supply_items` |
| `unidad` / `unidad_usuario` | `units` / `unit_users` |
| `estado` | `statuses` |
| `bandeja` / `bandeja_emp` | `trays` / `tray_users` |
| `bitacora` | `case_log_entries` |
| `renglon` | `budget_objects` |
| `modalidad` | `modalities` |
| `proveedor` | `suppliers` |
| `partida` | `budget_allocations` |
| `comentario` | `case_comments` |
| `archivo` / `archivo_expediente` | `document_types` / `case_documents` |
| `tareas` / `tarea_exp` | `tasks` / `case_tasks` |
| `programa` / `subprograma` / `proyecto` / `actividad` / `obra` | `programs` / `subprograms` / `projects` / `activities` / `works` |
| `ma_seguridad.usuario` | `ma_security.users` — **otra base de datos** |

### Columnas de `procurement_cases` (la tabla central)

| Legacy `expediente` | Nuevo `procurement_cases` |
|---|---|
| `idexpediente` | `id` |
| `idestado` | `status_id` |
| `idunidad` | `unit_id` |
| `idusuario` | `user_id` (sin FK: vive en la otra BD) |
| `idbandeja` | `tray_id` |
| `idrenglon` | `budget_object_id` |
| `idproveedor` | `supplier_id` |
| `idmodalidad` | `modality_id` |
| `titulo` / `descripcion` / `justificacion` | `title` / `description` / `justification` |
| `ingreso` / `finalizo` | `submitted_at` / `completed_at` |
| `formulario` / `nog` / `monto` | `form_number` / `nog_number` / `amount` |
| `cheque` / `partida` | `check_number` / `budget_line_reference` |
| `suspendido` / `visado` | `is_suspended` / `is_endorsed` (ahora **boolean**) |
| `responsable` | `responsible_user_id` |

### Tres diferencias estructurales que hay que tener presentes

1. **`eliminado = 0` → SoftDeletes.** Todos los modelos usan `SoftDeletes`, así que Eloquent
   agrega `WHERE deleted_at IS NULL` solo. No lo escribas a mano.
2. **Las 6 vistas SQL del legacy no existen.** `datos_generales`, `datos_basicos`, `historial`,
   `compras_cotizador`, `datos_archivos`, `usuarios_bandejas` (ver `Docker/consultas_compras.sql`)
   se reemplazan con **relaciones + scopes de Eloquent**, no creando vistas nuevas en PostgreSQL.
3. **No hay JOIN posible a usuarios.** `ma_purchases` y `ma_security` son bases distintas;
   PostgreSQL no hace JOIN entre bases. Todo lo que en el legacy era
   `JOIN ma_seguridad.usuario` hay que resolverlo aparte (pendiente, lo ve el administrador).

---

## 4. Antes de escribir código: revisa si la consulta ya existe

Esta es la parte más importante. **El legacy es muy redundante**: acciones con números distintos
hacen prácticamente lo mismo. Si migras acción por acción, replicas la redundancia.

### Ejemplo real 1 — la misma consulta con siete números

Las acciones **2, 4.1, 4.2, 11, 35, 35.1 y 36** de `consulta.php` son todas
"listar expedientes + contar sus productos". Lo único que cambia es el `WHERE`
(`idestado`, `idbandeja`, `idusuario`). Y las siete repiten el mismo **problema N+1**:
un `SELECT count(*) FROM producto` por cada fila del resultado.

→ En Eloquent: **una** consulta base sobre `ProcurementCase` con scopes encadenables
y `withCount('caseProducts')`, que además mata el N+1.

### Ejemplo real 2 — dos acciones, un solo modelo

- `consulta 1`: unidades **del usuario** (`unidad_usuario` + `unidad`, `activo=1`)
- `consulta 28`: **todas** las unidades activas

Mismo formato de salida, distinto `WHERE`. → Un modelo `Unit` con dos scopes: `active()` y `forUser()`.

### Ejemplo real 3 — once pantallas, una plantilla

Los 11 componentes `bande_*.vue` (~5.400 líneas) son la misma plantilla parametrizada por
`idbandeja`, usando siempre las acciones 10, 12, 11, 13 y `actualiza 3`.
→ Un solo grupo de endpoints parametrizado por bandeja.

### Reutilización en la pantalla "Solicitud de compra"

De las 11 acciones que usa `ingreso.vue`, **6 se comparten** con otras pantallas:

| Acción | Qué hace | Pantallas que la usan |
|---|---|---|
| `consulta 1` | Unidades del usuario | solo `ingreso` |
| `consulta 2` | Solicitudes en borrador | solo `ingreso` |
| `consulta 3` | Ítems del expediente | `ingreso` + `editar` + `editar_propias` |
| `consulta 56` | Presentaciones de un insumo | `ingreso` + `editar` + `editar_propias` |
| `ingresa 1` | Crear solicitud | solo `ingreso` |
| `ingresa 2` | Agregar ítem | `ingreso` + `editar` + `editar_propias` |
| `ingresa 3` | Enviar a bandeja (arranca el flujo) | solo `ingreso` |
| `actualiza 1` | Actualizar cabecera | `ingreso` + `editar` + `editar_propias` |
| `borra 1` | Borrar solicitud | `editar` + `editar_propias` (en `ingreso` el método existe pero **ningún botón lo llama**: código muerto) |
| `borra 2` | Borrar ítem | `ingreso` + `editar` + `editar_propias` |

**Conclusión: no migres acciones, migra conceptos.** Unidades, expedientes, ítems, insumos,
bitácora. Cada "acción" legacy termina siendo una combinación de scopes ya existentes.

---

## 5. Recetario SQL → Eloquent

Casos reales sacados de esta pantalla.

### JOIN implícito por comas → relación

```sql
-- consulta.php acción 1
SELECT b.idunidad, b.unidad
FROM ma_compras.unidad_usuario a, ma_compras.unidad b
WHERE a.idusuario=123 AND a.idunidad=b.idunidad AND b.activo=1 AND a.eliminado=0
```
```php
Unit::query()
    ->where('is_active', true)                    // b.activo=1
    ->whereHas('unitUsers', fn ($q) => $q->where('user_id', $userId))
    ->orderBy('name')
    ->get(['id', 'name']);
// a.eliminado=0 lo aplica SoftDeletes automáticamente
```

### Subconsulta de conteo dentro de un bucle (N+1) → `withCount()`

```php
// consulta.php acción 2 — el legacy hace esto POR CADA FILA:
$query2 = "SELECT count(*) as incluye FROM ma_compras.producto WHERE idexpediente=".$res['idexpediente'];
```
```php
ProcurementCase::query()->withCount('caseProducts')->get();
// una sola consulta; agrega la columna case_products_count
```

### Filtro por año sobre una fecha → `whereYear()`

```sql
AND date_format(a.ingreso,'%Y') = YEAR(CURDATE())
```
```php
->whereYear('submitted_at', now()->year)
```

### Traer relaciones sin N+1 → `with()` con columnas específicas

```php
->with(['status:id,name,color', 'unit:id,name'])
```

### Filtro condicional (el `if($idusuario==1)` del legacy) → `when()`

```php
->when(! $isAdmin, fn ($q) => $q->where('user_id', $userId))
```

### INSERT + UPDATE encadenados → `DB::transaction()`

```php
// ingresa.php acción 3: si el UPDATE falla después del INSERT,
// el legacy deja una bitácora huérfana.
DB::transaction(function () use ($case, $userId) {
    $case->caseLogEntries()->create([...]);
    $case->update(['status_id' => CaseStatus::InProcess->value, ...]);
});
```

### Números mágicos → enums

```php
// legacy: WHERE idestado=1  /  SET idbandeja='1'
CaseStatus::Draft->value    // 1
TrayId::Review->value       // 1
```

---

## 6. Dónde va cada cosa en Laravel

El proyecto ya trae **CRUD genérico completo** para las 25 tablas
(Model + Service + Controller + ruta `apiResource`). Lo que falta es la lógica de negocio.
Respeta las capas:

| Capa | Responsabilidad | Ejemplo |
|---|---|---|
| **Model** (`app/Models`) | Relaciones y **scopes reutilizables** | `#[Scope] active()`, `#[Scope] ownedBy()` |
| **Service** (`app/Services`) | Lógica de negocio, transacciones, reglas | `submitToReview()` |
| **Form Request** (`app/Http/Requests`) | Validación de entrada, mensajes en español | `StoreDraftRequest` |
| **Resource** (`app/Http/Resources`) | Forma del JSON de salida | `ProcurementCaseResource` |
| **Controller** (`app/Http/Controllers`) | Solo HTTP: recibe, delega, responde | `PurchaseRequestController` |
| **routes/api.php** | Rutas dentro del grupo `jwt.security` | `Route::prefix('purchase-requests')` |

Patrón ya establecido en el proyecto (respétalo):

```php
class UnitService
{
    public function list(): LengthAwarePaginator { return Unit::query()->paginate(); }
    public function find(int $id): Unit          { return Unit::query()->findOrFail($id); }
    public function create(array $data): Unit    { return Unit::query()->create($data); }
    public function update(Unit $unit, array $data): Unit { $unit->update($data); return $unit; }
    public function delete(Unit $unit): void     { $unit->delete(); }
}
```
```php
class UnitController extends Controller
{
    public function __construct(protected UnitService $service) {}
    public function index() { return response()->json($this->service->list()); }
    // ...
}
```

### Contrato de la API nueva

A diferencia del legacy (que siempre devuelve HTTP 200 con texto plano, y formatea
`"3 dia(s)"` / `{value, text}` para Vuetify), la API nueva usa **REST limpio**:

- JSON tipado con los nombres del esquema nuevo, números como números.
- Códigos HTTP correctos: `201` al crear, `204` al borrar, `422` en validación, `404`, `401`.
- El formateo de presentación es responsabilidad de Angular.

---

## 7. Checklist para la siguiente pantalla

1. Abrir el `.vue` en `Docker/compras-legacy/src/components/`.
2. Listar sus métodos y anotar `archivo.php` + `accion` de cada uno.
3. **Revisar la tabla de reutilización**: ¿alguna de esas acciones ya está migrada?
4. Para cada acción nueva, leer el SQL en el `.php` correspondiente.
5. Identificar la tabla nueva equivalente (sección 3).
6. ¿El `WHERE` es una variante de un scope que ya existe? → reutilizar. ¿No? → nuevo scope.
7. Lógica de negocio al Service. Si toca más de una tabla → `DB::transaction()`.
8. Form Request para validar, Resource para la salida.
9. Ruta dentro del grupo `jwt.security`.
10. Probar contra el legacy: mismo caso de datos, mismo resultado.
11. `vendor/bin/pint` antes de cerrar.

---

## 8. Cosas del legacy que NO hay que replicar

Detectadas al leer el código. Son bugs o malas prácticas, no requisitos:

- **SQL por concatenación de strings** en el 100% de las consultas → inyección SQL en todas partes.
  Eloquent parametriza solo.
- **N+1 sistemático**: el conteo de productos dentro del `while` de cada listado.
- **`echo $db->getLastErrorMessage()` antes del `json_encode`**: si hay error SQL, el texto queda
  pegado al JSON y lo corrompe.
- **Errores como HTTP 200 con texto plano** (`'sin cambios'`, `'Inicia sesión'`).
- **Reglas de negocio solo en el frontend**: por ejemplo "no se puede enviar una solicitud sin ítems"
  vive únicamente en el `:disabled` del botón Vue. En el backend nuevo eso se valida en el servidor.
- **`WHERE codigo = X` sobre 207.000 filas de `insumo` sin índice** → full scan en cada consulta.
- **Passwords en MD5** y credenciales de BD en texto plano dentro de `conector.php`.
- **Código muerto duplicado**: `temp.vue` ≡ `gerencia.vue`, `calendario2.vue` ≈ `calendario.vue`,
  y el `borrar()` de `proveedores.vue` que en realidad borra un expediente (copy-paste mal hecho).
