<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 *
 * Description of AuthManage
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Dec 3, 2014 - 13:1:12 PM
 * @encoding        UTF-8 
 * @filename        AuthManage.php 
 */

class AuthManage extends CComponent {

    public static function checkAccess($actions = array()) {

        if (!empty($actions)) {
            $access = User::model()->getAccess(Yii::app()->user->id);
            foreach ($actions as $key => $action) {
                if (in_array($key, $access['access'])) {
                    $actions[$key] = 1;
                }
            }
        }
        return $actions;
    }

    public static function changeAccess($user_id) {
        if ($user_id) {
            $access = User::model()->getAccess($user_id);
            Yii::app()->user->setState('access', $access);
        }
    }

}
