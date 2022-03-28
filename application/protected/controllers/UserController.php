<?php

class UserController extends Controller {

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new User;
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->password = md5($_POST['User']['password']);
            $model->create_time = time();
            $model->update_time = time();
            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create', array(
            'model' => $model,
        ));
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

//    public function actionIndex() {
//        $criteria = new CDbCriteria;
//        $count = User::model()->count($criteria);
//        $pages = new CPagination($count);
//        $pages->pageSize = 100;
//        $pages->applyLimit($criteria);
//        $users = User::model()->findAll($criteria);
//        $this->render('index', array('users' => $users, 'pages' => $pages));
//    }

    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
