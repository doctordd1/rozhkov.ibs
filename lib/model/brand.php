<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\IntegerField,
    Entity\StringField,
    Entity\DataManager,
};

class BrandTable extends DataManager
{
    public static function getTableName() {
        return "r_brand_table";
    }

    public static function getMap() {
        return [
            new IntegerField(
                "ID",
                [
                    "primary" => true,
                    "autocomplete" => true,
                ]
            ),
            new StringField(
                "NAME",
                [
                    "required" => true
                ]
            )
        ];
    }

}
