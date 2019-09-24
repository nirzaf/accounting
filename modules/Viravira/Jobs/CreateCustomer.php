<?php

namespace Modules\Viravira\Jobs;

use App\Models\Income\Customer;
use App\Models\Setting\Currency;
use Modules\Viravira\Traits\Remote;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateCustomer
{
    use Dispatchable, Remote;

    protected $customer;

    protected $currency;

    /**
     * Create a new job instance.
     *
     * @param  $payment
     * @param  $transaction
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->currency = Currency::where('code', setting('general.default_currency'))->first();

        return $this->createCustomer();
    }

    protected function createCustomer()
    {
         $customer = Customer::where('email', '=', $this->customer->email)->first();

        if (empty($customer)) {
            $customer_request = [
                'company_id' => session('company_id'),
                'name' => $this->customer->first_name . ' ' . $this->customer->last_name,
                'email' => $this->customer->email,
                'currency_code' => $this->currency->code,
                'address' => $this->getAddress($this->customer),
                'phone' => $this->customer->phone,
            ];

            $customer = Customer::firstOrCreate($customer_request);
        }

        return $customer;
    }

    protected function getAddress($source)
    {
        $address = '';

        if (!empty($source->address)) {
            $address .= $source->address;
        }

        if (!empty($source->city)) {
            $address .= "\n" . $source->city;
        }

        if (!empty($source->town)) {
            $address .= "\n" . $source->town;
        }

        if (!empty($source->District)) {
            $address .= "\n" . $source->District;
        }

        if (!empty($source->country)) {
            $address .= "\n" . $source->country;
        }

        if (!empty($source->post_code)) {
            $address .= "\n" . $source->post_code;
        }

        return $address;
    }
}
