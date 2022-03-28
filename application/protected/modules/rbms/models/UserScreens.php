<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 * Description of RoleAssign Model
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Nov 30, 2014 - 09:24:36 PM
 * @encoding        UTF-8 
 * @filename        RoleAssign.php 
 */

class UserScreens extends CActiveRecord {

    public function tableName() {
        return '{{user_screens}}';
    }

    public function rules() {
        return array(
            array('user_id, screen_id', 'required'),
            array('user_id, screen_id, is_on', 'numerical', 'integerOnly' => true),
            array('user_id, screen_id, is_on', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'screen_id' => 'Screen',
            'is_on' => 'Is On',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('screen_id', $this->screen_id);
        $criteria->compare('is_on', $this->is_on);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function setUserScreen($user_id,$screens){
        if(!empty($user_id) && !empty($screens)){
            $array      = '';
            foreach ($screens as $value) {
                $array .= "($user_id,{$value['screen_id']},1) ,";
            }
            $values     = rtrim($array, ',');
            $insert_sql = "INSERT INTO `sv_user_screens`(user_id,screen_id,is_on) VALUES $values ";
            return Yii::app()->db->createCommand($insert_sql)->execute();
        }
    }
    
    
    

}
