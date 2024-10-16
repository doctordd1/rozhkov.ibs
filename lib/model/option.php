<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\IntegerField,
    Entity\StringField,
    Entity\DataManager,
    Type
};
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

class OptionTable extends DataManager
{
    public static function getTableName() {
        return "r_option_table";
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
            (new ManyToMany('LAPTOPS', LaptopTable::class))
            ->configureTableName('r_laptop_option')
        );
    }
}