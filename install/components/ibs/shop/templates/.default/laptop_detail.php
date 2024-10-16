<?php
$APPLICATION->IncludeComponent(
	"ibs:shop.detail", 
	".default", 
	array(
        "ID" => $arResult['VARIABLES']['LAPTOP'],
	),
	false
);