<?php

namespace App\Http\Controllers;

use App\actions\Pdf\PDFGenerateAction;
use App\Enums\PDFRepairTypeEnum;
use App\Http\Requests\RepairPDFGeneratorRequest;
use App\Models\Repair;
use Exception;
use Spatie\LaravelPdf\PdfBuilder;

class RepairPDFGeneratorController extends Controller
{
    /**
     * @throws Exception
     */
    public function generate(Repair $repair, RepairPDFGeneratorRequest $request, PDFGenerateAction $PDFGenerateAction): PdfBuilder
    {
        $type = $request->validated('type');

        return $PDFGenerateAction->execute($repair, PDFRepairTypeEnum::from($type))->inline("repair-{$repair->id}-{$type}");
    }
}
