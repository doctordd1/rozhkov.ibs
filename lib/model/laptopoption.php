<?
namespace Rozhkov\Ibs\Model;

use Bitrix\Main\{
    Entity\IntegerField,
    Entity\ReferenceField,
    Entity\DataManager,
};

class LaptopOptionTable extends DataManager
{
    public static function getTableName() {
        return "r_laptop_option";
    }

    public static function getMap() {
        return [
            (new IntegerField('OPTION_ID'))
            ->configurePrimary(true),
            (new ReferenceField('OPTION', OptionTable::class,
                ['this.OPTION_ID' => 'ref.ID']))
                ->configureJoinType('inner'),
            (new IntegerField('LAPTOP_ID'))
                ->configurePrimary(true),
            (new ReferenceField('LAPTOP', LaptopTable::class,
                ['this.LAPTOP_ID' => 'ref.ID']))
                ->configureJoinType('inner'),
        ];
    }
}