<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 *
 * Description of RoleAssign Model
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Nov 27, 2014 - 16:48:36 PM
 * @encoding        UTF-8 
 * @filename        RoleAssign.php 
 */

class RoleOperate extends CActiveRecord {

    public function tableName() {
        return '{{role_operate}}';
    }

    public function rules() {
        return array(
            array('role_id, operate_id', 'required'),
            array('role_id, operate_id, is_on', 'numerical', 'integerOnly' => true),
            array('role_id, operate_id, is_on', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'roles'=>array(self::BELONGS_TO, 'Roles', 'role_id'),
            'useroperate'=>array(self::BELONGS_TO, 'UserOperate', 'operate_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'role_id' => 'Role',
            'operate_id' => 'Operate',
            'is_on' => 'Is On',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('operate_id', $this->operate_id);
        $criteria->compare('is_on', $this->is_on);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function checkRole($role_id, $operate_id){
        $roleOperate = self::model()->find("role_id = {$role_id} AND operate_id = {$operate_id}");
        if($roleOperate){
            if($roleOperate->is_on == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    

}
