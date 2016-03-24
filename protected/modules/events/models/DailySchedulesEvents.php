<?php

/**
 * This is the model class for table "DailySchedulesEvents".
 *
 * The followings are the available columns in table 'DailySchedulesEvents':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $start
 * @property string $end
 * @property string $schedule_id
 *
 * The followings are the available model relations:
 * @property DailySchedules $schedule
 */
class DailySchedulesEvents extends CActiveRecord
{
    public $publicStart;
    public $publicEnd;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DailySchedulesEvents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start, end, schedule_id', 'required'),
			array('name, schedule_id', 'length', 'max'=>255),
			array('description', 'length', 'max'=>3000),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, start, end, schedule_id', 'safe', 'on'=>'search'),
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
			'schedule' => array(self::BELONGS_TO, 'DailySchedules', 'schedule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('eventsModule','ID'),
			'name' => Yii::t('eventsModule','Name'),
			'description' => Yii::t('eventsModule','Description'),
			'start' => Yii::t('eventsModule','Start'),
			'end' => Yii::t('eventsModule','End'),
			'schedule_id' => Yii::t('eventsModule','Schedule ID'),
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
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('schedule_id',$this->schedule_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterFind(){
        $this->publicStart = date('H:i',strtotime($this->start));
        $this->publicEnd = date('H:i',strtotime($this->end));

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DailySchedulesEvents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
