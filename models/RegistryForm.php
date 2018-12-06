<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password
 * @property string $passwordRepeat
 */
class RegistryForm extends ActiveRecord
{
    public $name;
    public $login;
    public $password;
    public $passwordRepeat;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'login', 'password'], 'required'],
            [['name', 'login'], 'string', 'min' => 3,'max' => 50],
            [['password'], 'string', 'min' => 5, 'max' => 30],
            [['login'], 'unique'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'operator' => '=='],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'name' => 'Имя',
            'login' => 'Логин',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повтор пароля',
        ];
    }
}
