<?php

/**
 * This is the model class for table "Cities".
 *
 * The followings are the available columns in table 'Cities':
 * @property string $id
 * @property string $name
 * @property string $country_id
 * @property string $key
 * @property string $seo_title
 * @property integer $priority
 * @property integer $noindex
 * @property double $longitude
 * @property double $latitude
 *
 * The followings are the available model relations:
 * @property Countries $country
 * @property Districts[] $districts
 * @property Underground[] $undergrounds
 * @property GeoipCities[] $geoipCities
 */
class Cities extends CActiveRecord
{
	private $_url = NULL;
	private $_publicUrl = NULL;
	private $_catalogUrl = NULL;
    protected $geoipCitiesArray;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Cities';
	}

	public function scopes()
	{
		return array(
			'indexed'=>array(
				'condition'=>'t.noindex = 0',
			),
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
			array('name, country_id, key', 'required'),
			array('priority', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude', 'numerical'),
			array('name', 'length', 'max'=>100),
			array('country_id', 'length', 'max'=>11),
			array('noindex', 'length', 'max'=>1),
			array('key, seo_title', 'length', 'max'=>50),
			array('geoipCities', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, country_id, key, priority, longitude, latitude', 'safe', 'on'=>'search'),
            array('geoipCitiesArray', 'safe')
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
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
			'districts' => array(self::HAS_MANY, 'Districts', 'city_id'),
			'undergrounds' => array(self::HAS_MANY, 'Underground', 'city_id'),
			'citiesGeoipCities' => array(self::HAS_MANY, 'CitiesGeoipCities', 'city_id'),
            'geoipCities'=>array(self::MANY_MANY, 'GeoipCities', 'Cities_GeoipCities(city_id, geoip_city_id)'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('adminModule', 'ID'),
			'name' => Yii::t('adminModule', 'City name'),
			'country_id' => Yii::t('adminModule', 'Country name'),
			'key' => Yii::t('adminModule', 'Key'),
			'noindex' => Yii::t('adminModule', 'No index'),
			'seo_title' => Yii::t('adminModule', 'SEO title'),
			'priority' => Yii::t('adminModule', 'Priority'),
			'longitude' => Yii::t('adminModule', 'Longitude'),
			'latitude' => Yii::t('adminModule', 'Latitude'),
            'geoipCities' => Yii::t('adminModule', 'GeoIp cities'),
            'geoipCitiesArray' => Yii::t('adminModule', 'GeoIp cities'),
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

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.country_id',$this->country_id,true);
		$criteria->compare('t.key',$this->key,true);
		$criteria->compare('t.noindex',$this->noindex,true);
		$criteria->compare('t.seo_title',$this->seo_title,true);
		$criteria->compare('t.priority',$this->priority);
		//$criteria->compare('t.longitude',$this->longitude);
		//$criteria->compare('t.latitude',$this->latitude);

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
	 * @return Cities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAdminUrl() {
		if ($this->_url === null) {
			$this->_url = Yii::app()->createUrl('/admin/cities/update', array('id' => $this->id));
		}
		return $this->_url;
	}

	public function getPublicUrl(){
		if ($this->_publicUrl === null) {
			$this->_publicUrl = Yii::app()->createUrl('/cities/view', array('id' => $this->id));
		}
		return $this->_publicUrl;

	}

    public function getCatalogUrl(){
        if (is_null($this->_catalogUrl)) {
            $this->_catalogUrl = Yii::app()->createUrl('/deals/frontend/catalog/index', array('city' => $this->key));
        }
        return $this->_catalogUrl;
    }

    public static function getAllCitiesListData(){
        return CHtml::listData(self::model()->findAll(),'id', 'name');
    }

    public static function getNoIndexListData(){
        return array('0' => 'index', '1' => 'no index');
    }

	public function getUndergroundListData(){
		return CHtml::listData($this->undergrounds,'id', 'name');
	}

    public function beforeSave(){
        if(isset($this->geoipCitiesArray) && is_array($this->geoipCitiesArray) && sizeof($this->geoipCitiesArray)>0){
            if(!$this->getIsNewRecord()){
                CitiesGeoipCities::model()->deleteAllByAttributes(array('city_id'=>$this->id));
            }
            foreach($this->geoipCitiesArray as $geoipCity){
                $model = new CitiesGeoipCities();
                $model->city_id = $this->id;
                $model->geoip_city_id = $geoipCity;
                $model->save();
            }
        }
        return parent::beforeSave();
    }

	public function getDealsCount(){
		return Deals::model()->countByAttributes(array('city_id' => $this->id));
	}
	public function getUsersCount(){
		return Profile::model()->countByAttributes(array('city_id' => $this->id));
	}

    public function getGeoipCitiesArray()
    {
        if ($this->geoipCitiesArray===null)
            $this->geoipCitiesArray=CHtml::listData($this->geoipCities, 'id', 'id');
        return $this->geoipCitiesArray;
    }

    public function setGeoipCitiesArray($value)
    {
        $this->geoipCitiesArray=$value;
    }
}
