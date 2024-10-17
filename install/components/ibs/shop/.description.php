<?

use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    'NAME' => 'Компонент Магазин IBS', 
    'DESCRIPTION' => 'Компонент Магазин IBS',
	"COMPLEX" => "Y",
	"SORT" => 10,
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "ibs",
            "NAME" => Loc::getMessage("IBS_SHOP_NAME"),
            "SORT" => 30,
        )
    )
);