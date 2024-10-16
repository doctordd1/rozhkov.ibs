<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>

<?php
$APPLICATION->setTitle($arResult['NAME_PAGE']);
$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [ 
    'GRID_ID' => $arResult['GRID_ID'], 
    'COLUMNS' => $arResult['COLUMNS'], 
    'ROWS' => $arResult['ROWS'], 
    'SHOW_ROW_CHECKBOXES' => false, 
    'NAV_OBJECT' => $arResult['OPTIONS']['nav_object'], 
    'AJAX_MODE' => 'Y', 
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''), 
    'PAGE_SIZES' => [ 
        ['NAME' => "5", 'VALUE' => '5'], 
        ['NAME' => '10', 'VALUE' => '10'], 
        ['NAME' => '20', 'VALUE' => '20'], 
        ['NAME' => '50', 'VALUE' => '50'], 
        ['NAME' => '100', 'VALUE' => '100'] 
    ], 
    'SHOW_CHECK_ALL_CHECKBOXES' => false, 
    'SHOW_ROW_ACTIONS_MENU'     => true, 
    'SHOW_GRID_SETTINGS_MENU'   => false, 
    'SHOW_NAVIGATION_PANEL'     => true, 
    'SHOW_PAGINATION'           => true, 
    'SHOW_SELECTED_COUNTER'     => false, 
    'SHOW_TOTAL_COUNTER'        => false, 
    'SHOW_PAGESIZE'             => true, 
    'SHOW_ACTION_PANEL'         => false, 
    'ALLOW_COLUMNS_SORT'        => false, 
    'ALLOW_COLUMNS_RESIZE'      => true, 
    'ALLOW_HORIZONTAL_SCROLL'   => true, 
    'ALLOW_SORT'                => true, 
    'ALLOW_PIN_HEADER'          => false, 
    'AJAX_OPTION_HISTORY'       => 'N' 
]);