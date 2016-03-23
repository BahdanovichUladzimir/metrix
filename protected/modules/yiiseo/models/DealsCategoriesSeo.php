<?php

/**
 * This is the model class for table "DealsCategoriesSeo".
 *
 * The followings are the available columns in table 'DealsCategoriesSeo':
 * @property string $id
 * @property string $category_id
 * @property string $city_id
 * @property string $title
 * @property string $h1
 * @property string $description
 * @property string $keywords
 * @property string $seotext
 * @property string $language
 */
class DealsCategoriesSeo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsCategoriesSeo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, city_id, title, h1, language', 'required'),
			array('category_id', 'length', 'max'=>11),
			array('city_id', 'length', 'max'=>10),
            array('category_id','uniqueCategoryIdAndCityIdAndLanguage'),
			array('seotext', 'length', 'min'=>1),
			array('h1, title', 'length', 'max'=>255),
			array('description, keywords', 'length', 'max'=>1000),
			array('language', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, city_id, title, h1, description, keywords, seotext, language', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'DealsCategories', 'category_id'),
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('yiiseoModule','ID'),
			'category_id' => Yii::t('yiiseoModule','Category'),
			'city_id' => Yii::t('yiiseoModule','City'),
			'h1' => Yii::t('yiiseoModule','H1'),
			'title' => Yii::t('yiiseoModule','Title'),
			'description' => Yii::t('yiiseoModule','Description'),
			'keywords' => Yii::t('yiiseoModule','Keywords'),
			'seotext' => Yii::t('yiiseoModule','Seo text'),
			'language' => Yii::t('yiiseoModule','Language'),
		);
	}

    public function uniqueCategoryIdAndCityIdAndLanguage($attribute,$params=array())
    {
        if (!$this->hasErrors()) {
            $params['criteria'] = array(
                'condition' => 'city_id=:city_id AND language=:language',
                'params' => array(
                    ':city_id' => $this->city_id,
                    ':language' => $this->language
                ),
            );
            $validator = CValidator::createValidator('unique', $this, $attribute, $params);
            $validator->validate($this, array($attribute));
        }
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
		$criteria->compare('category_id',$this->category_id,false);
		$criteria->compare('city_id',$this->city_id,false);
		$criteria->compare('h1',$this->h1,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('seotext',$this->seotext,true);
		$criteria->compare('language',$this->language,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsCategoriesSeo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getLanguagesListData(){

    }
}
