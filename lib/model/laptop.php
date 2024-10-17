<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\ReferenceField,
    Entity\IntegerField,
    Entity\StringField,
    Entity\FloatField,
    Entity\DataManager,
};
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

class LaptopTable extends DataManager
{
    public static function getTableName() {
        return "r_laptop_table";
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
            new IntegerField("MODEL_ID"),
            new FloatField('PRICE', [
                'required' => true,
            ]),
            new IntegerField('YEAR', [
                'required' => true,
            ]),
            new ReferenceField(
                "MODEL", 
                ModelTable::class, 
                ["=this.MODEL_ID" => "ref.ID"]
            ),
            (new ManyToMany('OPTIONS', OptionTable::class))
				->configureTableName('r_laptop_option')
        ];
    }
}