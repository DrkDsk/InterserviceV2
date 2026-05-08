<?php

namespace App\Http\Controllers;

use App\actions\Pdf\PDFGenerateAction;
use App\Enums\PDFRepairTypeEnum;
use App\Http\Requests\RepairPDFGeneratorRequest;
use App\Models\Repair;

class RepairPDFGeneratorController extends Controller
{
    public function generate(Repair $repair, RepairPDFGeneratorRequest $request, PDFGenerateAction $PDFGenerateAction)
    {
        $type = $request->validated('type');

        $PDF = $PDFGenerateAction->execute($repair, PDFRepairTypeEnum::from($type));

        return response()->json($PDF);
    }
}
