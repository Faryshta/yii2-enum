<?php

namespace faryshta\base;

use yii\helpers\ArrayHelper;

/**
 * Defines a list of catalogues to be used for static terminologies on the
 * class. The structure is `['catalogue' => ['index' => 'term']]`
 *
 * Usage
 *
 * ```php
 * use yii\base\Model;
 * use faryshta\base\EnumTrait;
 *
 * class Order extends Model {
 *     use EnumTrait;
 *
 *     const PAYMENT_PENDING = 0;
 *     const PAYMENT_REJECTED = 1;
 *     const PAYMENT_ACCEPTED = 1;
 *
 *     public static function enums()
 *     {
 *         return [
 *             'payment_index' => [
 *                 self::PAYMENT_PENDING => Yii::t('app', 'Pending'),
 *                 self::PAYMENT_REJECTED => Yii::t('app', 'Rejected'),
 *                 self::PAYMENT_ACCEPTED => Yii::t('app', 'Accepted'),
 *             ],
 *         ];
 *     }
 *
 *     public function getPaymentStatus()
 *     {
 *         return $this->getAttributeDesc('payment_index');
 *     }
 * }
 * ```
 */
trait EnumTrait
{
    private static $_enums;

    /**
     * List of enums used for a model.
     *
     * @return array
     */
    public static function enums() {
        return [];
    }

    /**
     * Saves the enums on a variable to avoid repeating operations like
     * translations
     * @return array the enums of current model
     */
    public static function ensureEnums()
    {
        $class = get_called_class();
        if (!isset(self::$_enums[$class])) {
            self::$_enums[$class] = static::enums();
        }
        return self::$_enums[$class];
    }

    /**
     * Search an enum based on its name
     *
     * @param string $name enum to find
     * @return array|null the indexed terms or null if there is no catalogue
     */
    public static function getEnum($name)
    {
        return ArrayHelper::getValue(self::ensureEnums(), $name);
    }

    /**
     * Gets the description of an index inside an enum.
     *
     * @param string $name the name of the enum where the search is performed
     * @param string $index the index to find
     * @return mixed the catalogue defined term or null if not found
     */
    public static function getEnumDesc($name, $index)
    {
        return in_array($index, [null, ''], true) // return null on empty index
            ? null
            : ArrayHelper::getValue(self::getEnum($name), $index);
    }

    /**
     * Returns the enum description of an attribute
     *
     * @param string $attribute the attribute to find
     * @return mixed the description defined on the enum or null if not found
     */
    public function getAttributeDesc($attribute)
    {
        return static::getEnumDesc($attribute, $this->$attribute);
    }
}
