<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property integer $customer_id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $officephone
 * @property string $cellphone
 * @property string $expires
 * @property string $screens
 * @property integer $last_login
 * @property integer $create_at
 * @property integer $update_at
 * @property string $active
 * @property string $deleted
 * @property string $lang
 * @property string $origin_password
 * @property string $token
 * @property string $keywords
 */
class User extends CActiveRecord {

    public function tableName() {
        return '{{user}}';
    }

    public function rules() {
        return array(
            array('customer_id, last_login, create_at, update_at', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 120),
            array('name', 'length', 'max' => 200),
            array('password, origin_password, token', 'length', 'max' => 32),
            array('officephone, cellphone', 'length', 'max' => 60),
            array('expires', 'length', 'max' => 10),
            array('screens', 'length', 'max' => 255),
            array('active, deleted', 'length', 'max' => 1),
            array('lang', 'length', 'max' => 2),
            array('keywords', 'safe'),
            array('id, customer_id, email, name, password, officephone, cellphone, expires, screens, last_login, create_at, update_at, active, deleted, lang, origin_password, token, keywords', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'customer_id' => 'Customer',
            'email' => 'Email',
            'name' => 'Name',
            'password' => 'Password',
            'officephone' => 'Officephone',
            'cellphone' => 'Cellphone',
            'expires' => 'Expires',
            'screens' => 'Screens',
            'last_login' => 'Last Login',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'lang' => 'Lang',
            'origin_password' => 'Origin Password',
            'token' => 'Token',
            'keywords' => 'Keywords',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('officephone', $this->officephone, true);
        $criteria->compare('cellphone', $this->cellphone, true);
        $criteria->compare('expires', $this->expires, true);
        $criteria->compare('screens', $this->screens, true);
        $criteria->compare('last_login', $this->last_login);
        $criteria->compare('create_at', $this->create_at);
        $criteria->compare('update_at', $this->update_at);
        $criteria->compare('active', $this->active, true);
        $criteria->compare('deleted', $this->deleted, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('origin_password', $this->origin_password, true);
        $criteria->compare('token', $this->token, true);
        $criteria->compare('keywords', $this->keywords, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAccess($user_id = 0) {
        $result = array('user_id' => $user_id, 'access' => array());
        
        if ($user_id != 0) {
            $SQL = "SELECT * FROM `sv_role_assign` ra LEFT JOIN `sv_role_operate` ro ON ra.role_id = ro.role_id WHERE `user_id` = {$user_id} AND `stime` <= NOW() AND (`etime` >= NOW() OR `etime` = 0) AND `default_role` = 1";

            $access = Yii::app()->db->createCommand($SQL)->queryAll();
            
            if (!empty($access)) {
                foreach ($access as $val) {
                    if ($val['is_on'] == 1) {
                        array_push($result['access'], UserOperate::model()->getName($val['operate_id']));
                    }
                }
            }
        }
        
        return $result;
    }

}
