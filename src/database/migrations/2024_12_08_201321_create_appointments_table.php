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
            $table->foreignId('service_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('vehicle_id')->nullable()->constrained();
            $table->string('appointment_type');
            $table->decimal('cost', 10, 2);
            $table->text('observations')->nullable();
            $table->timestamp('appointment_time');
            $table->enum('status', ['registered', 'processed', 'completed']);
            $table->timestamps();
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
