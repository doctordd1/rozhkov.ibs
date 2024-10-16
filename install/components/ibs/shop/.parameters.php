<?
$arComponentParameters = [
    "PARAMETERS" => [
        "VARIABLE_ALIASES" => [
            "LAPTOP_ID" => [
                "NAME" => 'GET параметр для ID ноутбука без ЧПУ',
                "DEFAULT" => "ELEMENT_ID",
            ],
            "BRAND_ID" => [
                "NAME" => 'GET параметр для ID производителя без ЧПУ',
                "DEFAULT" => "BRAND_ID",
            ],
            "MODEL_ID" => [
                "NAME" => 'GET параметр для ID модели без ЧПУ',
                "DEFAULT" => "MODEL_ID",
            ],
            "CATALOG_URL" => [
                "NAME" => 'Базовый URL каталога без ЧПУ',
                "DEFAULT" => "/test/",
            ]
        ],
        "SEF_MODE" => [
            "model" => [
                "NAME" => 'Страница моделей',
                "DEFAULT" => "#BRAND#/",
            ],
            "laptop" => [
                "NAME" => 'Страница ноутбуков',
                "DEFAULT" => "#BRAND#/#MODEL#/",
            ],
            "laptop_detail" => [
                "NAME" => 'Страница ноутбука',
                "DEFAULT" => "#BRAND#/#MODEL#/#LAPTOP#/",
            ],
        ],
    ]
];