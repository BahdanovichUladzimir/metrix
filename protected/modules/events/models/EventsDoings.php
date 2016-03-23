<?php

/**
 * This is the model class for table "EventsDoings".
 *
 * The followings are the available columns in table 'EventsDoings':
 * @property string $id
 * @property string $name
 * @property string $category_id
 * @property string $event_id
 * @property string $comment
 * @property double $price
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Events $event
 * @property EventsDoingsCategories $category
 */
class EventsDoings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'EventsDoings';
	}
	public static $statuses = array();

	public function init(){
		self::$statuses = array(
			1 => Yii::t("eventsModule",'Not ready'),
			2 => Yii::t("eventsModule",'Ready'),
		);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price', 'numerical'),
			array('name', 'length', 'max'=>255),
			array('category_id, event_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>2),
            array('name', 'required'),
            array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, category_id, event_id, comment, price, status', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Events', 'event_id'),
			'category' => array(self::BELONGS_TO, 'EventsDoingsCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("eventsModule",'ID'),
			'name' => Yii::t("eventsModule",'Name'),
			'category_id' => Yii::t("eventsModule",'Category'),
			'event_id' => Yii::t("eventsModule",'Event ID'),
			'comment' => Yii::t("eventsModule",'Comment'),
			'price' => Yii::t("eventsModule",'Price'),
			'status' => Yii::t("eventsModule",'Status')
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsDoings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
