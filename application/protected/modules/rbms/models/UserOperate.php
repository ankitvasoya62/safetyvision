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

class UserOperate extends CActiveRecord {

    public function tableName() {
        return '{{user_operate}}';
    }

    public function rules() {
        return array(
            array('group, name, desc', 'required'),
            array('group, pid', 'length', 'max' => 20),
            array('name, desc', 'length', 'max' => 50),
            array('id, group, name, desc, pid', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'Manage ID',
            'group' => 'Manage Group',
            'name' => 'Manage Name',
            'desc' => 'Desc',
            'pid' => 'Pid',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('group', $this->group, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('pid', $this->pid, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function initTable() {
        $init = array(
            array(
                'group' => 'menu',
                'name' => 'menu.customer',
                'desc' => 'Menu: Customer',
            ),
            array(
                'group' => 'menu',
                'name' => 'menu.screen',
                'desc' => 'Menu: Screen',
            ),
            array(
                'group' => 'menu',
                'name' => 'menu.archive',
                'desc' => 'Menu: Archive',
            ),
            array(
                'group' => 'menu',
                'name' => 'menu.administrator',
                'desc' => 'Menu: Administrator',
            ),
            array(
                'group' => 'menu',
                'name' => 'menu.user',
                'desc' => 'Menu: Users',
            ),
            array(
                'group' => 'menu',
                'name' => 'menu.user_access',
                'desc' => 'Menu: User and Access',
            ),
            array(
                'group' => 'menu',
                'name' => 'menu.role',
                'desc' => 'Menu: Roles',
            ),
            array(
                'group' => 'customer',
                'name' => 'customer.create',
                'desc' => 'Create Customers',
            ),
            array(
                'group' => 'customer',
                'name' => 'customer.edit',
                'desc' => 'Edit Customers',
            ),
            array(
                'group' => 'customer',
                'name' => 'customer.delete',
                'desc' => 'Delete Customers',
            ),
            array(
                'group' => 'screen',
                'name' => 'screen.create',
                'desc' => 'Create Screen',
            ),
            array(
                'group' => 'screen',
                'name' => 'screen.edit',
                'desc' => 'Edit Screen',
            ),
            array(
                'group' => 'screen',
                'name' => 'screen.delete',
                'desc' => 'Delete Screen',
            ),
            array(
                'group' => 'screen',
                'name' => 'screen.command',
                'desc' => 'Send Command',
            ),
            array(
                'group' => 'user',
                'name' => 'user.create',
                'desc' => 'Create User',
            ),
            array(
                'group' => 'user',
                'name' => 'user.edit',
                'desc' => 'Edit User',
            ),
            array(
                'group' => 'user',
                'name' => 'user.delete',
                'desc' => 'Delete User',
            ),
            array(
                'group' => 'user',
                'name' => 'role.create',
                'desc' => 'Create Role',
            ),
            array(
                'group' => 'user',
                'name' => 'role.edit',
                'desc' => 'Edit Role',
            ),
            array(
                'group' => 'user',
                'name' => 'role.delete',
                'desc' => 'Delete Role',
            ),
            array(
                'group' => 'spot',
                'name' => 'spot.create',
                'desc' => 'Create Spot',
            ),
            array(
                'group' => 'spot',
                'name' => 'spot.edit',
                'desc' => 'Edit Spot',
            ),
            array(
                'group' => 'spot',
                'name' => 'spot.delete',
                'desc' => 'Delete Spot',
            ),
        );

        Yii::app()->db->createCommand()->truncateTable('sv_user_operate');

        foreach ($init as $val) {
            $userOperate = new UserOperate;
            $userOperate->group = $val['group'];
            $userOperate->name = $val['name'];
            $userOperate->desc = $val['desc'];
            $userOperate->save();
        }
    }
    
    public function getName($operate_id) {
        if($operate_id){
            $operate = self::model()->findByPk($operate_id);
            if($operate){
                return $operate->name;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
    

}
