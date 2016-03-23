<?php

/**
 * This is the model class for table "Countries".
 *
 * The followings are the available columns in table 'Countries':
 * @property string $id
 * @property string $name
 * @property string $default_language
 * @property string $key
 * @property integer $priority
 * @property string $currency_id
 *
 * The followings are the available model relations:
 * @property Cities[] $cities
 * @property Currencies $currency
 */
class Countries extends CActiveRecord
{
	private $_url = NULL;
	private $_publicUrl = NULL;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Countries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('priority', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>50),
            array('default_language, currency_id', 'length', 'max'=>10),
            array('key', 'length', 'max'=>5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, default_language, key, priority, currency_id', 'safe', 'on'=>'search'),
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
            'cities' => array(self::HAS_MANY, 'Cities', 'country_id'),
            'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('adminModule', 'ID'),
			'name' => Yii::t('adminModule', 'Country name'),
			'key' => Yii::t('adminModule', 'Key (for example: en, ru)'),
			'default_language' => Yii::t('adminModule', 'Default language'),
			'priority' => Yii::t('adminModule', 'Priority'),
            'currency_id' => Yii::t('adminModule','Currency ID'),

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
		$criteria->compare('t.key',$this->key,true);
		$criteria->compare('t.default_language',$this->default_language,true);
		$criteria->compare('t.priority',$this->priority);
        $criteria->compare('t.currency_id',$this->currency_id,true);


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
	 * @return Countries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAdminUrl() {
		if ($this->_url === null) {
			$this->_url = Yii::app()->createUrl('/admin/countries/update', array('id' => $this->id));
		}
		return $this->_url;
	}

	public function getPublicUrl(){
		if ($this->_publicUrl === null) {
			$this->_publicUrl = Yii::app()->createUrl('/countries/view', array('id' => $this->id));
		}
		return $this->_publicUrl;

	}

	public function beforeDelete(){
		if(sizeof($this->cities)>0){
			return false;
		}
		return parent::beforeDelete();
	}

	public static function getLanguagesListData(){
		return array('en' => 'en', 'ru' => 'ru');
	}

}
