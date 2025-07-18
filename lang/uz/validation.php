<?php

return [
    'accepted' => ":attribute maydoni qabul qilinishi shart.",
    'accepted_if' => ":other :value bo‘lsa, :attribute maydoni qabul qilinishi shart.",
    'active_url' => ":attribute maydoni haqiqiy URL bo‘lishi kerak.",
    'after' => ":attribute maydoni :date dan keyingi sana bo‘lishi kerak.",
    'after_or_equal' => ":attribute maydoni :date ga teng yoki undan keyin bo‘lishi kerak.",
    'alpha' => ":attribute maydoni faqat harflardan iborat bo‘lishi kerak.",
    'alpha_dash' => ":attribute maydoni faqat harflar, raqamlar va chiziqchalardan iborat bo‘lishi kerak.",
    'alpha_num' => ":attribute maydoni faqat harflar va raqamlardan iborat bo‘lishi kerak.",
    'array' => ":attribute maydoni massiv bo‘lishi kerak.",
    'before' => ":attribute maydoni :date dan oldingi sana bo‘lishi kerak.",
    'before_or_equal' => ":attribute maydoni :date ga teng yoki undan oldin bo‘lishi kerak.",
    'between' => [
        'numeric' => ":attribute maydoni :min va :max orasida bo‘lishi kerak.",
        'file' => ":attribute fayli :min va :max kilobayt orasida bo‘lishi kerak.",
        'string' => ":attribute maydoni :min va :max belgilar orasida bo‘lishi kerak.",
        'array' => ":attribute maydoni :min va :max element orasida bo‘lishi kerak.",
    ],
    'boolean' => ":attribute maydoni faqat true yoki false bo‘lishi kerak.",
    'confirmed' => ":attribute tasdiqlanishi mos kelmadi.",
    'date' => ":attribute haqiqiy sana bo‘lishi kerak.",
    'date_equals' => ":attribute maydoni :date ga teng sana bo‘lishi kerak.",
    'date_format' => ":attribute maydoni :format formatga mos kelishi kerak.",
    'different' => ":attribute va :other bir-biridan farq qilishi kerak.",
    'digits' => ":attribute maydoni :digits raqamdan iborat bo‘lishi kerak.",
    'digits_between' => ":attribute maydoni :min va :max raqam orasida bo‘lishi kerak.",
    'email' => ":attribute haqiqiy email manzil bo‘lishi kerak.",
    'exists' => "Tanlangan :attribute noto‘g‘ri.",
    'file' => ":attribute fayl bo‘lishi kerak.",
    'filled' => ":attribute maydoni to‘ldirilishi shart.",
    'gt' => [
        'numeric' => ":attribute maydoni :value dan katta bo‘lishi kerak.",
        'file' => ":attribute fayli :value kilobaytdan katta bo‘lishi kerak.",
        'string' => ":attribute maydoni :value belgidan katta bo‘lishi kerak.",
        'array' => ":attribute maydoni :value tadan ko‘p elementga ega bo‘lishi kerak.",
    ],
    'gte' => [
        'numeric' => ":attribute maydoni :value dan katta yoki teng bo‘lishi kerak.",
        'file' => ":attribute fayli :value kilobaytdan katta yoki teng bo‘lishi kerak.",
        'string' => ":attribute maydoni :value belgidan katta yoki teng bo‘lishi kerak.",
        'array' => ":attribute maydoni :value yoki undan ko‘p elementga ega bo‘lishi kerak.",
    ],
    'image' => ":attribute rasm bo‘lishi kerak.",
    'in' => "Tanlangan :attribute noto‘g‘ri.",
    'integer' => ":attribute butun son bo‘lishi kerak.",
    'ip' => ":attribute haqiqiy IP manzil bo‘lishi kerak.",
    'ipv4' => ":attribute haqiqiy IPv4 manzil bo‘lishi kerak.",
    'ipv6' => ":attribute haqiqiy IPv6 manzil bo‘lishi kerak.",
    'json' => ":attribute JSON formatda bo‘lishi kerak.",
    'max' => [
        'numeric' => ":attribute maydoni :max dan oshmasligi kerak.",
        'file' => ":attribute fayli :max kilobaytdan oshmasligi kerak.",
        'string' => ":attribute maydoni :max belgidan oshmasligi kerak.",
        'array' => ":attribute maydoni :max tadan oshmasligi kerak.",
    ],
    'mimes' => ":attribute quyidagi formatda bo‘lishi kerak: :values.",
    'mimetypes' => ":attribute quyidagi formatda bo‘lishi kerak: :values.",
    'min' => [
        'numeric' => ":attribute maydoni kamida :min bo‘lishi kerak.",
        'file' => ":attribute fayli kamida :min kilobayt bo‘lishi kerak.",
        'string' => ":attribute maydoni kamida :min belgidan iborat bo‘lishi kerak.",
        'array' => ":attribute maydoni kamida :min elementdan iborat bo‘lishi kerak.",
    ],
    'not_in' => "Tanlangan :attribute noto‘g‘ri.",
    'numeric' => ":attribute raqam bo‘lishi kerak.",
    'present' => ":attribute maydoni mavjud bo‘lishi kerak.",
    'regex' => ":attribute maydoni noto‘g‘ri formatda.",
    'required' => ":attribute maydoni majburiy.",
    'required_if' => ":other :value bo‘lsa, :attribute maydoni majburiy.",
    'required_unless' => ":other :values da bo‘lmasa, :attribute maydoni majburiy.",
    'required_with' => ":values mavjud bo‘lsa, :attribute maydoni majburiy.",
    'required_with_all' => ":values mavjud bo‘lsa, :attribute maydoni majburiy.",
    'required_without' => ":values mavjud bo‘lmasa, :attribute maydoni majburiy.",
    'required_without_all' => ":values lardan hech biri mavjud bo‘lmasa, :attribute maydoni majburiy.",
    'same' => ":attribute va :other bir xil bo‘lishi kerak.",
    'size' => [
        'numeric' => ":attribute :size bo‘lishi kerak.",
        'file' => ":attribute fayli :size kilobayt bo‘lishi kerak.",
        'string' => ":attribute :size belgidan iborat bo‘lishi kerak.",
        'array' => ":attribute :size elementdan iborat bo‘lishi kerak.",
    ],
    'string' => ":attribute matn bo‘lishi kerak.",
    'timezone' => ":attribute haqiqiy vaqt zonasi bo‘lishi kerak.",
    'unique' => ":attribute allaqachon mavjud.",
    'uploaded' => ":attribute yuklashda xatolik yuz berdi.",
    'url' => ":attribute haqiqiy URL bo‘lishi kerak.",

    'custom' => [
        // maxsus xabarlar uchun
    ],

    'attributes' => [
        'phone' => 'Telefon raqami',
        'oac_file' => 'OAC fayli',
        'work_order_file' => 'Ish buyurtmasi fayli',
        'direction_file' => 'Yo‘llanma fayli',
        'receipt_file' => 'To‘lov cheki fayli',
        'first_name' => 'Ism',
        'last_name' => 'Familiya',
        'middle_name' => 'Otasining ismi',
        // boshqa maydonlar...
    ],
];
