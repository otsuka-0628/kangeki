<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('performance_schedule_id')
                ->constrained('performance_schedules')
                ->onDelete('cascade');

            $table->string('reservation_token', 64)->unique();

            $table->string('customer_name', 255);
            $table->string('customer_email', 255);
            $table->string('customer_phone', 50)->nullable();
            $table->text('notes')->nullable();

            $table->string('status', 50)->default('reserved');
            $table->boolean('is_checked_in')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
