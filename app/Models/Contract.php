<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable=[
        'customer_id',
        'comments',
        'email_sent',
        'employee_id',
        'file_path',
        'contract_number'
    ];

    protected static function booted(): void
    {
        static::created(function (Contract $contract) {
            ProcessUpdate::firstOrCreate(
                ['customer_id' => $contract->customer_id]
            );
        });
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }
    public function  sendEmailNotification(){

    }
}
