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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // tenant relationships
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();

            // customer data
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

            // visit data
            $table->dateTime('registered_at');
            $table->dateTime('left_at')->nullable();

            $table->text('remarks')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
