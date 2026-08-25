<?php

namespace App\Enums;

enum TrayId: int
{
    case Review = 1;                 // Bandeja de revisión
    case Stock = 2;                  // Bandeja de bodega
    case Quotation = 3;              // Bandeja de cotizaciones
    case BudgetAvailability = 4;     // Bandeja de disponibilidad presupuestaria
    case FormPrinting = 5;           // Bandeja de impresión de formularios
    case Purchasing = 6;             // Bandeja de compras
    case BudgetApproval = 7;         // Bandeja de aprobación presupuestaria
    case Payment = 8;                // Bandeja de pagos
    case Reception = 9;              // Bandeja de recepción
    case CaseCustody = 10;           // Bandeja de custodia de casos
    case Rotation = 11;              // Bandeja de rotación
}
