<?php

namespace faryshta\widgets;

use yii\helpers\Html;

/**
 * Creates a dropdown list using an enum.
 */
class EnumRadio extends EnumBase
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeRadioList(
                $this->model,
                $this->attribute,
                $this->enum,
                $this->options
            );
        } else {
            echo Html::radioList(
                $this->name,
                $this->value,
                $this->enum,
                $this->options
            );
        }
    }
}
