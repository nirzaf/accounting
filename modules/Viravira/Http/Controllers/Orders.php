<?php

namespace Modules\Viravira\Http\Controllers;

use Date;
use Cache;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Viravira\Jobs\CreateInvoice;
use Modules\Viravira\Traits\Remote;

class Orders extends Controller
{
    use Remote;

    public function count()
    {
        $type = trans_choice('viravira::general.types.orders',2);

        $response = $this->getOrders();

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
        $orders = $steps = [];

        $results = $this->getOrders();

        if (!empty($results) && $results->success) {
            foreach ($results->data as $result) {
                $orders[$result->order_id] = $result;

                $steps[] = [
                    'text' => trans('viravira::general.sync_text', ['type' => trans_choice('viravira::general.types.orders',1), 'value' => $result->order_code]),
                    'url'  => url('viravira/orders/sync/' . $result->order_id),
                ];
            }
        }

        krsort($orders);
        krsort($steps);
        sort($steps);

        // Set viravira orders
        session(['viravira_orders' => $orders]);
        Cache::put('viravira_orders', $orders, Date::now()->addHour(6));

        $json = [
            'errors' => ($results->success) ? false : $results->message[0]->text[0],
            'success' => $results->success,
            'count' => count($orders),
            'step' => $steps,
        ];

        return response()->json($json);
    }

    public function store($order_id)
    {
        $orders = Cache::get('viravira_orders');

        if (empty($orders)) {
            $orders = session('viravira_orders');
        }

        $order = dispatch(new CreateInvoice($orders[$order_id]));

        $json = [
            'errors' => false,
            'success' => true,
        ];

        $last_order = array_first($orders)->order_id;

        if ($last_order == $order_id) {
            $json['finished'] = trans('viravira::general.finished', ['type' => trans_choice('viravira::general.types.orders',2)]);

            $timestamp = Date::now()->toRfc3339String();

            setting()->set('viravira.order_last_check', $timestamp);
            setting()->save();
        }

        return response()->json($json);
    }
}
