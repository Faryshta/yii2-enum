<?php

namespace faryshta\widgets;

use faryshta\base\EnsureEnumTrait;

use yii\widgets\InputWidget;

/**
 * Initializes a widget to use enum.
 */
abstract class EnumBase extends InputWidget
{
    use EnsureEnumTrait;

    /**
     * @inheritdoc
     * @throws InvalidConfigException no enum can be ensured.
     */
    public function init()
    {
        parent::init();
        $this->ensureEnum($this->model, $this->attribute);
    }
}
