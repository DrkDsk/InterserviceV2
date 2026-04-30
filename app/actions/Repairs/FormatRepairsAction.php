<?php

namespace App\actions\Repairs;

use App\Enums\RepairEnum;

class FormatRepairsAction
{
    public function execute($repairs)
    {
        return array_map(function ($repair) {
            $repair["issue"] = ucfirst(mb_convert_case($repair["issue"], MB_CASE_LOWER, "UTF-8"));

            $status = $repair["status"];

            if ($status == RepairEnum::Pending->value) {
                $repair["status"] = "Pendiente";
            } else if ($status == RepairEnum::Diagnosing->value) {
                $repair["status"] = "Diagnóstico";
            } else if ($status == RepairEnum::WaitingParts->value) {
                $repair["status"] = "Esperando Partes";
            } else if ($status == RepairEnum::InProgress->value) {
                $repair["status"] = "En Progreso";
            } else if ($status == RepairEnum::Cancelled->value) {
                $repair["status"] = "Cancelado";
            } else if ($status == RepairEnum::Completed->value) {
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

            if ($repair["reception"]["client"] == null) {
                $client = $repair["reception"]["customer_name"];
                $repair["client"] = mb_convert_case($client, MB_CASE_TITLE, "UTF-8");
                $repair["customer_phone"] = $repair["reception"]["customer_phone"];
            }

            return $repair;
        }, $repairs);
    }
}
