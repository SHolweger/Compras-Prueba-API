<?php
//app/Enums/CaseStatus.php
namespace App\Enums;

enum CaseStatus: int
{
    case Draft = 1;                   //Borrador
    case InProcess = 2;               //En proceso
    case FinishedByStock = 3;         //Finalizado por bodega
    case FinishedWithoutBudget = 4;   //Finalizado sin presupuesto
    case FinishedBySuspension = 5;    //Finalizado por suspensión
    case Awarded = 6;                 //Adjudicado
    case Rejected = 7;                //Rechazado
    case FinishedVoided = 8;          //Finalizado anulado
    case FinishedDeserted = 9;        //Finalizado desierto
    case PurchaseCompleted = 10;      //Compra completada
    case Pending = 11;                //Pendiente
    case Finished = 12;               //Finalizado
}