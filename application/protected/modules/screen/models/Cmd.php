<?php

/**
 * This is the model class for table "sv_cmd".
 *
 * The followings are the available columns in table 'sv_cmd':
 * @property integer $screen_id
 * @property integer $spot_id
 * @property string $cmd
 */
class Cmd extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sv_cmd';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('screen_id, spot_id, cmd', 'required'),
			array('screen_id, spot_id', 'numerical', 'integerOnly'=>true),
			array('cmd', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('screen_id, spot_id, cmd', 'safe', 'on'=>'search'),
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
			'screen_id' => 'Screen',
			'spot_id' => 'Spot',
			'cmd' => 'Cmd',
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

		$criteria->compare('screen_id',$this->screen_id);
		$criteria->compare('spot_id',$this->spot_id);
		$criteria->compare('cmd',$this->cmd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cmd the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
