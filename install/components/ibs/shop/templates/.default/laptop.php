<?php
$APPLICATION->IncludeComponent(
	"ibs:shop.list", 
	".default", 
	array(
        "ENTITY" => 'laptop',
        'FILTER' => [
            'MODEL_ID' => $arResult['VARIABLES']['MODEL']
        ]
	),
	false
);