<?php

/**
 * This is the model class for table "BannersPrices".
 *
 * The followings are the available columns in table 'BannersPrices':
 * @property string $id
 * @property string $city_id
 * @property string $category_id
 * @property double $price
 *
 * The followings are the available model relations:
 * @property Cities $city
 * @property DealsCategories $category
 */
class BannersPrices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'BannersPrices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price', 'numerical'),
			array('city_id, category_id', 'length', 'max'=>10),
			array('city_id, category_id', 'uniqueCategoryIdAndCityId'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, city_id, category_id, price', 'safe', 'on'=>'search'),
		);
	}

	public function uniqueCategoryIdAndCityId($attribute,$params){
		if (!$this->hasErrors() && $this->isNewRecord){
			$model = BannersPrices::model()->findByAttributes(array('category_id' => $this->category_id, 'city_id' => $this->city_id));
            if(!is_null($model)){
                $this->addError('category_id', Yii::t("eventsModule","This price already exists."));
                $this->addError('city_id', Yii::t("eventsModule","This price already exists."));
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
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
			'category' => array(self::BELONGS_TO, 'DealsCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_id' => 'City',
			'category_id' => 'Category',
			'price' => 'Price',
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
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BannersPrices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
