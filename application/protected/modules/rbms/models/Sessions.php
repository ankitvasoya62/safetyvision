<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 *
 * Description of Sessions Model
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Dec 1, 2014 - 17:22:20 PM
 * @encoding        UTF-8 
 * @filename        Sessions.php 
 */

class Sessions extends CActiveRecord {

    public function tableName() {
        return '{{sessions}}';
    }

    public function rules() {
        return array(
            array('ip, last_login', 'required'),
            array('last_login', 'numerical', 'integerOnly' => true),
            array('sid', 'length', 'max' => 32),
            array('uid', 'length', 'max' => 10),
            array('ip', 'length', 'max' => 15),
            array('sid, uid, ip, last_login', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
         return array(
            'user'=>array(self::BELONGS_TO, 'User', 'uid'),
        );
    }

    public function attributeLabels() {
        return array(
            'sid' => 'Sid',
            'uid' => 'Uid',
            'ip' => 'Ip',
            'last_login' => 'Last Login',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('sid', $this->sid, true);
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('last_login', $this->last_login);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function recordSession($sid = null, $uid){
        if(!empty($sid)){
            $session = self::model()->findByPk($sid);
            if($session){
                $session->ip =  Yii::app()->request->userHostAddress;
                $session->last_login = $_SERVER['REQUEST_TIME'];
                return $session->update();
            }else{
                $session = new Sessions;
                $session->sid = $sid;
                $session->uid = $uid;
                $session->ip =  Yii::app()->request->userHostAddress;
                $session->last_login = $_SERVER['REQUEST_TIME'];
                return $session->save();
            }
        }
    }
    
    public function getLastLogin($user_id){
        if($user_id){
            $session = Yii::app()->db->createCommand("SELECT `last_login` FROM `sv_sessions` WHERE `uid` = {$user_id} ORDER BY `last_login` DESC LIMIT 1,1")->queryRow();
            if($session){
                return date("d.m.Y H:i:s", $session['last_login']);
            }else{
                return 'Not yet';
            }
        }
    }
    
}
