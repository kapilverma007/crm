<?php

use App\Models\Customer;
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
        Schema::create('customer_contract_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->string('address')->nullable();
            $table->string('service')->nullable();
            $table->string('city')->nullable();
            $table->decimal('registration', 10, 2)->nullable();
            $table->decimal('total_contract_amount', 10, 2)->nullable();
            $table->decimal('on_receiving_job_offer_letter_amount', 10, 2)->nullable();
            $table->decimal('on_receiving_work_permit_amount', 10, 2)->nullable();
            $table->decimal('on_receiving_embassy_appointment_amount', 10, 2)->nullable();
            $table->decimal('after_visa_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_contract_fields');
    }
};
