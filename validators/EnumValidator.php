<?php

namespace faryshta\validators;

use faryshta\base\EnsureEnumTrait;

use Yii;
use     yii\helpers\ArrayHelper;
use yii\validators\Validator;
use yii\validators\ValidationAsset;

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
    use EnsureEnumTrait;

    /**
     * @inhertidoc
     */
    public $skipOnEmpty = false;

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
        return ArrayHelper::keyExists(
                $value,
                $this->enum,
                $this->strict
            ) ? null : [$this->message, []];
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $this->ensureEnum($model, $attribute);

        $options = [
            'range' => array_map('strval', array_keys($this->enum)),
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
