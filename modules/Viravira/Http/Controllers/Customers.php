<?php

namespace Modules\Viravira\Http\Controllers;

use Date;
use Cache;
use Modules\Viravira\Traits\Remote;
use Modules\Viravira\Jobs\CreateCustomer;
use Illuminate\Routing\Controller;

class Customers extends Controller
{

    use Remote;

    public function count()
    {
        $type = trans_choice('viravira::general.types.customers',2);

        $response = $this->getCustomers();

        $total = 0;

        if ($response && ($response->success)) {
            $total = $response->total;
        }

        $html = view('viravira::partial.sync', compact('type', 'total'))->render();

        $json = [
            'errors' => ($response->success) ? false : $response->message[0]->text[0],
            'success' => $response->success,
            'count' => $total,
            'html' => $html
        ];

        return response()->json($json);
    }

    public function sync()
    {
        $customers = $steps = [];

        $results = $this->getCustomers('getCustomers');

        if (!empty($results) && ($results->success)) {
            foreach ($results->data as $result) {
                $customers[$result->customer_id] = $result;

                $customer_name = $result->firt_name . ' ' . $result->last_name;

                $steps[] = [
                    'text' => trans('viravira::general.sync_text', ['type' => trans_choice('viravira::general.types.customers',1), 'value' => $customer_name]),
                    'url'  => url('viravira/customers/sync/' . $result->customer_id)
                ];
            }
        }

        // Set viravira customers
        session(['viravira_customers' => $customers]);
        Cache::put('viravira_customers', $customers, Date::now()->addHour(6));

        $json = [
            'errors' => ($results->success) ? false : $results->message[0]->text[0],
            'success' => $results->success,
            'count' => count($customers),
            'step' => $steps,
        ];

        return response()->json($json);
    }

    public function store($customer_id)
    {
        $customers = Cache::get('viravira_customers');

        if (empty($customers)) {
            $customers = session('viravira_customers');
        }

        dispatch(new CreateCustomer($customers[$customer_id]));

        $json = [
            'errors' => false,
            'success' => true,
        ];

        $last_customer = end($customers)->customer_id;

        if ($last_customer == $customer_id) {
            $json['finished'] = trans('viravira::general.finished', ['type' => trans_choice('viravira::general.types.customers',2)]);

            $timestamp = Date::now()->toRfc3339String();

            setting()->set('viravira.customer_last_check', $timestamp);
            setting()->save();
        }

        return response()->json($json);
    }
}
