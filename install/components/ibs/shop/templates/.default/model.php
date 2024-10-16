<?php
$APPLICATION->IncludeComponent(
	"ibs:shop.list", 
	".default", 
	array(
        "ENTITY" => 'model',
        'FILTER' => [
            'BRAND_ID' => $arResult['VARIABLES']['BRAND']
        ]
	),
	false
);