<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\IntegerField,
    Entity\StringField,
    Entity\DataManager,
    Entity\ReferenceField,
};

class ModelTable extends DataManager
{
    public static function getTableName() {
        return "r_model_table";
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
            ),
            new IntegerField("BRAND_ID"),
            new ReferenceField(
                "BRAND", BrandTable::class, 
                ["=this.BRAND_ID" => "ref.ID"] 
            ),
        ];
    }

}
