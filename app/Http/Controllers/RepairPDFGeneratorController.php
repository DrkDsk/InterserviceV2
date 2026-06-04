<?php

namespace App\Http\Controllers;

use App\actions\Pdf\PDFGenerateAction;
use App\Enums\PDFRepairTypeEnum;
use App\Http\Requests\RepairPDFGeneratorRequest;
use App\Models\Repair;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RepairPDFGeneratorController extends Controller
{
    /**
     * @throws Exception
     */
    public function generate(Repair $repair, RepairPDFGeneratorRequest $request, PDFGenerateAction $PDFGenerateAction): Redirector|RedirectResponse
    {
        $type = $request->validated('type');

        return $PDFGenerateAction->execute($repair, PDFRepairTypeEnum::from($type));
    }
}
