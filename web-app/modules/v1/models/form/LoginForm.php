<?php

namespace WebApp\modules\v1\models\form;

use common\models\AppSetting;
use common\models\Device;
use Yii;
use yii\base\Model;
use common\models\User;
use mrt\microsoft\MsMember;

class LoginForm extends Model
{
    public $username;
    public $password;
    // public $device_id;
    // public $app_version;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            // [['device_id'], 'safe'],
            // [['app_version'], 'integer'],
            // ['username', 'getStatusUser'],
            ['password', 'validatePassword'],
            // ['device_id', 'deviceCheck'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }


    public function validatePassword($attribute, $params)
    {
        // var_dump("OK")
        // ;die();
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || (!$user->validatePassword($this->password))) {
                $this->addError($attribute, 'Incorrect username or password.');
            } else {
                $user->generateAuthKey();
                $user->update();
            }
        }
    }

    public function validateWithLDAPPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, 'Incorrect username, please register to Admin');
            } else {
                if ($user->is_ldap == 1) {
                    // check to Ldap
                    if (!Yii::$app->ad->auth()->attempt($this->username, $this->password)) {
                        $this->addError($attribute, 'failed Auth Ldap');
                    }
                    $user->generateAuthKey();
                    // $user->browser = $_SERVER['HTTP_USER_AGENT'];
                    $user->is_onduty = 1;
                    $user->update();
                } elseif (!$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Incorrect password');
                }
                $user->generateAuthKey();
                $user->update();
            }
            
            if ($user->is_ldap == 0) { //login via DB
                if (!$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Incorrect password');
                    return false;
                }
                // $user->browser = $_SERVER['HTTP_USER_AGENT'];
                $user->generateAuthKey();
                $user->is_onduty = 1;
                $user->update();
            }
        }
    }

    public function validateMSPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user) {
                $this->addError($attribute, 'user not exist. Please contact Duty Manager');
                return false;
            } else {
                
                if ($user->auth_type == 0) { //login via DB
                    if (!$user->validatePassword($this->password)) {
                        $this->addError($attribute, 'Incorrect password');
                        return false;
                    }
                    // $user->browser = $_SERVER['HTTP_USER_AGENT'];
                    // $user->version_code = $this->version_code;
                    $user->generateAuthKey();
                    $user->update();
                }
            }
        }
    }

    public function getStatusUser($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user) {
                if ($user->status == User::STATUS_INACTIVE) {
                    $this->addError($attribute, 'Username inactive. Please contact Administrator.');
                }
            } else {
                $this->addError($attribute, 'Incorrect username or password. Please contact Administrator user.');
            }
        }
    }



    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
