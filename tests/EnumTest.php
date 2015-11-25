<?php
namespace faryshta\tests;

use faryshta\tests\data\Person;

use faryshta\widgets\EnumDropdown;
use faryshta\widgets\EnumRadio;
use faryshta\data\EnumColumn;

/**
 * Test the functionality for the enum extension
 */
class EnumTest extends TestCase
{
    public function testEnumMethods()
    {
        $genders = Person::getEnum('gender');
        $this->assertArrayHasKey(Person::GENDER_FEMALE, $genders);
        $this->assertArrayHasKey(Person::GENDER_MALE, $genders);

        $this->assertEquals(
            'Female',
            Person::getEnumDesc('gender', Person::GENDER_FEMALE)
        );
        $this->assertEquals(
            'Male',
            Person::getEnumDesc('gender', Person::GENDER_MALE)
        );

        $this->assertNull(Person::getEnum('unexistant'));
        $this->assertNull(Person::getEnumDesc('gender', 'X'));
        $this->assertNull(Person::getEnumDesc('gender', ''));
        $this->assertNull(Person::getEnumDesc('gender', null));
    }

    public function testEnumModel()
    {
        $model = new Person();

        $this->assertNull($model->getAttributeDesc('gender'));
        $this->assertNull($model->genderDesc);

        $model->gender = Person::GENDER_FEMALE;
        $this->assertEquals('Female', $model->getAttributeDesc('gender'));
        $this->assertEquals('Female', $model->genderDesc);
    }

    public function testValidation()
    {
        $model = new Person();
        $this->assertFalse($model->validate());

        $model->gender = 'X';
        $this->assertFalse($model->validate());

        $model->gender = Person::GENDER_FEMALE;
        $this->assertTrue($model->validate());
    }

    public function testWidget()
    {
        $html = <<<HTML
<select id="w0" name="gender">
<option value="F">Female</option>
<option value="M">Male</option>
</select>
HTML;
        $this->assertEquals($html, EnumDropdown::widget([
            'name' => 'gender',
            'enumClass' => Person::className(),
            'enumName' => 'gender',
        ]));

        $html = <<<HTML
<div id="w1"><label><input type="radio" name="gender" value="F"> Female</label>
<label><input type="radio" name="gender" value="M"> Male</label></div>
HTML;
        $this->assertEquals($html, EnumRadio::widget([
            'name' => 'gender',
            'enumClass' => Person::className(),
            'enumName' => 'gender',
        ]));
    }
}
