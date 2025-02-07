<?php

return [
    'required' => ':attribute الزامی است.',
    'string' => ':attribute باید از نوع رشته باشد',
    'confirmed' => ':attribute با تکرار آن مطابقت ندارد.',
    'email' => 'فرمت ایمیل نامعتبر است.',
    'unique' => ':attribute تکراری است.',
    'exists' => ':attribute نامعتبر است.',
    'min' => [
        'string' => ':attribute باید حداقل :min کاراکتر باشد.'
    ],
    'max' => [
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.'
    ],

    'attributes' => [
        'title' => 'عنوان',
        'content' => 'محتوا',
        'status' => 'وضعیت پست',
        'email' => 'ایمیل',
        'username' => 'نام کاربری',
        'password' => 'رمزعبور',
        'password_confirmation' => 'تکرار رمزعبور'
    ]
];
