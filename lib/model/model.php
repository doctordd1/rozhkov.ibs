<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\IntegerField,
    Entity\StringField,
    Entity\DataManager,
    Entity\ReferenceField,
    Type
};

class ModelTable extends DataManager
{
    public static function getTableName() {
        return "r_model_table";
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
            ),
            new IntegerField("BRAND_ID"),
            new ReferenceField(
                "BRAND", 
                '\rozhkov\ibs\model\BrandTable', 
                Array("=this.BRAND_ID" => "ref.ID") 
            ),
        );
    }

}
