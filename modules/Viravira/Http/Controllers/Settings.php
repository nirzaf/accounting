<?php

namespace Modules\Viravira\Http\Controllers;

use Artisan;
use Illuminate\Http\Response;
use App\Models\Banking\Account;
use App\Models\Setting\Category;
use Illuminate\Routing\Controller;
use Modules\Viravira\Http\Requests\Setting as Request;

class Settings extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        $accounts = Account::enabled()->pluck('name', 'id');

        $product_categories = Category::enabled()->type('item')->pluck('name', 'id');
        $invoice_categories = Category::enabled()->type('income')->pluck('name', 'id');

        return view('viravira::edit', compact('accounts', 'product_categories', 'invoice_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        setting()->set('viravira.token', $request['token']);
        setting()->set('viravira.account_id', $request['account_id']);
        setting()->set('viravira.product_category_id', $request['product_category_id']);
        setting()->set('viravira.invoice_category_id', $request['invoice_category_id']);
        setting()->set('viravira.sync', $request['sync']);

        setting()->save();

        Artisan::call('cache:clear');

        flash(trans('viravira::general.success.settings_saved'))->success();

        return redirect('viravira/settings');
    }
}
