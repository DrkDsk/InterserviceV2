<?php

namespace App\useCases\Repair\PDF;

use App\DTO\ReceptionDTO;
use App\DTO\RepairDTO;
use App\Repositories\Contract\SetUpCompanyRepositoryInterface;
use App\useCases\Repair\PDF\Contract\PDFGeneratorInterface;
use Carbon\Carbon;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class PDFGeneratorDeliveryUseCase extends PDFDownloadUseCase implements PDFGeneratorInterface
{
    public function __construct(private readonly SetUpCompanyRepositoryInterface $setupCompanyRepository)
    {
    }

    public function generate(RepairDTO $repairDTO, ReceptionDTO $receptionDTO): PdfBuilder
    {
        $setupCompany = $this->setupCompanyRepository->find(1);
        $deliveredDate = $receptionDTO->delivered_at;

        if (!$deliveredDate) {
            $deliveredDate = Carbon::now();
        }

        $receptionDate = $receptionDTO->received_at;
        $daysStored = $receptionDate->diffInDays($deliveredDate);
        $daysStored = (int)max($daysStored, 0);

        $data = [
            'repair' => $repairDTO->toArray(),
            'setup_company' => $setupCompany,
            'days_stored' => $daysStored,
        ];

        return Pdf::view('layouts.pdf.delivery', $data);
    }
}
