Faryshta Yii2 Enum
==================

[![Latest Stable Version](https://poser.pugx.org/faryshta/yii2-enum/v/stable)](https://packagist.org/packages/faryshta/yii2-enum) [![Total Downloads](https://poser.pugx.org/faryshta/yii2-enum/downloads)](https://packagist.org/packages/faryshta/yii2-enum) [![Latest Unstable Version](https://poser.pugx.org/faryshta/yii2-enum/v/unstable)](https://packagist.org/packages/faryshta/yii2-enum) [![License](https://poser.pugx.org/faryshta/yii2-enum/license)](https://packagist.org/packages/faryshta/yii2-enum)

Faryshta Yii2 Enum extension provides support for the ussage of enumarions in Yii2 models and forms.


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/Faryshta/yii2-enum/blob/master/composer.json) for this extension's requirements and dependencies.

To install, either run

```
$ php composer.phar require faryshta/yii2-enum "@dev"
```

or add

```
"faryshta/yii2-enum": "@dev "
```

to the `require` section of your `composer.json` file.

## Usage

### EnumTrait

```php
use faryshta\base\EnumTrait;

class Person extends \yii\base\Model
{
    use EnumTrait;

    public static function enums()
    {
        return [
            // this is the name of the enum.
            'gender' => [
                // here it follows the `'index' => 'desc'` notation
                'F' => 'Female',
                'M' => 'Male',
            ],
        ];
    }

    // optional magic method to access the value quickly
    public function getGenderDesc()
    {
        // method provided in the EnumTrait to get the description of the value
        // of the attribute
        return $this->getAttributeDesc('gender');
    }
}
```

### EnumValidator

```php
use faryshta\base\EnumTrait;
use faryshta\validator\EnumValidator;

class Person extends \yii\base\Model
{
    use EnumTrait;

    public $gender;

    public static function enums()
    {
        return [
            // this is the name of the enum.
            'gender' => [
                // here it follows the `'index' => 'desc'` notation
                'F' => 'Female',
                'M' => 'Male',
            ],
        ];
    }

    public function rules()
    {
        return [
            [
                ['gender'],
                EnumValidator::className(),

                // optional, if you want to use a diferent class than the
                // class of the current model
                // 'enumClass' => Person::className()

                // optional, if you want to use a diferent enum name than the
                // name of the attribute being validated
                // 'enumName' => 'gender'
            ],
        ];
    }
}
```

### Enum Widgets

In a view file

```php
use faryshta\widgets\EnumDropdown;
use faryshta\widgets\EnumRadio;

/**
 * @var Person $model
 * @var ActiveForm $form
 */

// with ActiveForm
echo $form->field($person, 'gender')->widget(EnumDropdown::className());

// without ActiveForm and with model.
echo EnumDropdown::widget([
    'model' => $person,
    'attribute' => 'gender',
]);

// without Model
echo EnumDropdown::widget([
    'name' => 'gender',
    'enumClass' => Person::className(),
    'enumName' => 'gender',
]);

// The same applies for the EnumRadio widget if you want to render a
// list of radio buttons
echo $form->field($person, 'gender')->widget(EnumRadio::className());
```

### EnumColumn

In a view file

```php
use faryshta\data\EnumColumn;
use yii\widgets\GridView;

echo GridView::widget([
    'searchModel' => $personSearch,
    'dataProvider' => $personDataProvider,
    'columns' => [
        'class' => EnumColumn::className(),
        'attribute' => 'gender',

        // optional, if you want to use a diferent class than the
        // class of the current model
        // 'enumClass' => Person::className()

        // optional, if you want to use a diferent enum name than the
        // name of the attribute being validated
        // 'enumName' => 'gender'
    ],
]);
```

## License

**Faryshta Yii2 Enum** is released under the BSD 3-Clause License. See the bundled `LICENSE.md` for details.
