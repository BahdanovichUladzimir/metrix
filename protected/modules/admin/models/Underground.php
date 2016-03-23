<?php

/**
 * This is the model class for table "Underground".
 *
 * The followings are the available columns in table 'Underground':
 * @property string $id
 * @property string $city_id
 * @property string $name
 * @property double $longitude
 * @property double $latitude
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property Cities $city
 */
class Underground extends CActiveRecord
{
	public $citiesSearch;

	private $_url = NULL;
	private $_publicUrl = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Underground';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_id,name', 'required'),
			array('priority', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude', 'numerical'),
			array('city_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, city_id, name, longitude, latitude, priority, citiesSearch', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('adminModule', 'ID'),
			'city_id' => Yii::t('adminModule', 'City name'),
			'name' => Yii::t('adminModule', 'Underground name'),
			'longitude' => Yii::t('adminModule', 'Longitude'),
			'latitude' => Yii::t('adminModule', 'Latitude'),
			'priority' => Yii::t('adminModule', 'Priority'),
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
	 * @return KeenActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array(
			'city',
		);
		$criteria->together=true;
		$criteria->group=('t.id');

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.city_id',$this->city_id,true);
		$criteria->compare('t.name',$this->name,true);
		//$criteria->compare('t.longitude',$this->longitude);
		//$criteria->compare('t.latitude',$this->latitude);
		$criteria->compare('t.priority',$this->priority);

		if($this->citiesSearch){

			$criteria->compare('city.name',$this->citiesSearch,true);
		}
		return new KeenActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'withKeenLoading' => array('city'),
			'pagination'=>array(
				'pageSize'=>50,
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Underground the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAdminUrl() {
		if ($this->_url === null) {
			$this->_url = Yii::app()->createUrl('/admin/underground/update', array('id' => $this->id));
		}
		return $this->_url;
	}

	public function getPublicUrl(){
		if ($this->_publicUrl === null) {
			$this->_publicUrl = Yii::app()->createUrl('/underground/view', array('id' => $this->id));
		}
		return $this->_publicUrl;

	}

	//scopes
	/**
	 * Scope для поиск метро в радиусе $distance от точки с координатами $latitude, $longitude
	 *
	 * $ER = 6371 - радиус земли в километрах (Средний радиус Земли -  6 371 302 м. )
	 * @param float $latitude latitude широта
	 * @param float $longitude longitude долгота
	 * @param int $distance дистанция в километрах от заданных координат
	 * @return $this
	 */
	public function coordinates($latitude=0,$longitude=0,$distance=1)
	{
		$ER = 6371;
		$this->getDbCriteria()->mergeWith(array(
			'select'=>'t.*,( '.$ER.' * acos( cos( radians(:latitude) ) * cos( radians( t.latitude ) ) * cos( radians( t.longitude ) - radians(:longitude) ) + sin( radians(:latitude) ) * sin( radians( t.latitude ) ) ) ) AS distance',
			'order'=>'distance ASC',
			'having'=>'distance < :distance',
			'params'=>array(
				':latitude'=>$latitude,
				':longitude'=>$longitude,
				':distance'=>$distance

			)
		));
		return $this;
	}

}
