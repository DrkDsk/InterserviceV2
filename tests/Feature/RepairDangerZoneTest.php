<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Reception;
use App\Models\Repair;
use App\Models\RepairLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepairDangerZoneTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_delete_only_repair_logs(): void
    {
        $user = User::factory()->create();
        $repair = $this->createRepair($user);

        RepairLog::query()->create([
            'repair_id' => $repair->id,
            'message' => 'Primer log',
            'created_by' => $user->id,
        ]);

        RepairLog::query()->create([
            'repair_id' => $repair->id,
            'message' => 'Segundo log',
            'created_by' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete($this->routeUrl("repair/{$repair->id}/logs"), [
                'confirmation' => 'Eliminar',
            ]);

        $response->assertRedirect($this->routeUrl("repair/{$repair->id}/settings"));

        $this->assertDatabaseHas('repairs', ['id' => $repair->id]);
        $this->assertDatabaseCount('repair_logs', 0);
        $this->assertDatabaseHas('devices', ['id' => $repair->device_id]);
        $this->assertDatabaseHas('receptions', ['id' => $repair->reception_id]);
    }

    public function test_authenticated_user_can_delete_repair_and_owned_relations(): void
    {
        $user = User::factory()->create();
        $repair = $this->createRepair($user);

        RepairLog::query()->create([
            'repair_id' => $repair->id,
            'message' => 'Bitacora',
            'created_by' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete($this->routeUrl("repair/{$repair->id}"), [
                'confirmation' => 'Eliminar',
            ]);

        $response->assertRedirect($this->routeUrl('repair'));

        $this->assertDatabaseMissing('repairs', ['id' => $repair->id]);
        $this->assertDatabaseMissing('repair_logs', ['repair_id' => $repair->id]);
        $this->assertDatabaseMissing('devices', ['id' => $repair->device_id]);
        $this->assertDatabaseMissing('receptions', ['id' => $repair->reception_id]);
    }

    public function test_confirmation_text_is_required_for_destructive_actions(): void
    {
        $user = User::factory()->create();
        $repair = $this->createRepair($user);

        $response = $this
            ->actingAs($user)
            ->from($this->routeUrl("repair/{$repair->id}/settings"))
            ->delete($this->routeUrl("repair/{$repair->id}/logs"), [
                'confirmation' => 'eliminar',
            ]);

        $response->assertRedirect($this->routeUrl("repair/{$repair->id}/settings"));
        $response->assertSessionHasErrors('confirmation');

        $this->assertDatabaseHas('repairs', ['id' => $repair->id]);
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
            'brand' => 'Lenovo',
            'model' => 'ThinkPad',
            'serial_number' => fake()->unique()->numerify('SER-####'),
        ]);

        return Repair::query()->create([
            'reception_id' => $reception->id,
            'device_id' => $device->id,
            'technician_id' => $user->id,
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
