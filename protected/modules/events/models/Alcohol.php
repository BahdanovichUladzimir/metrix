<?php

/**
 * This is the model class for table "Alcohol".
 *
 * The followings are the available columns in table 'Alcohol':
 * @property string $id
 * @property string $event_id
 * @property string $men
 * @property string $women
 * @property string $children
 * @property string $not_drinking_men
 * @property string $not_drinking_women
 * @property string $event_duration
 * @property string $alcohol_consumption
 * @property string $season
 *
 * The followings are the available model relations:
 * @property Events $event
 */
class Alcohol extends CActiveRecord
{

    public $consumptionRate;
    public $degreeConsumption;
    public $seasonCoef;
    public $menVodkaCount;
    public $menWineCount;
    public $menChampagneCount;
    public $womenVodkaCount;
    public $womenWineCount;
    public $womenChampagneCount;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Alcohol';
	}

	public static $alcoholConsumptionDegrees = array(
        1 => 'Мало',
        2 => 'Средне',
        4 => 'Много',
    );

	public static $alcoholConsumptionDegreesVolumes = array(
        'Мало' => array(
            'vodka' => array(
                "men" => 0.2,
                "women" => 0.1
            ),
            'wine' => array(
                "men" => 0.3,
                "women" => 0.4
            ),
            'champagne' => array(
                "men" => 0.1,
                "women" => 0.3
            )
        ),
        'Средне' => array(
            'vodka' => array(
                "men" => 0.6,
                "women" => 0.3
            ),
            'wine' => array(
                "men" => 0.9,
                "women" => 1.2
            ),
            'champagne' => array(
                "men" => 0.3,
                "women" => 0.9
            )
        ),
        'Много' => array(
            'vodka' => array(
                "men" => 1,
                "women" => 0.5
            ),
            'wine' => array(
                "men" => 1.5,
                "women" => 2
            ),
            'champagne' => array(
                "men" => 0.5,
                "women" => 1.5
            )
        ),
    );

	public static $seasons = array(
        1 => 'Зима',
        2 => 'Весна',
        3 => 'Лето',
        4 => 'Осень',
    );

    public static $seasonsCoefficients = array(
        'Зима' => 1.2,
        'Весна' => 1,
        'Лето' => 0.8,
        'Осень' => 1
    );

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, men, women, children, not_drinking_men, not_drinking_women, event_duration, alcohol_consumption, season', 'length', 'max'=>10),
			array('men, women, children, not_drinking_men, not_drinking_women', 'numerical', 'integerOnly'=>true, 'min' => 0),
			array('not_drinking_men, not_drinking_women', 'notDrinkingPeopleCountValidate'),
			array('event_duration','numerical','min' => 1, 'allowEmpty' => false),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, men, women, children, not_drinking_men, not_drinking_women, event_duration, alcohol_consumption, season', 'safe', 'on'=>'search'),
		);
	}

    public function notDrinkingPeopleCountValidate($attribute,$params=array()){
        if (!$this->hasErrors()){
            $allPeople = (int)$this->men+(int)$this->women+(int)$this->children;
            if(!is_null($this->not_drinking_men) && !is_null($this->not_drinking_women)){
                if(((int)$this->not_drinking_men+(int)$this->not_drinking_women)>$allPeople){
                    $this->addError('not_drinking_men',Yii::t('eventsModule','Non-drinking guests can not be more than all the guests'));
                    $this->addError('not_drinking_women',Yii::t('eventsModule','Non-drinking guests can not be more than all the guests'));
                }
            }
            elseif(!is_null($this->not_drinking_men)){
                if((int)$this->not_drinking_men>$allPeople){
                    $this->addError('not_drinking_men',Yii::t('eventsModule','Non-drinking men can not be more than all the guests'));
                }
            }
            elseif(!is_null($this->not_drinking_women)){
                if((int)$this->not_drinking_women>$allPeople){
                    $this->addError('not_drinking_women',Yii::t('eventsModule','Non-drinking women can not be more than all the guests'));
                }
            }
        }
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
			'men' => Yii::t('eventsModule','Men'),
			'women' => Yii::t('eventsModule','Women'),
			'children' => Yii::t('eventsModule','Children'),
			'not_drinking_men' => Yii::t('eventsModule','Not-drinking men'),
			'not_drinking_women' => Yii::t('eventsModule','Not-drinking women'),
			'event_duration' => Yii::t('eventsModule','Event duration in hours'),
			'alcohol_consumption' => Yii::t('eventsModule','Alcohol consumption'),
			'season' => Yii::t('eventsModule','Season'),
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
		$criteria->compare('men',$this->men,true);
		$criteria->compare('women',$this->women,true);
		$criteria->compare('children',$this->children,true);
		$criteria->compare('not_drinking_men',$this->not_drinking_men,true);
		$criteria->compare('not_drinking_women',$this->not_drinking_women,true);
		$criteria->compare('event_duration',$this->event_duration,true);
		$criteria->compare('alcohol_consumption',$this->alcohol_consumption,true);
		$criteria->compare('season',$this->season,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind(){
        $this->consumptionRate = Yii::app()->config->get("EVENTS_MODULE.CONSUMPTION_RATE");
        $this->degreeConsumption = self::getAlcoholConsumptionDegrees()[$this->alcohol_consumption];
        $volumes = self::$alcoholConsumptionDegreesVolumes[$this->degreeConsumption];
        $season = self::getSeasons()[$this->season];
        $this->seasonCoef = self::$seasonsCoefficients[$season];
        $this->menVodkaCount = $this->men*$volumes['vodka']['men']*$this->seasonCoef/6*$this->event_duration*$this->consumptionRate;
        $this->menWineCount = $this->men*$volumes['wine']['men']*$this->seasonCoef/6*$this->event_duration*$this->consumptionRate;
        $this->menChampagneCount = $this->men*$volumes['champagne']['men']*$this->seasonCoef/6*$this->event_duration*$this->consumptionRate;
        $this->womenVodkaCount = $this->men*$volumes['vodka']['women']*$this->seasonCoef/6*$this->event_duration*$this->consumptionRate;
        $this->womenWineCount = $this->men*$volumes['wine']['women']*$this->seasonCoef/6*$this->event_duration*$this->consumptionRate;
        $this->womenChampagneCount = $this->men*$volumes['champagne']['women']*$this->seasonCoef/6*$this->event_duration*$this->consumptionRate;

    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alcohol the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * @return array
     */
    public static function getAlcoholConsumptionDegrees(){
        return self::$alcoholConsumptionDegrees;
    }

    /**
     * @return array
     */
    public static function getSeasons(){
        return self::$seasons;
    }

}
