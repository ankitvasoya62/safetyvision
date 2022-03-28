<?php

class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;
    
    public function rules() {
        return array(
            array('username, password', 'required'),
            array('username', 'email'),
            array('rememberMe', 'boolean'),
        );
    }

    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me',
            'username' => 'Email',
        );
    }

    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->errorCode = $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } elseif($this->_identity->errorCode == 1){
            $this->addError('username', 'User name doesn\'t exist.');
            return false;
        }  else {
            $this->addError('password', 'Please check your passord again.');
            return false;
        }
    }
}
