<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'يجب أن يتم القبول على خانة :attribute.',
    'active_url'           => 'خانة :attribute تحتوي على رابط غير صحيح.',
    'after'                => 'يجب على خانة :attribute أن تكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal'       => 'يجب على خانة :attribute أن تكون تاريخًا لاحقًا أو مطابقًا للتاريخ :date.',
    'alpha'                => 'يجب أن تحتوي خانة :attribute على أحرف فقط.',
    'alpha_dash'           => 'يجب أن تحتوي خانة :attribute على أحرف وأرقام وشرطات فقط.',
    'alpha_num'            => 'يجب أن تحتوي خانة :attribute على أحرف وأرقام فقط.',
    'array'                => 'يجب أن تكون خانة :attribute من نوع مصفوفة.',
    'before'               => 'يجب على خانة :attribute أن تكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal'      => 'يجب على خانة :attribute أن تكون تاريخًا سابقًا أو مطابقًا للتاريخ :date.',
    'between'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file'    => 'يجب أن تكون خانة :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن تكون عدد حروف النّص :attribute بين :min و :max.',
        'array'   => 'يجب أن تحتوي خانة :attribute على عدد من العناصر بين :min و :max.',
    ],
    'boolean'              => 'يجب أن تكون قيمة :attribute إما صحيحًا أو خاطئًا.',
    'confirmed'            => 'خانة التأكيد غير متطابقة مع خانة :attribute.',
    'date'                 => 'خانة :attribute ليست تاريخًا صحيحًا.',
    'date_format'          => 'خانة :attribute غير متوافقة مع التنسيق :format.',
    'different'            => 'يجب أن تكون الخانتان :attribute و :other مُختلفتان.',
    'digits'               => 'يجب أن تحتوي خانة :attribute على عدد :digits من الأرقام.',
    'digits_between'       => 'يجب أن تحتوي خانة :attribute على عدد من الأرقام بين :min و :max.',
    'dimensions'           => 'خانة :attribute تحتوي على أبعاد صورة غير صالحة.',
    'distinct'             => 'خانة :attribute تحتوي على قيمة مكررة.',
    'email'                => 'يجب أن تحتوي خانة :attribute على عنوان بريد إلكتروني صحيح.',
    'exists'               => 'الخانة المحددة :attribute غير صالحة.',
    'file'                 => 'يجب أن تحتوي خانة :attribute على ملف.',
    'filled'               => 'يجب أن تحتوي خانة :attribute على قيمة.',
    'image'                => 'يجب أن تكون خانة :attribute عبارة عن صورة.',
    'in'                   => 'الخانة المحددة :attribute غير صالحة.',
    'in_array'             => 'خانة :attribute غير موجود في :other.',
    'integer'              => 'يجب أن تحتوي خانة :attribute على عددًا صحيحًا.',
    'ip'                   => 'يجب أن تحتوي خانة :attribute على عنوان IP صحيحًا.',
    'json'                 => 'يجب أن تحتوي خانة :attribute على نصًا صحيحًا من نوع JSON.',
    'max'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر من :max.',
        'file'    => 'خانة :attribute يجب ألا تكون أكبر من :max كيلوبايت.',
        'string'  => 'يجب ألا تتجاوز خانة :attribute على عدد أكبر من :max من الأحرف.',
        'array'   => 'يجب ألا تتجاوز خانة :attribute على أكثر من :max من العناصر.',
    ],
    'mimes'                => 'يجب أن تكون خانة :attribute ملفًا من النوع: :values.',
    'mimetypes'            => 'يجب أن تكون خانة :attribute ملفًا من النوع: :values.',
    'min'                  => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :min.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string'  => 'يجب أن تحتوي خانة :attribute على عدد :min من الأحرف على الأقل.',
        'array'   => 'يجب أن تحتوي خانة :attribute على عدد :min من العناصر على الأقل.',
    ],
    'not_in'               => 'الخانة المحددة :attribute غير صالحة.',
    'numeric'              => 'يجب أن تحتوي خانة :attribute على عددًا صحيحًا.',
    'present'              => 'يجب أن تكون خانة :attribute موجوداً.',
    'regex'                => 'صيغة :attribute غير صحيحة.',
    'required'             => 'الخانة :attribute إلزامية.',
    'required_if'          => 'الخانة :attribute إلزامية إذا كانت خانة :other تساوي :value.',
    'required_unless'      => 'الخانة :attribute تكون إلزامية ما لم تكن خانة :other تحتوي على :values.',
    'required_with'        => 'الخانة :attribute إلزامية إذا توفّر :values.',
    'required_with_all'    => 'الخانة :attribute إلزامية إذا توفّر :values.',
    'required_without'     => 'الخانة :attribute إلزامية إذا لم يتوفّر :values.',
    'required_without_all' => 'الخانة :attribute إلزامية إذا لم يتوفّر أياً من :values.',
    'same'                 => 'يجب أن تتطابق خانة :attribute مع :other.',
    'size'                 => [
        'numeric' => 'يجب أن تكون قيمة خانة :attribute مساوية للعدد :size.',
        'file'    => 'يجب أن يكون حجم الملف :attribute يساوي :size كيلوبايت.',
        'string'  => 'يجب أن يحتوي خانة :attribute على :size حرف/أحرف.',
        'array'   => 'يجب أن تحتوي خانة :attribute على :size من العناصر.',
    ],
    'string'               => 'يجب أن تكون خانة :attribute نصًا.',
    'timezone'             => 'يجب أن تكون خانة :attribute نطاقًا زمنيًا صحيحًا.',
    'unique'               => 'قيمة :attribute مُستخدمة من قبل.',
    'uploaded'             => 'فشل في رفع :attribute.',
    'url'                  => 'صيغة :attribute غير صحيحة.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة مخصصة',
        ],
        'invalid_currency' => 'رمز خانة :attribute غير صحيحة.',
        'invalid_amount'   => 'The amount :attribute is invalid.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
