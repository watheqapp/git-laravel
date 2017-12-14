<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted'             => 'يجب قبول الحقل :attribute',
    'active_url'           => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after'                => 'التاريخ منتهى',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف',
    'alpha_dash'           => 'يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num'            => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array'                => 'يجب أن يكون الحقل :attribute ًمصفوفة',
    'before'               => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal'      => 'الحقل :attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between'              => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
        'array'   => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
    ],
    'boolean'              => 'يجب أن تكون قيمة الحقل :attribute إما true أو false ',
    'confirmed'            => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date'                 => 'الحقل :attribute ليس تاريخًا صحيحًا',
    'date_format'          => 'لا يتوافق الحقل :attribute مع الشكل :format.',
    'different'            => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits'               => 'يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام',
    'digits_between'       => 'يجب أن يحتوي الحقل :attribute بين :min و :max رقمًا/أرقام ',
    'dimensions'           => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct'             => 'للحقل :attribute قيمة مُكرّرة.',
    'email'                => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'exists'               => 'الحقل :attribute لاغٍ',
    'file'                 => 'الـ :attribute يجب أن يكون من ملفا.',
    'filled'               => 'الحقل :attribute إجباري',
    'image'                => 'يجب أن يكون الحقل :attribute صورةً',
    'in'                   => 'الحقل :attribute لاغٍ',
    'in_array'             => 'الحقل :attribute غير موجود في :other.',
    'integer'              => 'يجب أن يكون الحقل :attribute عددًا صحيحًا',
    'ip'                   => 'يجب أن يكون الحقل :attribute عنوان IP ذا بُنية صحيحة',
    'json'                 => 'يجب أن يكون الحقل :attribute نصا من نوع JSON.',
    'max'                  => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أصغر لـ :max.',
        'file'    => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'string'  => 'عذراً الحد الأقصى هو :max أحرف',
        'array'   => 'يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes'                => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'mimetypes'            => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'min'                  => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أكبر لـ :min.',
        'file'    => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'string'  => 'عذراً الحد الأدنى هو :min أحرف',
        'array'   => 'يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر',
    ],
    'not_in'               => 'الحقل :attribute لاغٍ',
    'numeric'              => 'يجب على الحقل :attribute أن يكون رقمًا',
    'present'              => 'يجب تقديم الحقل :attribute',
    'regex'                => 'صيغة الحقل :attribute .غير صحيحة',
    'required'             => 'الرجاء ادخال قيمة الحقل',
    'required_if'          => 'الرجاء ادخال قيمة :attribute',
    'required_unless'      => 'الحقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with'        => 'الحقل :attribute إذا توفّر :values.',
    'required_with_all'    => 'الحقل :attribute إذا توفّر :values.',
    'required_without'     => 'الحقل :attribute إذا لم يتوفّر :values.',
    'required_without_all' => 'الحقل :attribute إذا لم يتوفّر :values.',
    'same'                 => 'يجب أن يتطابق الحقل :attribute مع :other',
    'size'                 => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية لـ :size',
        'file'    => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'string'  => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
        'array'   => 'يجب أن يحتوي الحقل :attribute على :size عنصرٍ/عناصر بالظبط',
    ],
    'string'               => 'يجب أن يكون الحقل :attribute نصآ.',
    'timezone'             => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique'               => 'قيمة الحقل :attribute مُستخدمة من قبل',
    'uploaded'             => 'فشل في تحميل الـ :attribute',
    'url'                  => 'صيغة الرابط :attribute غير صحيحة',
    'unique_with' => 'تم ادخال هذه القيم من قبل',
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
    'custom'               => [
        'custom' => [
            'g-recaptcha-response' => [
                'required' => 'Please verify that you are not a robot.',
                'captcha' => 'Captcha error! try again later or contact site admin.',
            ],
        ],
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    'saudi_phone' => "يجب أن يكون الجوال بالصيغة الصحيحة",

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
    'attributes'           => [
        'name'                  => 'الاسم',
        'username'              => 'اسم المُستخدم',
        'email'                 => 'البريد الالكتروني',
        'first_name'            => 'الاسم',
        'last_name'             => 'اسم العائلة',
        'password'              => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city'                  => 'المدينة',
        'country'               => 'الدولة',
        'address'               => 'العنوان',
        'phone'                 => 'الجوال',
        'mobile'                => 'الجوال',
        'age'                   => 'العمر',
        'sex'                   => 'الجنس',
        'gender'                => 'النوع',
        'day'                   => 'اليوم',
        'month'                 => 'الشهر',
        'year'                  => 'السنة',
        'hour'                  => 'ساعة',
        'minute'                => 'دقيقة',
        'second'                => 'ثانية',
        'title'                 => 'اللقب',
        'content'               => 'المُحتوى',
        'description'           => 'الوصف',
        'excerpt'               => 'المُلخص',
        'date'                  => 'التاريخ',
        'time'                  => 'الوقت',
        'available'             => 'مُتاح',
        'size'                  => 'الحجم',
    ],
];