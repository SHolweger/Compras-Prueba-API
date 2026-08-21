# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

`api-compras` ("Compras" / purchasing) is a Laravel 13 API backend for a municipal purchasing system (`ma_purchases` database). It does **not** own its own authentication — instead it delegates all auth/identity/authorization to a separate service, `api-security`, and acts as a thin proxy/gateway in front of it. This app is not a git repository.

## Commands

All commands run from the project root using the vendored PHP/Composer tooling (no Sail/Docker in use).

- Install PHP deps: `composer install`
- Run dev environment (server + queue listener + logs + Vite, concurrently): `composer run dev`
- Run the full test suite: `composer run test` (clears config cache, then runs `php artisan test`)
- Run a single test: `php artisan test --filter=test_method_name` or `vendor/bin/phpunit --filter=test_method_name path/to/TestFile.php`
- Lint/format PHP (Laravel Pint): `vendor/bin/pint`
- Front-end asset build: `npm run build`; dev/watch: `npm run dev`

Tests run against an in-memory SQLite DB (configured in `phpunit.xml`), independent of the app's normal PostgreSQL connection.

## Architecture

### Auth is delegated to `api-security`

There are no local login/user tables beyond the stock Laravel `users`/`personal_access_tokens` scaffolding (Sanctum is installed but not actively used for issuing tokens here). Real authentication happens in an external `api-security` service, reached via `config('services.api-security.url')` (env var `API_SECURITY_URL`).

The flow:
1. `POST /api/login` (`SecurityProxyController::login`) forwards credentials to `api-security`'s `/api/auth/login` and relays its response verbatim.
2. Protected routes are wrapped in the `jwt.security` middleware alias (`App\Http\Middleware\ValidateJwtFromSecurity`, registered in `bootstrap/app.php`). It extracts the bearer token from the incoming request, calls `api-security`'s `/api/auth/me` to validate it, and — if valid — stashes the returned user under the `api-security-user` request attribute for controllers to read. If the token is missing or invalid, it short-circuits with a 401 JSON response before the controller runs.
3. Controllers under this middleware (e.g. `SecurityProxyController::profile`, `rolesByUser`, `menuByUser`, `logout`) further call back out to `api-security` endpoints (`/api/user-roles/{userId}`, `/api/menu/{systemId}/{userId}`, `/api/auth/logout`) using the same bearer token, and reshape/relay the JSON response.

When adding new authenticated endpoints, follow this same pattern: put them behind `jwt.security`, read the authenticated user from `$request->attributes->get('api-security-user')` rather than re-validating the token, and use `Http::baseUrl(config('services.api-security.url'))->withToken($token)` for any further calls to the security service.

### Routing

- `routes/api.php` is the primary surface — all endpoints here are prefixed `/api/...` automatically by Laravel's routing config in `bootstrap/app.php`.
- `routes/web.php` only serves the default Laravel welcome view; this is an API-only app in practice.
- JSON error rendering is forced for all `api/*` requests via `shouldRenderJsonWhen` in `bootstrap/app.php`, so exceptions return JSON rather than HTML even outside the explicit try/catch blocks in controllers.

### Config

- `API_SECURITY_URL` (env) → `config('services.api-security.url')` is the single most important config value; it points at the upstream `api-security` service base URL.
- Default local DB is PostgreSQL (`DB_CONNECTION=pgsql`, see `.env`/`.env.example`), database name `ma_purchases` locally.
