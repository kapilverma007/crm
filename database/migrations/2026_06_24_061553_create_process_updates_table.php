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
        Schema::create('process_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');

            // Stage 1 - Registration
            $table->boolean('stage1_registration')->default(false);
            $table->boolean('stage1_payment')->default(false);
            $table->date('stage1_date')->nullable();

            // Stage 2 - JOL (Job Offer Letter)
            $table->boolean('stage2_jol')->default(false);
            $table->boolean('stage2_payment')->default(false);
            $table->date('stage2_date')->nullable();

            // Stage 3 - WP (Work Permit)
            $table->boolean('stage3_wp')->default(false);
            $table->boolean('stage3_payment')->default(false);
            $table->date('stage3_date')->nullable();

            // Stage 4 - Appointment
            $table->boolean('stage4_appointment')->default(false);
            $table->boolean('stage4_payment')->default(false);
            $table->date('stage4_date')->nullable();

            // Stage 5 - Visa
            $table->boolean('stage5_visa')->default(false);
            $table->boolean('stage5_payment')->default(false);
            $table->date('stage5_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_updates');
    }
};
