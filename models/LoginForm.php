<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $medworkerid;
    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function login()

    {
//        var_dump(  '<pre>' . print_r( '$blogOragir',true) .'</pre>');exit;

       if ($this->validate()) {
           $userArr = $this->getUser();
           //$_SESSION['username'] = $userArr['id'];
           $this->medworkerid = $userArr['id'];
           return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
       }
       else{
           $_SESSION['username']='';
           return false;
       }

        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;

    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
    public function getMedWorker()
    {
        return $this->medworkerid;
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Մուտքանուն',
            'password' => 'Գաղտնաբառ',
        ];
    }
}
