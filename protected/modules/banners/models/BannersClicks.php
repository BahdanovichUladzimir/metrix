<?php

/**
 * This is the model class for table "BannersClicks".
 *
 * The followings are the available columns in table 'BannersClicks':
 * @property string $id
 * @property string $banner_id
 * @property string $date
 * @property string $clicks_count
 *
 * The followings are the available model relations:
 * @property Banners $banner
 */
class BannersClicks extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'BannersClicks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('banner_id', 'length', 'max'=>10),
			array('clicks_count', 'length', 'max'=>50),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, banner_id, date, clicks_count', 'safe', 'on'=>'search'),
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
			'banner' => array(self::BELONGS_TO, 'Banners', 'banner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'banner_id' => 'Banner ID',
			'date' => 'Date',
			'clicks_count' => 'Clicks count',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('banner_id',$this->banner_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('clicks_count',$this->clicks_count,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BannersClicks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
