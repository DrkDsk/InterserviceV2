<?php

namespace App\useCases\Repair\PDF;

use App\DTO\ReceptionDTO;
use App\DTO\RepairDTO;
use App\Repositories\Contract\SetUpCompanyRepositoryInterface;
use App\useCases\Repair\PDF\Contract\PDFGeneratorInterface;
use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPdf\Facades\Pdf;
use Throwable;

class PDFGeneratorDeliveryUseCase extends PDFDownloadUseCase implements PDFGeneratorInterface
{
    public function __construct(private readonly SetUpCompanyRepositoryInterface $setupCompanyRepository)
    {
    }

    public function generate(RepairDTO $repairDTO, ReceptionDTO $receptionDTO): Redirector|RedirectResponse
    {
        $setupCompany = $this->setupCompanyRepository->find(1);
        $deliveredDate = $receptionDTO->delivered_at;

        if (!$deliveredDate) {
            $deliveredDate = Carbon::now();
        }

        $receptionDate = $receptionDTO->received_at;
        $daysStored = $receptionDate->diffInDays($deliveredDate);
        $daysStored = (int)max($daysStored, 0);
        $fileName = "delivery-$repairDTO->id.pdf";
        $filePath = "pdfs/$fileName";

        $receptionStatusValue = $this->normalizeStatus($receptionDTO->status);
        $repairStatusNormalized = $this->normalizeStatus($repairDTO->status);
        $repairBadgeWrap = $repairBadge['wrap'] ?? '';
        $receptionBadgeWrap = $receptionBadge['wrap'] ?? '';

        $repairBadgeTone = match (true) {
            str_contains($repairBadgeWrap, 'success') => 'is-success',
            str_contains($repairBadgeWrap, 'warning') => 'is-warning',
            str_contains($repairBadgeWrap, 'danger')  => 'is-danger',
            default => 'is-primary',
        };

        $receptionBadgeTone = match (true) {
            str_contains($receptionBadgeWrap, 'success') => 'is-success',
            str_contains($receptionBadgeWrap, 'warning') => 'is-warning',
            str_contains($receptionBadgeWrap, 'danger')  => 'is-danger',
            default => 'is-primary',
        };

        $data = [
            'repair' => $repairDTO->toArray(),
            'reception' => $receptionDTO->toArray(),
            'setup_company' => $setupCompany,
            'days_stored' => $daysStored,
            "companyInitial" => str($setup_company->email ?? 'I')->substr(0, 1)->upper(),
            "receptionStatusValue" => $receptionStatusValue,
            "receptionBadge" => $this->statusBadge($receptionStatusValue),
            "statusLabel" => $this->formatStatusLabel($receptionStatusValue),
            "repairLabel" => $this->formatStatusLabel($repairStatusNormalized),
            "repairBadge" => $this->statusBadge($repairStatusNormalized),
            "repairCost" => $this->formatCurrency($repairDTO->cost),
            "generatedAt" => $this->formatDate(now()),
            "receptionDate" => $this->formatDate($receptionDate) ?? "---",
            "deliveredDate" => $this->formatDate($deliveredDate) ?? 'Pendiente',
            "repairedDate" => $this->formatDate($repairDTO->repaired_date) ?? 'Pendiente',
            "repairBadgeTone" => $repairBadgeTone,
            "receptionBadgeTone" => $receptionBadgeTone,
        ];

        if (!Storage::disk('public')->exists($filePath)) {
            Pdf::view('layouts.pdf.delivery', $data)
                ->withBrowsershot(function ($browser) {
                    $browser
                        ->noSandbox()
                        ->setChromePath(config('app.chrome_path'));
                })
                ->save(storage_path("app/public/$filePath"));
        }

        return redirect(Storage::url($filePath));
    }

    private function statusBadge(?string $status): array {
        return match ($status) {
            'completed', 'delivered' => [
                'wrap' => 'bg-success-50 text-success-500 ring-1 ring-inset ring-success-500/20',
                'dot' => 'bg-success-500',
            ],
            'pending', 'received', 'waiting_parts' => [
                'wrap' => 'bg-warning-50 text-warning-500 ring-1 ring-inset ring-warning-500/20',
                'dot' => 'bg-warning-500',
            ],
            'cancelled' => [
                'wrap' => 'bg-danger-50 text-danger-500 ring-1 ring-inset ring-danger-500/20',
                'dot' => 'bg-danger-500',
            ],
            default => [
                'wrap' => 'bg-primary-50 text-primary-500 ring-1 ring-inset ring-primary-500/20',
                'dot' => 'bg-primary-500',
            ],
        };
    }

    private function formatStatusLabel(?string $status): string {
        return match ($status) {
            'pending' => 'Pendiente',
            'diagnosing' => 'Diagnóstico',
            'waiting_parts' => 'Esperando refacciones',
            'in_progress' => 'En proceso',
            'completed' => 'Completada',
            'cancelled' => 'Cancelada',
            'received' => 'Recibido',
            'repairing' => 'En reparación',
            'delivered' => 'Entregado',
            default => $status ? str($status)->replace('_', ' ')->title()->toString() : 'Sin estado',
        };
    }

    private  function normalizeStatus($status): ?string {
        if ($status instanceof BackedEnum) {
            return $status->value;
        }

        return $status ? (string) $status : null;
    }

    private function formatCurrency($value): string {
        if (blank($value)) {
            return 'Pendiente';
        }

        return '$' . number_format((float) $value, 2);
    }

    private function formatDate($value, string $format = 'd M Y, h:i A'): string {
        if ($value instanceof CarbonInterface) {
            return $value->translatedFormat($format);
        }

        if (blank($value)) {
            return 'No disponible';
        }

        try {
            return Carbon::parse($value)->translatedFormat($format);
        } catch (Throwable) {
            return (string) $value;
        }
    }
}
