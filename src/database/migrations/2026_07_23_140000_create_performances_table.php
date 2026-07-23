<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->foreignID('troupe_id')->constrained('troupes')->onDelete('cascade');
            $table->string('title');
            $table->string('venue_prefecture', 20);
            $table->string('venue_city', 100);
            $table->string('period_text', 100);
            $table->integer('max_tickets_per_person')->default(5);
            $table->dateTime('end_of_reservation_at');
            $table->text('notes')->nullable();
            $table->string('form_url_slug', 100)->unique();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
