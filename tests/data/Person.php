<?php

namespace faryshta\tests\data;

use faryshta\base\EnumTrait;
use faryshta\validators\EnumValidator;

use yii\base\Model;

class Person extends Model
{
    use EnumTrait;

    const GENDER_FEMALE = 'F';
    const GENDER_MALE = 'M';

    public $gender;

    public static function enums()
    {
        return [
            'gender' => [
                self::GENDER_FEMALE => 'Female',
                self::GENDER_MALE => 'Male',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['gender'], EnumValidator::className()]
        ];
    }

    public function getGenderDesc()
    {
        return $this->getAttributeDesc('gender');
    }
}
