<?php

namespace App\useCases\Repair\PDF\Contract;

use App\DTO\ReceptionDTO;
use App\DTO\RepairDTO;
use Spatie\LaravelPdf\PdfBuilder;

interface PDFGeneratorInterface
{
    public function generate(RepairDTO $repairDTO, ReceptionDTO $receptionDTO): PdfBuilder;
}
