<?php

namespace Modules\Viravira\Jobs;

use App\Http\Requests\Income\Invoice as Request;
use App\Http\Requests\Income\InvoicePayment as PaymentRequest;
use App\Jobs\Income\CreateInvoice as BaseCreateInvoice;
use App\Jobs\Income\CreateInvoicePayment;
use App\Models\Common\Item;
use App\Models\Income\Customer;
use App\Models\Income\Invoice;
use App\Models\Setting\Currency;
use App\Models\Setting\Tax;
use App\Models\Setting\Category;
use App\Traits\Incomes;
use Date;
use Modules\Viravira\Traits\Remote;
use Modules\Viravira\Jobs\CreateItem;
use Modules\Viravira\Jobs\CreateCustomer;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateInvoice
{
    use Dispatchable, Incomes, Remote;

    protected $order;

    protected $currency;

    /**
     * Create a new job instance.
     *
     * @param  $payment
     * @param  $transaction
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $currency_code = $this->order->currency;

        $this->currency = Currency::where('code', strtoupper($currency_code))->first();

        if (empty($this->currency)) {
            $this->currency = Currency::where('code', setting('general.default_currency'))->first();
        }

        return $this->createInvoice($this->getCustomer());
    }

    protected function getCustomer()
    {
        $customer = Customer::where('email', $this->order->customer_email)->first();

        if (empty($customer)) {
            $viravira_customer = $this->getCustomers('getCustomerById/' . $this->order->customer_id);

            if (! $viravira_customer->success) {
                $customer_request = [
                    'company_id' => session('company_id'),
                    'name' => $this->order->customer_name,
                    'email' => $this->order->customer_email,
                    'currency_code' => $this->currency->code,
                    'address' => $this->order->invoice_address,
                    'phone' => $this->order->customer_phone,
                ];

                $customer = Customer::firstOrCreate($customer_request);

                return $customer;
            }

            $customer = dispatch(new CreateCustomer($viravira_customer->data[0]));
        }

        return $customer;
    }

    protected function getTax($taxLine)
    {
        $tax = Tax::where('rate', '=', $taxLine)->first();

        if ($tax) {
            return $tax->id;
        }

        $tax = Tax::firstOrCreate([
            'company_id' => session('company_id'),
            'name' => trans_choice('general.tax_rates', 1) . ' ' . $taxLine,
            'rate' => $taxLine,
            'type' => 'normal',
            'enabled' => '1',
        ]);

        return $tax->id;
    }

    protected function createInvoice($customer)
    {
        $order = Invoice::where('order_number', '=', $this->order->order_id)->first();

        if ($order) {
            return $order;
        }

        $items = [];

        foreach ($this->order->details as $order_item) {
            $item = Item::where('sku', $order_item->item_code)->first();

            if (!$item) {
                dispatch(new CreateItem($order_item));
            }

            $taxes = [];

            $taxes[] = $this->getTax($order_item->Vat);

            $items[] = [
                'name' => ($item) ? $item->name : $order_item->product_name,
                'item_id' => ($item) ? $item->id : null,
                'sku' => ($item) ? $item->sku : $order_item->product_code,
                'price' => $order_item->price,
                'quantity' => $order_item->quantity,
                'currency' => $this->currency->code,
                'tax_id' => $taxes,
            ];
        }

        $date = Date::parse($this->order->created_at)->format('Y-m-d H:i:s');

        $invoice_number = $this->getNextInvoiceNumber();

        $invoice_data =  [
            'company_id' => session('company_id'),
            'customer_id' => $customer->id,
            'amount' => $this->order->total_price,
            'invoiced_at' => $date,
            'due_at' => $date,
            'invoice_number' => $invoice_number,
            'order_number' => $this->order->order_id,
            'currency_code' => $this->currency->code,
            'currency_rate' => $this->currency->rate,
            'item' => $items,
            'discount' => !empty($this->order->discount) ? $this->order->discount :'0',
            'notes' => null,
            'category_id' => setting('viravira.invoice_category_id'),
            'recurring_frequency' => 'no',
            'customer_name' =>  $customer->name,
            'customer_email' => $customer->email,
            'customer_tax_number' => null,
            'customer_phone' =>  $customer->phone,
            'customer_address' =>  $customer->address,
            'invoice_status_code' => 'draft',
        ];

        $invoice_request = new Request();
        $invoice_request->merge($invoice_data);

        $invoice = dispatch(new BaseCreateInvoice($invoice_request));

        // Mark paid
        $invoice->invoice_status_code = 'paid';
        $invoice->save();

        $payment_data = [
            'company_id' =>  $invoice->company_id,
            'invoice_id' => $invoice->id,
            'account_id' =>  setting('viravira.account_id'),
            'currency_code' =>  $invoice->currency_code,
            'currency_rate' =>  $invoice->currency_rate,
            'amount' =>  $invoice->amount,
            'paid_at' =>  $date,
            'payment_method' =>  setting('general.default_payment_method'),
            'reference' => 'order-id:' . $this->order->OrderId,
        ];

        $payment_request = new PaymentRequest();
        $payment_request->merge($payment_data);

        $invoice_payment = dispatch(new CreateInvoicePayment($payment_request, $invoice));

        return $invoice;
    }
}
