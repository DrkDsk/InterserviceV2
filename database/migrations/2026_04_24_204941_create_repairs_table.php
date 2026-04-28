<?php

use App\Enums\RepairEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reception_id')->constrained()->cascadeOnDelete();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technician_id')->constrained('users');
            $table->foreignId('service_id')->nullable()->constrained();
            $table->enum('status', RepairEnum::values())->default(RepairEnum::Pending->value);
            $table->text('issue')->nullable();
            $table->text('observations')->nullable();
            $table->text('solution')->nullable();
            $table->decimal('cost', 10)->nullable();
            $table->timestamp('repaired_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
