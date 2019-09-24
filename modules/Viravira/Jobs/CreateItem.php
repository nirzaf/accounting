<?php

namespace Modules\Viravira\Jobs;

use App\Models\Common\Item;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateItem
{
    use Dispatchable;

    protected $item;

    /**
     * Create a new job instance.
     *
     * @param  $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $item_request = [
            'company_id'     => session('company_id'),
            'name'           => $this->item->prodcut_name,
            'sku'            => $this->item->prodcut_code,
            'description'    => empty($this->item->description) ? '' : $this->item->description,
            'sale_price'     => $this->item->price,
            'purchase_price' => $this->item->price,
            'quantity'       => empty($this->item->quantitiy) ? 0 : $this->item->quantitiy,
            'category_id'    => setting('viravira.product_category_id'),
            'tax_id'         => null,
            'enabled'        => '1',
        ];

        $item = Item::firstOrCreate($item_request);

        return $item;
    }
}
