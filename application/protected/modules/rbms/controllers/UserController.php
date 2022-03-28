<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 *
 * Description of UserController
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Nov 26, 2014 - 3:20:21 PM
 * @encoding        UTF-8 
 * @filename        UserController.php 
 */

class UserController extends Controller {

    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $this->redirect('/site/login');
        } else {
            $criteria = new CDbCriteria;
            if (Yii::app()->user->filter_customer_id) {
                $criteria->compare('customer_id', Yii::app()->user->filter_customer_id);
            }
            $criteria->compare('active', 'y');
            $criteria->compare('deleted', 'n');

            $count = User::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);
            $users = User::model()->findAll($criteria);

            $session = new CDbCriteria;
            $session->order = "last_login DESC";
            $sessions = Sessions::model()->findAll($session);

            $this->render('index', array('users' => $users, 'pages' => $pages, 'sessions' => $sessions));
        }
    }

    public function actionSave() {
        $param = Yii::app()->request->getParam('user');

        if (!empty($param)) {
            if (isset($param['id'])) {
                $user = User::model()->findByPk($param['id']);
                if (!empty($param['role'])) {
                    RoleAssign::model()->delRoleAssign($param['id']);
                    RoleAssign::model()->addRoleAssign($param['id'], $param['role']);
                }
            } else {
                $user = new User;
            }

            $user->attributes = $param;
            if ($user->isNewRecord) {
                $user->create_at = $_SERVER['REQUEST_TIME'];
            } else {
                $user->update_at = $_SERVER['REQUEST_TIME'];
            }

            $user->origin_password = $param['password'];
            $user->password = md5($param['password']);

            if (!empty($param['expires'])) {
                $user->expires = strtotime($param['expires']);
                $user->expires_text = $param['expires'];
            }

            if ($user->isNewRecord) {
                if ($user->save()) {
                    $user->keywords = $user->id . $user->name . $user->email . Customer::model()->getNameById($user->customer_id);
                    $user->update();
                    echo json_encode(array('status' => true, 'url' => '/rbms/user/profile/id/' . $user->id));
                } else {
                    echo json_encode(array('status' => false, 'msg' => 'save failed'));
                }
            } else {
                $user->keywords = $user->id . $user->name . $user->email . Customer::model()->getNameById($user->customer_id);
                if ($user->update()) {
                    echo json_encode(array('status' => true, 'url' => '/rbms/user/profile/id/' . $user->id));
                } else {
                    echo json_encode(array('status' => false, 'msg' => 'save failed'));
                }
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionProfile($id) {
        if (Yii::app()->user->isGuest) {
            $this->redirect('/site/login');
        } else {
            $criteria = new CDbCriteria;
            $criteria->compare('userid', $id);
            $criteria->limit = 8;
            $criteria->order = 'id DESC';
            $loginLog = LoginLog::model()->findAll($criteria);


            $result = array('id' => 0, 'name' => 'Manage Users');

            $customer_id = Yii::app()->user->filter_customer_id;
            if ($customer_id) {
                $customer = Customer::model()->findByPk($customer_id);
                if (!empty($customer)) {
                    $result = array('id' => $customer->id, 'name' => $customer->name);
                }
            }

            $this->render('profile', array(
                'model' => $this->loadModel($id),
                'logs' => $loginLog,
                'customer' => $result,
            ));
        }
    }

    public function actionCreate() {
        if (!Yii::app()->user->isGuest) {
            $result = array('id' => 0, 'name' => 'Manage Users');

            $customer_id = Yii::app()->user->filter_customer_id;
            if ($customer_id) {
                $customer = Customer::model()->findByPk($customer_id);
                if (!empty($customer)) {
                    $result = array('id' => $customer->id, 'name' => $customer->name);
                }
            }
            $this->render('create', array('customer' => $result));
        } else {
            $this->redirect('/site/login');
        }
    }

    public function actionCustomer() {
        if (Yii::app()->user->isGuest) {
            $this->redirect('/site/login');
        } else {
            $result = array('id' => 0, 'name' => 'Manage Users');

            $customer_id = Yii::app()->user->filter_customer_id;
            if ($customer_id) {
                $customer = Customer::model()->findByPk($customer_id);
                if (!empty($customer)) {
                    $result = array('id' => $customer->id, 'name' => $customer->name);
                }
            }
            echo json_encode(array('status' => true, 'customer' => $result));
        }
    }

    public function actionSetScreens() {
        $type = Yii::app()->request->getParam('type', null);
        $user_id = Yii::app()->request->getParam('user_id', null);
        $screens = Yii::app()->request->getParam('screens', null);
        if (!empty($type) && $type == 'all') {
            if (!empty($user_id) && !empty($screens)) {
                UserScreens::model()->updateAll(array('is_on' => 1), "user_id = {$user_id}");
            }
        } elseif (!empty($type) && $type == 'none') {
            if (!empty($user_id)) {
                UserScreens::model()->updateAll(array('is_on' => 0), "user_id = {$user_id}");
            }
        } elseif (!empty($type) && $type == 'one') {
            if (!empty($user_id) && !empty($screens)) {
                $userScreen = UserScreens::model()->find("user_id = {$user_id} AND `screen_id` = {$screens['screen_id']}");
                if ($userScreen) {
                    if ($userScreen['is_on'] == 1) {
                        $userScreen->is_on = 0;
                    } else {
                        $userScreen->is_on = 1;
                    }
                    $userScreen->update();
                }
            }
        }
        echo json_encode(array('status' => true));
    }

    public function actionScreens() {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $screens = Screen::model()->getUserScreens($id);
            echo json_encode(array('status' => true, 'screens' => $screens));
        } else {
            Yii::app()->end();
        }
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];

            $model->password = $_POST['User']['password'];
            $model->update_time = time();
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
