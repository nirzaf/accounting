<?php

namespace Modules\Viravira\Console;

use App\Utilities\Overrider;
use App\Models\Common\Company;
use Illuminate\Console\Command;
use Modules\Viravira\Jobs\CreateItem;
use Modules\Viravira\Jobs\CreateInvoice;
use Modules\Viravira\Traits\Remote;

class Sync extends Command
{

    use Remote;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viravira:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync with Viravira';
    
    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all companies
        $companies = Company::all();

        foreach ($companies as $company) {
            // Set company id
            session(['company_id' => $company->id]);

            // Override settings and currencies
            Overrider::load('settings');
            Overrider::load('currencies');

            $company->setSettings();

            if (setting('viravira.sync', 0)) {
                $this->syncCustomers();

                $this->syncProducts();

                $this->syncOrders();
            }
        }

        // Unset company_id
        session()->forget('company_id');
    }

    protected function syncCustomers()
    {
        $customers = [];

        $results = $this->getCustomers();

        if (!empty($results)) {
            foreach ($results->data as $result) {
                $customers[$result->customer_id] = $result;
            }
        }

        foreach ($customers as $customer) {
            dispatch(new CreateCustomer($customer));
        }
    }

    protected function syncProducts()
    {
        $products = [];

        $results = $this->getProducts();

        if (!empty($results)) {
            foreach ($results->data as $result) {
                $products[$result->product_id] = $result;
            }
        }

        foreach ($products as $product) {
            dispatch(new CreateItem($product));
        }
    }

    protected function syncOrders()
    {
        $orders = [];

        $results = $this->getOrders();

        if (!empty($results)) {
            foreach ($results->data as $result) {
                $orders[$result->order_id] = $result;
            }
        }

        foreach ($orders as $order) {
            dispatch(new CreateInvoice($order));
        }
    }
}
