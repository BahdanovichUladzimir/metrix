<?php

/**
 * This is the model class for table "Events".
 *
 * The followings are the available columns in table 'Events':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $user_id
 * @property integer $status_id
 * @property string $type_id
 * @property integer $public_status_id
 * @property string $url
 * @property string $login
 * @property string $password
 * @property string $date
 * @property string $time
 * @property string $cookie
 * @property string $venue
 * @property int|null $formattedDate
 *
 * The followings are the available model relations:
 * @property EventsTypes $type
 * @property User $user
 * @property Alcohol $alcohol
 * @property EventsGuests[] $eventsGuests
 * @property EventsDoings[] $eventsDoings
 * @property Doings[] $doings
 * @property DailySchedules[] $schedules
 * @property EventsInvitedUsers[] $eventsInvitedUsers
 */
class Events extends CActiveRecord
{
    /**
     * @var int|null
     */
    public $formattedDate = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('name, type_id', 'required'),
            array('user_id, status_id, public_status_id', 'numerical', 'integerOnly'=>true),
            array('name, url, password, time, cookie, venue', 'length', 'max'=>255),
            array('description', 'length', 'max'=>5000),
            array('type_id', 'length', 'max'=>3),
            array('date', 'length', 'max'=>12),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, user_id, status_id, type_id, public_status_id, url, login, password, date, time', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'EventsTypes', 'type_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'eventsGuests' => array(self::HAS_MANY, 'EventsGuests', 'event_id'),
			'eventsDoings' => array(self::HAS_MANY, 'EventsDoings', 'event_id'),
			'schedules' => array(self::HAS_MANY, 'DailySchedules', 'event_id'),
			'eventsInvitedUsers' => array(self::HAS_MANY, 'EventsInvitedUsers', 'event_id'),
			'alcohol' => array(self::HAS_ONE, 'Alcohol', 'event_id'),
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
            'user_id' => Yii::t('eventsModule','User ID'),
            'status_id' => Yii::t('eventsModule','Status ID'),
            'type_id' => Yii::t('eventsModule','Type ID'),
            'public_status_id' => Yii::t('eventsModule','Public status ID'),
            'url' => Yii::t('eventsModule','Url'),
            'login' => Yii::t('eventsModule','Login (question)'),
            'password' => Yii::t('eventsModule','Password'),
            'date' => Yii::t('eventsModule','Event date'),
            'time' => Yii::t('eventsModule','Event time'),
            'cookie' => Yii::t('eventsModule','Event cookie'),
            'venue' => Yii::t('eventsModule','Venue'),
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
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('status_id',$this->status_id);
        $criteria->compare('type_id',$this->type_id,true);
        $criteria->compare('public_status_id',$this->public_status_id);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('login',$this->login,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('date',$this->date,true);
        $criteria->compare('time',$this->time,true);
        $criteria->compare('venue',$this->venue,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function userSearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->condition = "t.user_id=:user_id";
        $criteria->params = array(
            't.user_id' => Yii::app()->user->getId(),
        );
        $criteria->order='t.date DESC';


        $criteria->compare('id',$this->id,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('status_id',$this->status_id);
        $criteria->compare('type_id',$this->type_id,true);
        $criteria->compare('public_status_id',$this->public_status_id);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('login',$this->login,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('date',$this->date,true);
        $criteria->compare('time',$this->time,true);
        $criteria->compare('venue',$this->venue,true);


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getPublicUrl(){
        return Yii::app()->createUrl("/events/frontend/events/view", array("id" => $this->id));
    }

    public function getPrivateUrl(){
        return Yii::app()->createUrl("/events/user/events/view", array("id" => $this->id));
    }

    public function beforeSave(){
        if($this->isNewRecord){
            $this->cookie = md5(microtime()."_".$this->id);
        }
        return parent::beforeSave();
    }

    public function afterFind(){
        if(!is_null($this->date)){
            $this->formattedDate = $this->date;
        }
    }

    public function getSizeOfNotSubmittedGuests(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 1,
            ':event_id' => $this->id
        );
        return EventsGuests::model()->count($criteria);
    }

    public function getSizeOfSubmittedGuests(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 2,
            ':event_id' => $this->id
        );
        return EventsGuests::model()->count($criteria);
    }

    public function getSizeOfConfirmedGuests(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 3,
            ':event_id' => $this->id
        );
        return EventsGuests::model()->count($criteria);
    }

    public function getSizeOfRefusedGuests(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 4,
            ':event_id' => $this->id
        );
        return EventsGuests::model()->count($criteria);
    }
    public function afterSave(){
        if($this->isNewRecord && !is_null($this->type_id)){
            foreach($this->type->doings as $doing){
                $model = new EventsDoings();
                $model->name = $doing->name;
                $model->category_id = $doing->category_id;
                $model->event_id = $this->id;
                $model->comment = $doing->description;
                $model->status = 1;
                $model->save();
            }
        }
    }

    public function getSizeOfReadyDoings(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'status=:status AND event_id=:event_id';
        $criteria->params = array(
            ':status' => 2,
            ':event_id' => $this->id
        );
        return EventsDoings::model()->count($criteria);
    }




	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getStatusesListData(){
		return array(
			1 => Yii::t("eventsModule","Past"),
			2 => Yii::t("eventsModule","Present"),
			3 => Yii::t("eventsModule","Future"),
		);
	}

	public static function getPublicStatusesListData(){
		return array(
			1 => Yii::t("eventsModule","Public"),
			2 => Yii::t("eventsModule","Private"),
		);
	}
}
