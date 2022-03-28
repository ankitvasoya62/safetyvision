<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 */

/**
 * Description of UserIdentity
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Nov 21, 2014 - 09:20:21 AM
 * @encoding        UTF-8 
 * @filename        UserIdentity.php 
 */
class UserIdentity extends CUserIdentity {

    public function authenticate() {
        $user = User::model()->find("email='{$this->username}'");
        if (!empty($user)) {
            if ($user->password != md5($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->errorCode = self::ERROR_NONE;
            }
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        $loginLog = new LoginLog;

        $loginLog->userid = $user['id'];
        $loginLog->time = $_SERVER['REQUEST_TIME'];
        $loginLog->ip = Yii::app()->request->userHostAddress;

        if ($this->errorCode === 0) {
            $this->setState('id', $user['id']);
//            $this->setState('access', User::model()->getAccess($user['id']));
            $this->setState('customer_id', $user['customer_id']);
            $this->setState('filter_customer_id', $user['customer_id']);
            $loginLog->success = 1;
            Sessions::model()->recordSession(Yii::app()->session->getSessionID(), $user['id']);
        } else {
            $loginLog->success = 0;
        }
        $loginLog->save();
        return $this->errorCode;
    }

}
