<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 */

/**
 * Description of Roles Model
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Nov 27, 2014 - 14:24:21 PM
 * @encoding        UTF-8 
 * @filename        Roles.php 
 */
class Roles extends CActiveRecord {

    public function tableName() {
        return '{{roles}}';
    }

    public function rules() {
        return array(
            array('type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 60),
            array('desc', 'length', 'max' => 100),
            array('id, name, type, desc', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'desc' => 'Desc',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('desc', $this->desc, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDropdown(){
        $result = array();
        $roles = self::model()->findAllBySql("SELECT `id`, `name` FROM `sv_roles`");
        if(!empty($roles)){
            foreach ($roles as $val) 
            {
                array_push($result, array('id'=>$val['id'], 'name'=>$val['name']));
            }
        }
        return $result;
    }
    
     public function getRoleNameById($roleId) {
        $role = self::model()->findAllBySql("SELECT `id`, `name` FROM `sv_roles` WHERE `id` = {$roleId}");
        return $role;
    }

}
