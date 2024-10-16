<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\IntegerField,
    Entity\StringField,
    Entity\DataManager,
    Type
};

class BrandTable extends DataManager
{
    public static function getTableName() {
        return "r_brand_table";
    }

    public static function getMap() {
        return Array(
            new IntegerField(
                "ID",
                Array(
                    "primary" => true,
                    "autocomplete" => true,
                )
            ),
            new StringField(
                "NAME",
                Array(
                    "required" => true
                )
            )
        );
    }

}
