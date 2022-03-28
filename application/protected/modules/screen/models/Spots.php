<?php

/**
 * This is the model class for table "sv_spots".
 *
 * The followings are the available columns in table 'sv_spots':
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property integer $customer_id
 * @property string $owner
 * @property string $screens
 * @property string $type
 * @property string $resource
 * @property string $time_days
 * @property string $start_hh
 * @property string $stop_hh
 * @property integer $start_date
 * @property integer $stop_date
 * @property integer $time
 * @property integer $created
 * @property integer $lastedit
 * @property string $lastedit_by
 * @property integer $lastedit_user_id
 * @property integer $filesize
 */
class Spots extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sv_spots';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resource', 'required'),
			array('user_id, customer_id, start_date, stop_date, time, created, lastedit, lastedit_user_id, filesize', 'numerical', 'integerOnly'=>true),
			array('title, lastedit_by', 'length', 'max'=>100),
			array('owner', 'length', 'max'=>30),
			array('type', 'length', 'max'=>5),
			array('time_days, start_hh, stop_hh', 'length', 'max'=>15),
			array('screens', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, user_id, customer_id, owner, screens, type, resource, time_days, start_hh, stop_hh, start_date, stop_date, time, created, lastedit, lastedit_by, lastedit_user_id, filesize', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'user_id' => 'User',
			'customer_id' => 'Customer',
			'owner' => 'Owner',
			'screens' => 'Screens',
			'type' => 'Type',
			'resource' => 'Resource',
			'time_days' => 'Time Days',
			'start_hh' => 'Start Hh',
			'stop_hh' => 'Stop Hh',
			'start_date' => 'Start Date',
			'stop_date' => 'Stop Date',
			'time' => 'Time',
			'created' => 'Created',
			'lastedit' => 'Lastedit',
			'lastedit_by' => 'Lastedit By',
			'lastedit_user_id' => 'Lastedit User',
			'filesize' => 'Filesize',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('screens',$this->screens,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('resource',$this->resource,true);
		$criteria->compare('time_days',$this->time_days,true);
		$criteria->compare('start_hh',$this->start_hh,true);
		$criteria->compare('stop_hh',$this->stop_hh,true);
		$criteria->compare('start_date',$this->start_date);
		$criteria->compare('stop_date',$this->stop_date);
		$criteria->compare('time',$this->time);
		$criteria->compare('created',$this->created);
		$criteria->compare('lastedit',$this->lastedit);
		$criteria->compare('lastedit_by',$this->lastedit_by,true);
		$criteria->compare('lastedit_user_id',$this->lastedit_user_id);
		$criteria->compare('filesize',$this->filesize);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Spots the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
