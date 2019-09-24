<?php

namespace Modules\Viravira\Http\Controllers;

use Date;
use Cache;
use Modules\Viravira\Traits\Remote;
use Modules\Viravira\Jobs\CreateItem;
use Illuminate\Routing\Controller;

class Products extends Controller
{

    use Remote;

    public function count()
    {
        $type = trans_choice('viravira::general.types.products',2);

        $response = $this->getProducts();

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
        $products = $steps = [];

        $results = $this->getProducts('getProducts');

        if (!empty($results) && ($results->success)) {
            foreach ($results->data as $result) {
                $products[$result->ProductId] = $result;

                $steps[] = [
                    'text' => trans('viravira::general.sync_text', ['type' => trans_choice('viravira::general.types.products',1), 'value' => $result->product_name]),
                    'url'  => url('viravira/products/sync/' . $result->ProductId)
                ];
            }
        }

        // Set viravira products
        session(['viravira_products' => $products]);
        Cache::put('viravira_products', $products, Date::now()->addHour(6));

        $json = [
            'errors' => ($results->success) ? false : $results->message[0]->text[0],
            'success' => $results->success,
            'count' => count($products),
            'step' => $steps,
        ];

        return response()->json($json);
    }

    public function store($product_id)
    {
        $products = Cache::get('viravira_products');

        if (empty($products)) {
            $products = session('viravira_products');
        }

        dispatch(new CreateItem($products[$product_id]));

        $json = [
            'errors' => false,
            'success' => true,
        ];

        $last_product = end($products)->ProductId;

        if ($last_product == $product_id) {
            $json['finished'] = trans('viravira::general.finished', ['type' => trans_choice('viravira::general.types.products',2)]);

            $timestamp = Date::now()->toRfc3339String();

            setting()->set('viravira.product_last_check', $timestamp);
            setting()->save();
        }

        return response()->json($json);
    }
}
