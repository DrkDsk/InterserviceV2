<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Reception;
use App\Models\Repair;
use App\Models\User;
use App\Repositories\Contract\SetUpCompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;
use Tests\TestCase;

class RepairPdfGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_delivery_pdf_inline(): void
    {
        Pdf::fake();

        $user = User::factory()->create();
        $repair = $this->createRepair($user);

        $this->app->instance(SetUpCompanyRepositoryInterface::class, new class implements SetUpCompanyRepositoryInterface
        {
            public function getAll(): Collection
            {
                return new Collection();
            }

            public function limit(int $limit = 100): Collection
            {
                return new Collection();
            }

            public function find(int $id): ?Model
            {
                return (new class extends Model
                {
                    protected $guarded = [];

                    public $timestamps = false;
                })->forceFill([
                    'id' => $id,
                    'facebook' => 'interservice',
                    'email' => 'interservice@gmail.com',
                    'WhatsApp' => '9661002020',
                    'phone' => '9666636253',
                    'location' => 'Calle 16 de Septiembre #20',
                    'city' => 'Tuxtla',
                ]);
            }

            public function getByField(string $field, string $value): ?Model
            {
                return null;
            }

            public function create(array $data): ?Model
            {
                return null;
            }

            public function paginate(int $perPage = 10): LengthAwarePaginator
            {
                return new LengthAwarePaginator([], 0, $perPage);
            }
        });

        $response = $this
            ->actingAs($user)
            ->get($this->routeUrl("repair/{$repair->id}/pdf?type=delivery"));

        $response->assertOk();

        Pdf::assertRespondedWithPdf(function (PdfBuilder $pdf) use ($repair) {
            return $pdf->isInline()
                && $pdf->downloadName === "repair-{$repair->id}-delivery.pdf"
                && $pdf->viewName === 'layouts.pdf.delivery'
                && $pdf->contains([
                    $repair->device->brand,
                    $repair->technician->name,
                    $repair->reception->folio,
                ]);
        });
    }

    private function createRepair(User $user): Repair
    {
        $reception = Reception::query()->create([
            'folio' => 'REC-'.fake()->unique()->numerify('####'),
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->phoneNumber(),
            'created_by' => $user->id,
            'notes' => fake()->sentence(),
        ]);

        $device = Device::query()->create([
            'reception_id' => $reception->id,
            'brand' => 'Apple',
            'model' => 'MacBook Pro',
            'serial_number' => fake()->unique()->numerify('SER-####'),
        ]);

        return Repair::query()->create([
            'reception_id' => $reception->id,
            'device_id' => $device->id,
            'technician_id' => $user->id,
            'status' => 'pending',
            'issue' => 'No enciende',
            'observations' => 'Sin observaciones',
        ]);
    }

    private function routeUrl(string $path): string
    {
        $subdomain = config('app.subdomain');
        $domain = config('app.domain');

        return "http://{$subdomain}.{$domain}/{$path}";
    }
}
