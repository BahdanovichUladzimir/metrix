<?php

/**
 * This is the model class for table "CookiesFavorites".
 *
 * The followings are the available columns in table 'CookiesFavorites':
 * @property string $id
 * @property string $cookie_id
 * @property string $deal_id
 *
 * The followings are the available model relations:
 * @property FavoritesCookies $cookie
 * @property Deals $deal
 */
class CookiesFavorites extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'CookiesFavorites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cookie_id, deal_id', 'required'),
			array('cookie_id', 'length', 'max'=>32),
			array('deal_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cookie_id, deal_id', 'safe', 'on'=>'search'),
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
			'cookie' => array(self::BELONGS_TO, 'FavoritesCookies', 'cookie_id'),
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('core','ID'),
			'cookie_id' => Yii::t('core','Cookie'),
			'deal_id' => Yii::t('core','Deal ID'),
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
		$criteria->compare('cookie_id',$this->cookie_id,true);
		$criteria->compare('deal_id',$this->deal_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CookiesFavorites the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
