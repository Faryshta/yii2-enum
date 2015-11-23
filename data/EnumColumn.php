<?php

namespace faryshta\data;

use faryshta\base\EnsureEnumTrait;

use yii\base\Model;
use yii\grid\DataColumn;
use yii\helpers\ArrayHelper;

/**
 * Data column with default support for  enum
 */
class EnumColumn extends DataColumn
{
    use EnsureEnumTrait;

    /**
     * @inhertidoc
     */
    public function init()
    {
        parent::init();

        $this->ensureEnum($this->grid->filterModel, $this->attribute);

        if ($this->value === null) {
            $this->value = function ($model, $key, $index, $column) {
                return ArrayHelper::getValue(
                    $this->enum,
                    ArrayHelper::getValue($model, $this->attribute)
                );
            };
        }

        if ($this->filter === null) {
            $this->filter = $this->enum;
        }
    }
}
