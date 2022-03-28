<?php

/**
 * This is the model class for table "sv_customer".
 *
 * The followings are the available columns in table 'sv_customer':
 * @property integer $id
 * @property string $name
 * @property integer $start_date
 * @property integer $stop_date
 * @property integer $create_time
 * @property integer $update_time
 * @property string $deleted
 */
class Customer extends CActiveRecord {

    public function tableName() {
        return 'sv_customer';
    }

    public function rules() {

        return array(
            array('name', 'required'),
            array('start_date, stop_date, create_time, update_time', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('deleted', 'length', 'max' => 1),
            array('id, name, start_date, stop_date, create_time, update_time, deleted', 'safe', 'on' => 'search'),
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
            'start_date' => 'Start Date',
            'stop_date' => 'Stop Date',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'deleted' => 'Deleted',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('start_date', $this->start_date);
        $criteria->compare('stop_date', $this->stop_date);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('deleted', $this->deleted, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNames() {
        $criteria = new CDbCriteria;
        $criteria->select = 'id, name';
        return self::model()->findAll($criteria);
    }

    public function getCustomers() {
        $SQL = "SELECT * FROM `sv_customer` WHERE `start_date` <= " . time() . " AND (`stop_date` = 0 OR `stop_date` >=" . time() . ") AND `deleted` = 'n'";
        $customers = Yii::app()->db->createCommand($SQL)->queryAll();
        return $customers;
    }

    public function getNameById($pk) {
        $customer = self::model()->findByPk($pk);
        if ($customer) {
            return $customer->name;
        } else {
            return "All Customers";
        }
    }
    
    public function getCustomerList(){
        $customer_id = Yii::app()->user->customer_id;
        if($customer_id){
            $result = array();
            $SQL = "SELECT `id`,`name` FROM `sv_customer` WHERE `start_date` <= " . time() . " AND (`stop_date` = 0 OR `stop_date` >=" . time() . ") AND "
                    . "`deleted` = 'n' AND `id` = {$customer_id}";
        }else{
            $result = array(array('id' => 0, 'name' => Yii::t('lang', 'All Customers')));
            $SQL = "SELECT `id`,`name` FROM `sv_customer` WHERE `start_date` <= " . time() . " AND (`stop_date` = 0 OR `stop_date` >=" . time() . ") AND `deleted` = 'n'";
        }
        $customers = Yii::app()->db->createCommand($SQL)->queryAll();
        if(!empty($customers)){
            foreach($customers as $val){
                array_push($result, array('id'=>$val['id'], 'name' => $val['name']));
            }
        }
        return $result;
    }
    
    
    
    
}
