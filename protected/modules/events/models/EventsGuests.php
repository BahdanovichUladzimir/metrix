<?php

/**
 * This is the model class for table "EventsGuests".
 *
 * The followings are the available columns in table 'EventsGuests':
 * @property string $id
 * @property string $event_id
 * @property string $name
 * @property string $party_id
 * @property string $status_id
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Events $event
 */
class EventsGuests extends CActiveRecord
{

    public static $statuses = array();
    public static $parties = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'EventsGuests';
	}

	public function init(){
		self::$statuses = array(
            1 => Yii::t('eventsModule','Not submitted'),
            2 => Yii::t('eventsModule','Submitted'),
            3 => Yii::t('eventsModule','Confirmed'),
            4 => Yii::t('eventsModule','Refused')
		);
        self::$parties = array(
            1 => Yii::t('eventsModule','Groom'),
            2 => Yii::t('eventsModule','Bride'),
            3 => Yii::t('eventsModule','Mutual'),
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
			array('event_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('note', 'length', 'max'=>1000),
			array('name', 'required'),
			array('party_id, status_id', 'length', 'max'=>3),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, name, party_id, status_id, note', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('eventsModule','ID'),
			'event_id' => Yii::t('eventsModule','Event ID'),
			'name' => Yii::t('eventsModule','Guest name'),
			'party_id' => Yii::t('eventsModule','Party ID'),
			'status_id' => Yii::t('eventsModule','Status ID'),
			'note' => Yii::t('eventsModule','Note'),
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
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('party_id',$this->party_id,true);
		$criteria->compare('status_id',$this->status_id,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventsGuests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getEventsGuestsStatuses(){
        if(!is_null(self::$statuses)){
            return self::$statuses;
        }
	}
	public static function getEventsGuestsParties(){
        if(!is_null(self::$parties)){
            return self::$parties;
        }
	}
}
