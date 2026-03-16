<?php

namespace App\Console\Commands;

use App\Mail\BirthdayMail;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendBirthdayEmails extends Command
{
    protected $signature = 'customers:send-birthday-emails';

    protected $description = 'Send birthday emails to customers whose birthday is today';

    public function handle(): int
    {
        $today = Carbon::today();

        $customers = Customer::whereNotNull('date_of_birth')
            ->whereNotNull('email')
            ->whereMonth('date_of_birth', $today->month)
            ->whereDay('date_of_birth', $today->day)
            ->get();

        $count = 0;
        foreach ($customers as $customer) {
            try {
                Mail::to($customer->email)->send(new BirthdayMail($customer));
                $count++;
                $this->info("Birthday email sent to: {$customer->full_name} ({$customer->email})");
            } catch (\Exception $e) {
                $this->error("Failed to send to {$customer->email}: {$e->getMessage()}");
            }
        }

        $this->info("Total birthday emails sent: {$count}");

        return self::SUCCESS;
    }
}
