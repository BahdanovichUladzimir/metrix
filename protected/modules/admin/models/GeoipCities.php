<?php

/**
 * This is the model class for table "geoipCities".
 *
 * The followings are the available columns in table 'geoipCities':
 * @property integer $id
 * @property integer $geoip_city_id
 * @property string $city_name_ru
 * @property string $district
 * @property string $region
 * @property integer $geoip_country_id
 * @property string $latitude
 * @property string $longitude
 */
class GeoipCities extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geoipCities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('geoip_city_id, geoip_country_id', 'numerical', 'integerOnly'=>true),
			array('city_name_ru, district, region', 'length', 'max'=>255),
			array('latitude, longitude', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, geoip_city_id, city_name_ru, district, region, geoip_country_id, latitude, longitude', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'geoip_city_id' => 'geoIP city ID',
			'city_name_ru' => 'City name RU',
			'district' => 'District',
			'region' => 'Region',
			'geoip_country_id' => 'Country',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('geoip_city_id',$this->geoip_city_id);
		$criteria->compare('city_name_ru',$this->city_name_ru,true);
		$criteria->compare('district',$this->district,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('geoip_country_id',$this->geoip_country_id);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GeoipCities the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getListData(){
		$criteria = new CDbCriteria();
		$criteria->order = 'city_name_ru ASC';
		return CHtml::listData(self::model()->findAll($criteria),'id','city_name_ru');
	}
}
