<?php

namespace faryshta\base;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Trait used to ensure the class and enum name provided are valid
 * @internal
 */
trait EnsureEnumTrait
{
    /**
     * @var array the enum to be used for the component.
     */
    protected $enum;

    /**
     * @var string Class name from where the enum will be taken. If null  the
     * class of the model will be used instead
     */
    public $enumClass;

    /**
     * @var string name of the enum to be used. If null the name of the
     * attribute being will be used instead.
     */
    public $enumName;

    /**
     * makes sure the configured model and attribute have a valid enum
     */
    public function ensureEnum($model, $attribute)
    {
        $enumClass = $this->enumClass ?: get_class($model);
        $enumName = $this->enumName ?: $attribute;

        if (!method_exists($enumClass, 'getEnum')) {
            throw new InvalidConfigException('The model must use the '
                . '`\\faryshta\\base\\EnumTrait` trait or the "enumClass" '
                . 'property must be set to a class using that trait.'
            );
        }

        if (!is_array($this->enum = $enumClass::getEnum($enumName))) {
            throw new InvalidConfigException("'$enumName' as not found on the "
                . "set of enums for class '$enumClass'"
            );
        }
    }
}
