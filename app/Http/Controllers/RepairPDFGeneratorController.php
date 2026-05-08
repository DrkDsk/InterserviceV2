<?php

namespace App\Http\Controllers;

use App\actions\Pdf\PDFGenerateAction;
use App\Enums\PDFRepairTypeEnum;
use App\Http\Requests\RepairPDFGeneratorRequest;
use App\Models\Repair;
use Exception;
use Illuminate\Http\JsonResponse;

class RepairPDFGeneratorController extends Controller
{
    /**
     * @throws Exception
     */
    public function generate(Repair $repair, RepairPDFGeneratorRequest $request, PDFGenerateAction $PDFGenerateAction): JsonResponse
    {
        $type = $request->validated('type');

        $PDF = $PDFGenerateAction->execute($repair, PDFRepairTypeEnum::from($type));

        return response()->json($PDF);
    }
}
