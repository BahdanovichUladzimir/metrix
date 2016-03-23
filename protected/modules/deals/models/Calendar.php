<?php

/**
 * This is the model class for table "Calendar".
 *
 * The followings are the available columns in table 'Calendar':
 * @property string $id
 * @property string $deal_id
 * @property string $title
 * @property string $description
 * @property integer $start
 * @property integer $end
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Deals $deal
 */
class Calendar extends CActiveRecord
{
	public static $types = array();

	public $formattedStart;
	public $formattedEnd;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Calendar';
	}
    public function init(){
        parent::init();
        self::$types = array(
            1 => Yii::t("dealsModule","Necessarily"),
            2 => Yii::t("dealsModule","Likely"),
            3 => Yii::t("dealsModule","Possible"),
            4 => Yii::t("dealsModule","Unlikely"),
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
            array('title, start, end', 'required'),
            array('start, end', 'checkEndMoreThenStart'),
            array('start, end, type', 'numerical', 'integerOnly'=>true),
			array('deal_id', 'length', 'max'=>11),
			array('title', 'length', 'max'=>255),
			array('description', 'length', 'max'=>2000),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deal_id, title, description, start, end, type', 'safe', 'on'=>'search'),
		);
	}

	public function checkEndMoreThenStart(){
        if (!$this->hasErrors()){
            if(!is_null($this->start) && !is_null($this->end)){
                if($this->start>$this->end){
                    $this->addError('start',Yii::t('dealsModule','Start can not be more than the end.'));
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
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("dealsModule",'ID'),
			'deal_id' => Yii::t("dealsModule",'Deal ID'),
			'title' => Yii::t("dealsModule",'Title'),
			'description' => Yii::t("dealsModule",'Description'),
			'start' => Yii::t("dealsModule",'Start'),
			'end' => Yii::t("dealsModule",'End'),
			'type' => Yii::t("dealsModule",'Type'),
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
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start',$this->start);
		$criteria->compare('end',$this->end);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterFind(){
		if(!is_null($this->start)){
			$this->formattedStart = date('d.m.Y H:i',$this->start);
		}
		if(!is_null($this->end)){
			$this->formattedEnd = date('d.m.Y H:i',$this->end);
		}

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Calendar the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
