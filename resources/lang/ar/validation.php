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

    'accepted' => 'يجب قبول السمة.',
    'active_url' => ': السمة ليست عنوان URL صالحًا.',
    'after' => 'يجب أن يكون  تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون  تاريخًا بعد أو يساوي :date.',
    'alpha' => 'قد يحتوي  على أحرف فقط.',
    'alpha_dash' => 'لا يجوز أن تحتوي  إلا على أحرف وأرقام وشرطات وشرطات سفلية.',
    'alpha_num' => 'لا يجوز أن يحتوي  إلا على أحرف وأرقام.',
    'array' => 'يجب أن يكون  مصفوفة.',
    'before' => 'يجب أن يكون  تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون  تاريخًا يسبق أو يساوي :date.',
    "between" => [
    'numeric' => 'يجب أن يكون  بين: min و: max.',
        'file' => 'يجب أن يكون  بين: min و: max كيلوبايت.',
        'string' => 'يجب أن يكون  بين: min و: max أحرف.',
        'array' => 'يجب أن تحتوي  على ما بين: min و: max items.',
    ] ,
    'boolean' => 'يجب أن يكون حقل السمة صحيحًا أو خطأ.',
    'confirmed' => 'تأكيد السمة غير متطابق.',
    'date' => '  ليس تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون  تاريخًا مساويًا لـ :date.',
    'date_format' => ': السمة لا تطابق التنسيق :format.',
    'different' => 'يجب أن يكون  و: other مختلفين.',
    'digits' => 'يجب أن يكون : digits digits.',
    'digits_between' => '  يجب أن تكون بين: min و: max digits.',
    'dimensions' => ': السمة لها أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل السمة على قيمة مكررة.',
    'email' => 'يجب أن يكون  عنوان بريد إلكتروني صالحًا.',
    'end_with' => ': يجب أن تنتهي السمة بواحد مما يلي: القيم.',
    'exists' => 'المحدد: السمة غير صالحة.',
    'file' => 'يجب أن يكون  ملفًا.',
    'filled' => 'يجب أن يحتوي حقل السمة على قيمة.',
    'gt' => [
    'numeric' => 'يجب أن يكون  أكبر من: value.',
        'file' => 'يجب أن تكون سمة  أكبر من: value كيلوبايت.',
        'string' => 'يجب أن يكون  أكبر من: value character.',
        'array' => 'يجب أن يحتوي  على أكثر من: value items.',
    ] ,
    'gte' => [
    'numeric' => 'يجب أن يكون  أكبر من أو يساوي: value.',
        'file' => 'يجب أن يكون  أكبر من أو يساوي: value كيلوبايت.',
        'string' => 'يجب أن يكون  أكبر من أو يساوي: value character.',
        'array' => 'يجب أن تحتوي  على: value items أو أكثر.',
    ] ,
    'image' => 'يجب أن يكون  صورة.',
    'in' => 'المحدد: السمة غير صالحة.',
    'in_array' => 'الحقل  غير موجود في: other.',
    'integer' => 'يجب أن يكون  عددًا صحيحًا.',
    'ip' => 'يجب أن يكون  عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون  عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون  عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون  سلسلة JSON صالحة.',
    'lt' => [
    'numeric' => 'يجب أن يكون  أقل من: value.',
        'file' => 'يجب أن يكون حجم السمة: أقل من: value كيلوبايت.',
        'string' => 'يجب أن يكون  أقل من: value character.',
        'array' => 'يجب أن يحتوي  على أقل من: value items.',
    ] ,
'lte' => [
    'numeric' => 'يجب أن يكون  أقل من أو يساوي: value.',
        'file' => 'يجب أن يكون  أقل من أو يساوي: value كيلوبايت.',
        'string' => 'يجب أن يكون  أقل من أو يساوي: value character.',
        'array' => 'يجب ألا تحتوي  على أكثر من: value items.',
    ] ,
    "max" => [
    'numeric' => '  قد لا تكون أكبر من: max.',
        'file' => 'قد لا يكون  أكبر من: max كيلوبايت.',
        'string' => 'لا يجوز أن يكون  أكبر من: max character.',
        'array' => 'لا يجوز أن تحتوي  على أكثر من: max items.',
    ] ,
'mimes' => 'يجب أن يكون  ملفًا من النوع: القيم.',
    'mimetypes' => 'يجب أن يكون  ملفًا من النوع:: values.',
    'min' => [
    'numeric' => 'يجب أن يكون  على الأقل: min.',
        'file' => 'يجب أن يكون حجم  على الأقل: min كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف  على الأقل: min من الأحرف.',
        'array' => 'يجب أن تحتوي  على الأقل على: min items.',
    ] ,
'not_in' => 'السمة المحددة  غير صالحة.',
    'not_regex' => 'تنسيق  غير صالح.',
    'numeric' => 'يجب أن يكون  رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'يجب أن يكون حقل  موجودًا.',
    'regex' => 'تنسيق  غير صالح.',
    'required' => '  حقل مطلوب.',
    'required_if' => 'حقل  مطلوب عندما تكون قيمة :other :value',
    'required_unless' => 'حقل  مطلوب إلا إذا كان قيمة :other تساوي :values.',
    'required_with' => 'حقل  مطلوب عندما :values موجودة.',
    'required_with_all' => 'حقل  مطلوب عندما تكون :values موجودة.',
    'required_without' => 'حقل s مطلوب عندماتكون :values غير موجودة.',
    'required_without_all' => 'حقل  مطلوب في حالة عدم وجود أي من:values.',
    'same' => ' و :other يجب ان تكونا متطابقتان',
    "size" => [
    'numeric' => 'يجب أن يكون :attribute: size.',
        'file' => 'يجب أن يكون :attribute: size كيلوبايت.',
        'string' => 'يجب أن يكون :attribute: حجم الأحرف.',
        'array' => 'يجب أن يحتوي :attribute على: size items.',
    ] ,
    'begin_with' => ': يجب أن تبدأ السمة بواحد مما يلي: القيم.',
    'string' => 'يجب أن يكون :attribute عبارة عن سلسلة.',
    'timezone' => 'يجب أن يكون :attribute منطقة صالحة.',
    'unique' => ' مستخدمة بالفعل.',
    'uploaded' => 'فشل تحميل :attribute.',
    'url' => 'تنسيق السمة غير صالح.',
    'uuid' => ' يجب أن يكون UUID صالحًا.',

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
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
