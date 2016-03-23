<?php

/**
 * This is the model class for table "Currencies".
 *
 * The followings are the available columns in table 'Currencies':
 * @property string $id
 * @property string $name
 * @property string $key
 * @property float $rate
 * @property int $date
 *
 * The followings are the available model relations:
 * @property Countries[] $countries
 * @property Deals[] $deals
 */
class Currencies extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Currencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, key', 'required'),
			array('name', 'length', 'max'=>50),
			array('key', 'length', 'max'=>10),
			array('rate, date', 'numerical'),
			array('date', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, key, rate, date', 'safe', 'on'=>'search'),
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
			'countries' => array(self::HAS_MANY, 'Countries', 'currency_id'),
			'deals' => array(self::HAS_MANY, 'Deals', 'currency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('adminModule','Currency ID'),
			'name' => Yii::t('adminModule','Currency name'),
			'key' => Yii::t('adminModule','Currency key'),
			'rate' => Yii::t('adminModule','Currency rate'),
			'date' => Yii::t('adminModule','Update date'),
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
		$criteria->compare('key',$this->key,true);
		//$criteria->compare('rate',$this->rate,true);
		//$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currencies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getCurrenciesListData(){
        return CHtml::listData(self::model()->findAll(),'id', 'name');
    }

}
