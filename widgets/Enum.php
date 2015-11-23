<?php

namespace faryshta\widgets;

use faryshta\base\EnsureEnumTrait;

use yii\base\Html;
use yii\widgets\InputWidget;

/**
 * Creates a dropdown list for 
 */
class Enum extends InputWidget
{
    use EnsureEnumTrait;

    /**
     * @inheritdoc
     * @throws InvalidConfigException if the "mask" property is not set.
     */
    public function init()
    {
        parent::init();
        $this->ensureEnum($this->model, $this->attribute);
    }

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
