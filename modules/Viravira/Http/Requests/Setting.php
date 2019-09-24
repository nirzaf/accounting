<?php

namespace Modules\Viravira\Http\Requests;

use App\Http\Requests\Request;

class Setting extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'token' => 'required|string',
            'account_id' => 'required|integer',
            'product_category_id' => 'required|integer',
            'invoice_category_id' => 'required|integer',
        ];

        return $rules;
    }
}
