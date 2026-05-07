<?php

namespace App\actions\Repairs;

use App\Enums\RepairStatus;

class FormatRepairsAction
{
    public function execute($repairs): array
    {
        return array_map(static function ($repair) {
            $repair["issue"] = ucfirst(mb_convert_case($repair["issue"], MB_CASE_LOWER, "UTF-8"));

            $status = $repair["status"];

            if ($status === RepairStatus::Pending->value) {
                $repair["status"] = "Pendiente";
            } else if ($status === RepairStatus::Diagnosing->value) {
                $repair["status"] = "Diagnóstico";
            } else if ($status === RepairStatus::WaitingParts->value) {
                $repair["status"] = "Esperando Partes";
            } else if ($status === RepairStatus::InProgress->value) {
                $repair["status"] = "En Progreso";
            } else if ($status === RepairStatus::Cancelled->value) {
                $repair["status"] = "Cancelado";
            } else if ($status === RepairStatus::Completed->value) {
                $repair["status"] = "Completado";
            }

            if ($repair["technician"]) {
                $technician = $repair["technician"]["name"];
                $repair["technician"] = mb_convert_case($technician, MB_CASE_TITLE, "UTF-8");
            }

            if ($repair["reception"]["client"]) {
                $client = $repair["reception"]["client"]["name"];
                $repair["client"] = mb_convert_case($client, MB_CASE_TITLE, "UTF-8");
                $repair["customer_phone"] = $repair["reception"]["client"]["phone"];
            }

            if ($repair["reception"]["client"] === null) {
                $client = $repair["reception"]["customer_name"];
                $repair["client"] = mb_convert_case($client, MB_CASE_TITLE, "UTF-8");
                $repair["customer_phone"] = $repair["reception"]["customer_phone"];
            }

            return $repair;
        }, $repairs);
    }
}
