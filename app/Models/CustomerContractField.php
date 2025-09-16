<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContractField extends Model
{
  protected $fillable = [
    'customer_id',
    'address',
    'service',
    'city',
    'registration',
    'total_contract_amount',
    'on_receiving_job_offer_letter_amount',
    'on_receiving_work_permit_amount',
    'on_receiving_embassy_appointment_amount',
    'after_visa_amount',
    'flight_ticket'
];

public function customer(){
    return $this->belongsTo(Customer::class);
}
}
