<?php

namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    const SCENARIO_FIZ = 'scenario_' . User::TYPE_FIZ;
    const SCENARIO_IP = 'scenario_' . User::TYPE_IP;
    const SCENARIO_ORG = 'scenario_' . User::TYPE_ORG;

    public $type = User::TYPE_FIZ;

    public $username;
    public $email;
    public $password;

    public $real_name;
    public $INN;
    public $org_name;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['email', 'real_name', 'INN', 'org_name'], 'trim'],
            [['email', 'real_name'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['INN', 'required', 'on' => [self::SCENARIO_IP, self::SCENARIO_ORG, self::SCENARIO_FIZ]],
            ['org_name', 'required', 'on' => self::SCENARIO_ORG],
            ['INN', 'string', 'length' => 10, 'on' => self::SCENARIO_ORG],
            ['INN', 'string', 'length' => 12, 'on' => self::SCENARIO_IP],
            ['type', 'in', 'range' => array_keys(User::TYPES)],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_FIZ] = ['username', 'password', 'email', 'real_name'];
        $scenarios[self::SCENARIO_IP] = array_merge($scenarios[self::SCENARIO_FIZ], ['INN']);
        $scenarios[self::SCENARIO_ORG] = array_merge($scenarios[self::SCENARIO_IP], ['org_name']);
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Регистрируетесь как',
            'username' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'INN' => 'ИНН',
            'real_name' => 'ФИО',
            'org_name' => 'Организация',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        $this->setScenario("scenario_$this->type");

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->type = $this->type;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        switch ($user->type) {
            case User::TYPE_ORG:
                $user->org_name = $this->org_name;
            case User::TYPE_IP:
                $user->INN = $this->INN;
            default:
                $user->real_name = $this->real_name;
        }

        return $user->save() ? $user : null;
    }
}
