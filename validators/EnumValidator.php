<?php

namespace faryshta\validators;

use yii\validators\Validator;

/**
 * Validates that the attribute value is among the index list in an enum
 *
 * ```php
 * public function rules()
 * {
 *     return [
 *         [['payment'], 'faryshta\validators\EnumValidator'],
 *     ];
 * }
 * ```
 */
class EnumValidator extends Validator
{
    private $enum;

    /**
     * @var string Class name from where the enum will be taken. If null  the
     * class of the model being validated will be used instead.
     */
    public $enumClass;

    /**
     * @var string name of the enum to be used. If null the name of the
     * attribute being validated will be used instead.
     */
    public $enumName;


    /**
     * @var boolean whether the comparison is strict (both type and value must be the same)
     */
    public $strict = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is invalid.');
        }
    }

    public function ensureEnum($model, $attribute)
    {
        $enumClass = $this->enumClass ?: get_class($model);
        $enunName = $this->enumName ?: $attribute;

        if (!method_exists($enumClass, 'getEnum')) {
            throw new InvalidConfigException('The model must use the '
                . '`\\faryshta\\base\\EnumTrait` trait or the "enumClass" '
                . 'property must be set to a class using that trait.'
            );
        }

        if (null === ($enum = $enumClass::getEnum($enumName))) {
            throw new InvalidConfigException("'$enumName' as not found on the "
                . "set of enums for class '$enumClass'"
            );
        }

        $this->enum = array_keys($enum)
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $this->ensureEnum($model, $attribute);

        parent::validateAttribute($model, $attribute);
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        return ArrayHelper::isIn($value, $this->enum, $this->strict)
            ? null
            : [$this->message, []];
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $this->ensureEnum($model, $attribute);

        $options = [
            'range' => $this->enum,
            'not' => false,
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Yii::$app->language),
        ];

        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);
        return 'yii.validation.range(value, messages, ' . json_encode(
            $options,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ) . ');';
    }
}
