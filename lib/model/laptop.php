<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\ReferenceField,
    Entity\IntegerField,
    Entity\StringField,
    Entity\FloatField,
    Entity\DataManager,
    Type,
};
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

class LaptopTable extends DataManager
{
    public static function getTableName() {
        return "r_laptop_table";
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
            new IntegerField("MODEL_ID"),
            new FloatField('PRICE', array(
                'required' => true,
            )),
            new IntegerField('YEAR', array(
                'required' => true,
            )),
            new ReferenceField(
                "MODEL", 
                'Rozhkov\Ibs\Model\ModelTable', 
                Array("=this.MODEL_ID" => "ref.ID") 
            ),
            (new ManyToMany('OPTIONS', OptionTable::class))
				->configureTableName('r_laptop_option')
        );
    }
}