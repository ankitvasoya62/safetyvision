<?php

/*
 * Copyright(c) 2014 Shinetech China Software, Inc.  All Rights Reserved.
 * This software is the proprietary information of Shinetech China Software, Inc
 */

/**
 * Description of RolesController
 *
 * @author          Hui Lee <lih@shinetechchina.com>
 * @copyright       Copyright (c) 2014
 * @link            http://www.shinetechchina.com
 * @since           Version 1.0
 * @datetime        Nov 27, 2014 - 14:25:35 PM
 * @encoding        UTF-8 
 * @filename        RolesController.php 
 */
class RolesController extends Controller {

    public function actionIndex() {
        $roles = Roles::model()->findAll();
        $this->render('index', array(
            'roles' => $roles,
        ));
    }

    public function actionCreate() {
        $params = Yii::app()->request->getParam('role');
        if (!empty($params)) {
            $model = new Roles;
            $model->attributes = $params;
            if ($model->save()) {
                echo json_encode(array('status' => true, 'url' => '/rbms/roles/set/id/' . $model->id));
            } else {
                echo json_encode(array('status' => false, 'msg' => ' save failed'));
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionSet($id) {
        $this->render('set', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionDelete() {
        $params = Yii::app()->request->getParam('role');
        if (!empty($params)) {
            $model = Roles::model()->findByPk($params['id']);
            if ($model->delete()) {
                echo json_encode(array('status' => true, 'url' => '/rbms/roles'));
            } else {
                echo json_encode(array('status' => false, 'msg' => ' Delete failed'));
            }
        } else {
            Yii::app()->end();
        }
    }

    public function actionDropdown() {
        $id = Yii::app()->request->getParam('id');
        echo json_encode(array(
            "roleassign" => RoleAssign::model()->getRoleAssign($id),
            "role" => Roles::model()->getDropdown())
        );
    }

    public function actionUpdate() {
        $result = array('status' => false);
        $role = Yii::app()->request->getParam('role', null);
        if (!empty($role)) {
            $model = $this->loadModel($role['id']);
            if ($role['type'] === 'name') {
                $model->name = $role['name'];
            } else if ($role['type'] === 'desc') {
                $model->desc = $role['desc'];
            }
            if ($model->update()) {
                $result['status'] = true;
            }
        }
        echo json_encode($result);
    }

    public function actionAssign() {
        $result = array('status' => false);
        $role_id = Yii::app()->request->getParam('role_id');
        $operate_id = Yii::app()->request->getParam('operate_id');
        $is_on = Yii::app()->request->getParam('is_on');
        if ($role_id && $operate_id) {
            $roleOperate = RoleOperate::model()->find("role_id = {$role_id} AND operate_id = {$operate_id}");
            if ($roleOperate) {
                $roleOperate->is_on = $is_on;
                if ($roleOperate->update()) {
                    $result = array('status' => true);
                }
            } else {
                $roleOperate = new RoleOperate;
                $roleOperate->role_id = $role_id;
                $roleOperate->operate_id = $operate_id;
                $roleOperate->is_on = $is_on;
                if ($roleOperate->save()) {
                    $result = array('status' => true);
                }
            }
        }
        echo json_encode($result);
    }

    public function loadModel($id) {
        $model = Roles::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'roles-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAccess() {
        if (!Yii::app()->user->isGuest) {
            $criteria = new CDbCriteria;
            if (Yii::app()->user->filter_customer_id) {
                $criteria->compare('user.customer_id', Yii::app()->user->filter_customer_id);
            }
            $criteria->compare('user.active', 'y');
            $criteria->compare('user.deleted', 'n');
            $criteria->with = 'user';


            $count = RoleAssign::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 50;
            $pages->applyLimit($criteria);
            $access = RoleAssign::model()->findAll($criteria);
            $this->render('access', array('access' => $access, 'pages' => $pages));
        } else {
            $this->redirect('/site/login');
        }
    }

}
