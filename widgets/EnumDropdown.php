<?php

namespace faryshta\widgets;

use yii\helpers\Html;

/**
 * Creates a dropdown list using an enum.
 */
class EnumDropdown extends EnumBase
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeDropDownList(
                $this->model,
                $this->attribute,
                $this->enum,
                $this->options
            );
        } else {
            echo Html::dropDownList(
                $this->name,
                $this->value,
                $this->enum,
                $this->options
            );
        }
    }
}
