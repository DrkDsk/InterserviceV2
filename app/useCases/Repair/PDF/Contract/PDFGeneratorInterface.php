<?php

namespace App\useCases\Repair\PDF\Contract;

use App\DTO\ReceptionDTO;
use App\DTO\RepairDTO;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

interface PDFGeneratorInterface
{
    public function generate(RepairDTO $repairDTO, ReceptionDTO $receptionDTO) : Redirector|RedirectResponse;
}
