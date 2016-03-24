<?php

/**
 * This is the model class for table "DailySchedules".
 *
 * The followings are the available columns in table 'DailySchedules':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $date
 * @property string $event_id
 *
 * The followings are the available model relations:
 * @property Events $event
 * @property DailySchedulesEvents[] $dailySchedulesEvents
 */
class DailySchedules extends CActiveRecord
{

	public $publicDate;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DailySchedules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>255),
			array('description', 'length', 'max'=>5000),
			array('name, date', 'required'),
			array('event_id', 'length', 'max'=>10),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, date, event_id', 'safe', 'on'=>'search'),
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
			'dailySchedulesEvents' => array(
                self::HAS_MANY,
                'DailySchedulesEvents',
                'schedule_id',
                'order' => 'dailySchedulesEvents.start ASC, dailySchedulesEvents.end ASC',
			),
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
			'description' => Yii::t("eventsModule",'Description'),
			'date' => Yii::t("eventsModule",'Date'),
			'event_id' => Yii::t("eventsModule",'Event ID'),
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('event_id',$this->event_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterFind(){
		$this->publicDate = date('d.m.Y',strtotime($this->date));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DailySchedules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
