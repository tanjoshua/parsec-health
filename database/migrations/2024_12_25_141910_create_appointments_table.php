<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // tenant relationships
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

            // appointment data
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            // patient data (either linked to a patient or just a name)
            $table->foreignId('patient_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('patient_name')->nullable();

            $table->text('remarks')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
