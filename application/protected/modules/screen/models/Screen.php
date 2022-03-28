<?php

class Screen extends CActiveRecord {
    
    public $window_width = 1000;
    public $window_height = 563;
    
    public function tableName() {
        return 'sv_screen';
    }

    public function rules() {
        return array(
            array('name, user_id, customer_id, width, height, create_time, secret', 'required'),
            array('user_id, customer_id,width,height,create_time,publish', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('ratio', 'length', 'max' => 8),
            array('secret', 'length', 'max' => 32),
            array('id, name, user_id, customer_id, ratio, width, height, create_time, update_time, publish, secret', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'user_id' => 'User',
            'customer_id' => 'Customer',
            'ratio' => 'Ratio',
            'width' => 'Width',
            'height' => 'Height',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'publish' => 'open:1, close:0',
            'is_deleted' => 'Is Deleted',
            'secret' => 'Secret',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('ratio', $this->ratio, true);
        $criteria->compare('width', $this->width);
        $criteria->compare('height', $this->height);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('publish', $this->publish);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('secret', $this->secret, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getScreensByCustomerId(){
        $criteria = new CDbCriteria;
        $customer_id = Yii::app()->user->filter_customer_id;
        if($customer_id){
            $criteria->compare('customer_id', $this->customer_id);
        }
        $criteria->compare('publish', 1);
        $criteria->compare('is_deleted', 0);
        return $screens = self::model()->findAll($criteria);
    }
    
    public function getUserScreens($user_id){
        $result = array();
        $screen = self::model()->getScreensByCustomerId();
        
        if($screen){
            foreach ($screen as $val) 
            {
                array_push($result, array('screen_id'=>$val['screen_id'], 'name'=>$val['name'],'user_id'=>$user_id,'is_on'=>$this->checkUserScreen($user_id, $val['screen_id'])));

            }
        }
        return $result;
    }
    
    private function checkUserScreen($user_id, $screen_id){
        if($user_id && $screen_id){
            $user_screen = Yii::app()->db->createCommand("SELECT `is_on` FROM `sv_user_screens` WHERE `user_id` = {$user_id} AND `screen_id` = {$screen_id}")->queryRow();
            if($user_screen){
                if($user_screen['is_on']){
                    return true;
                }else{
                    return false;
                }
            }else{
                $userScreen = new UserScreens;
                $userScreen->user_id = $user_id;
                $userScreen->screen_id = $screen_id;
                $user = User::model()->findByPk($user_id);
                if($user && $user->customer_id == 0){
                    $userScreen->is_on = 1;
                    $userScreen->save();
                    return true;
                }else{
                    $userScreen->is_on = 0;
                    $userScreen->save();
                    return false;
                }
            }
        }
    }
}
