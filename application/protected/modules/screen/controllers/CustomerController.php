<?php

class CustomerController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionList() {
        $customers = Customer::model()->getCustomers();
        $result = array();
        if($customers){
            foreach ($customers as $val){
                $val['user'] = 10000;
                $val['start_date_p'] = date('D.d.m.Y', $val['start_date']);
                if($val['stop_date']){
                    $val['stop_date_p'] = date('D.d.m.Y', $val['stop_date']);
                }else{
                    $val['stop_date_p'] = null;
                }
                array_push($result, $val);
            }
        }
        echo json_encode($result);
    }

    public function actionSave() {
        $result = array('status' => false);
        $customer = Yii::app()->request->getParam('customer');
        if ($customer['customer_id']) {
            $model = Customer::model()->findByPk($customer['customer_id']);
        } else {
            $model = new Customer();
        }

        if ($customer['name']) {
            $model->name = trim($customer['name']);
        }

        if ($customer['startdate']) {
            $model->start_date = strtotime($customer['startdate']);
        }

        if ($customer['stopdate']) {
            $model->stop_date = strtotime($customer['stopdate']);
        }else{
            $model->stop_date = 0;
        }

        if ($customer['customer_id']) {
            $model->update_time = time();
            if ($model->update()) {
                $result = array('status' => true);
            }
        } else {
            $model->create_time = time();
            $model->update_time = 0;
            if ($model->save()) {
                $result = array('status' => true);
            }
        }

        echo json_encode($result);
    }
    
    public function actionDelete() {
        $customer_id = Yii::app()->request->getParam('customer_id', NULL);
        $result = array('status'=>false);
        if($customer_id){
            $customer = Customer::model()->findByPk($customer_id);
            $customer->deleted = 'y';
            if($customer->update()){
                $result['status'] = true;
            }
        }
        echo json_encode($result);
    }

}