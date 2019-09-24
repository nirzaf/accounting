<?php

namespace Modules\Viravira\Http\Controllers;

use Date;
use Cache;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Viravira\Traits\Remote;

class Sync extends Controller
{
    use Remote;

    public function count()
    {
        $all = true;
        $response = $this->getOrders();

        $orders = 0;

        if ($response && ($response->success)) {
            $orders = $response->total;
        }

        $response = $this->getProducts();

        $products = 0;

        if ($response && ($response->success)) {
            $products = $response->total;
        }

        $response = $this->getCustomers();

        $customers = 0;

        if ($response && ($response->success)) {
            $customers = $response->total;
        }

        $html = view('viravira::partial.sync', compact('all', 'customers', 'products', 'orders'))->render();

        $json = [
            'errors' => false,
            'success' => true,
            'count' => $customers + $products + $orders,
            'html' => $html
        ];

        return response()->json($json);
    }

    public function sync()
    {
        // Set viravira customers
        $customers = $products = $orders = $steps = [];

        $results = $this->getCustomers();

        if (!empty($results) && ($results->success)) {
            foreach ($results->data as $result) {
                $customers[$result->customer_id] = $result;

                $customer_name = $result->first_name . ' ' . $result->first_name;

                $steps[] = [
                    'text' => trans('viravira::general.sync_text', ['type' => trans_choice('viravira::general.types.customers',1), 'value' => $customer_name]),
                    'url'  => url('viravira/customers/sync/' . $result->customer_id)
                ];
            }
        }

        // Set viravira customers
        session(['viravira_customers' => $customers]);
        Cache::put('viravira_customers', $customers, Date::now()->addHour(6));

        // Start Product Steps
        $results = $this->getProducts('getProducts');

        if (!empty($results) && ($results->success)) {
            foreach ($results->data as $result) {
                $products[$result->product_id] = $result;

                $steps[] = [
                    'text' => trans('viravira::general.sync_text', ['type' => trans_choice('viravira::general.types.products',1), 'value' => $result->product_name]),
                    'url'  => url('viravira/products/sync/' . $result->product_id)
                ];
            }
        }

        // Set viravira products
        session(['viravira_products' => $products]);
        Cache::put('viravira_products', $products, Date::now()->addHour(6));

        // Start Order Steps
        $results = $this->getOrders();

        if (!empty($results) && $results->success) {
            foreach ($results->data as $result) {
                $orders[$result->order_id] = $result;

                $order_steps[] = [
                    'text' => trans('viravira::general.sync_text', ['type' => trans_choice('viravira::general.types.orders',1), 'value' => $result->order_code]),
                    'url'  => url('viravira/orders/sync/' . $result->order_id),
                ];
            }
        }

        krsort($orders);
        krsort($order_steps);
        sort($order_steps);

        // Set viravira orders
        session(['viravira_orders' => $orders]);
        Cache::put('viravira_orders', $orders, Date::now()->addHour(6));

        foreach ($order_steps as $order_step) {
            $steps[] = $order_step;
        }

        // Set viravira orders
        session(['viravira_orders' => $orders]);
        Cache::put('viravira_orders', $orders, Date::now()->addHour(6));

        $json = [
            'errors' => false,
            'success' => true,
            'count' => count($customers),
            'step' => $steps,
        ];

        return response()->json($json);
    }
}
