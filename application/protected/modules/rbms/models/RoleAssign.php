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
class RoleAssign extends CActiveRecord {

    public function tableName() {
        return '{{role_assign}}';
    }

    public function rules() {
        return array(
            array('role_id, user_id, stime, etime', 'length', 'max' => 10),
            array('stime_text, etime_text', 'length', 'max' => 20),
            array('default_role', 'length', 'max' => 11),
            array('role_id, user_id, stime, stime_text, etime, etime_text, default_role', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'role'=>array(self::BELONGS_TO, 'Roles', 'role_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'role_id' => 'Role',
            'user_id' => 'User',
            'stime' => 'Stime',
            'stime_text' => 'Stime Text',
            'etime' => 'Etime',
            'etime_text' => 'Etime Text',
            'default_role' => 'Default Role',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('role_id', $this->role_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('stime', $this->stime, true);
        $criteria->compare('stime_text', $this->stime_text, true);
        $criteria->compare('etime', $this->etime, true);
        $criteria->compare('etime_text', $this->etime_text, true);
        $criteria->compare('default_role', $this->default_role, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getRoleAssign($user_id){
        $result = array();
        $rolesAssign = self::model()->findAllBySql("SELECT `role_id`, `stime_text`, `etime_text` FROM `sv_role_assign` WHERE `user_id` = {$user_id}");
        if(!empty($rolesAssign)){
            foreach ($rolesAssign as $val) 
            {
                array_push($result, array('id'=>$val['role_id'], 'stime_text'=>$val['stime_text'],'etime_text'=>$val['etime_text']));
            }
        }
        return $result;
    }

    public function getRoleAssignName($user_id){
        $rolesAssign = self::model()->findAllBySql("SELECT `role_id` FROM `sv_role_assign` WHERE `user_id` = {$user_id}");
        $role = new Roles();
        $roleName = $role->getRoleNameById($rolesAssign[0]['role_id']);
        return $roleName;
    }
    
    public function delRoleAssign($user_id) {
        if(!empty($user_id)){
            return self::model()->deleteAll("`user_id` = {$user_id}");
        }
    }
    
    public function addRoleAssign($user_id, $roles){
        if(!empty($roles)){
            foreach ($roles as $key => $val) 
            {
                $role = new RoleAssign;
                $role->user_id = $user_id;
                $role->role_id = $val['id'];
                if($val['stime_text'] != ""){
                     $role->stime = strtotime($val['stime_text']);
                     $role->stime_text = $val['stime_text'];
                }
                if($val['etime_text'] != ""){
                     $role->stime = strtotime($val['etime_text']);
                     $role->stime_text = $val['etime_text'];
                }
                if($key == 0){
                    $role->default_role = 1;
                }
                $role->save();
            }
        }
    }
    
}
