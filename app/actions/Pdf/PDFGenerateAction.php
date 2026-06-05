<?php

namespace App\actions\Pdf;

use App\DTO\ReceptionDTO;
use App\DTO\RepairDTO;
use App\Enums\PDFRepairTypeEnum;
use App\Models\Repair;
use App\useCases\Repair\PDF\PDFGeneratorDeliveryUseCase;
use App\useCases\Repair\PDF\PDFGeneratorReceptionUseCase;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

readonly class PDFGenerateAction
{
    public function __construct(
        private PDFGeneratorDeliveryUseCase $PDFGeneratorDeliveryUseCase,
        private PDFGeneratorReceptionUseCase $PDFGeneratorReceptionUseCase
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(Repair $repair, PDFRepairTypeEnum $type, bool $isStream = true): Redirector|RedirectResponse
    {
        $reception = $repair->reception;
        $repairDTO = RepairDTO::fromRepair($repair);
        $receptionDTO = ReceptionDTO::fromReception($reception);


        return match ($type) {
            PDFRepairTypeEnum::DELIVERY => $this->PDFGeneratorDeliveryUseCase->generate($repairDTO, $receptionDTO),
            PDFRepairTypeEnum::PICKUP =>  throw new Exception('To be implemented'),
            PDFRepairTypeEnum::RECEPTION => $this->PDFGeneratorReceptionUseCase->generate($repairDTO, $receptionDTO),
        };
    }
}
