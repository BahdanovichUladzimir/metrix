<?php

/**
 * This is the model class for table "DealsCategoriesParams".
 *
 * The followings are the available columns in table 'DealsCategoriesParams':
 * @property string $id
 * @property string $deal_category_id
 * @property string $deal_param_id
 *
 * The followings are the available model relations:
 * @property DealsCategories $dealCategory
 * @property DealsParams $dealParam
 */
class DealsCategoriesParams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsCategoriesParams';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deal_category_id, deal_param_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deal_category_id, deal_param_id', 'safe', 'on'=>'search'),
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
			'dealCategory' => array(self::BELONGS_TO, 'DealsCategories', 'deal_category_id'),
			'dealParam' => array(self::BELONGS_TO, 'DealsParams', 'deal_param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Уникальный идентификатор записи',
			'deal_category_id' => 'Идентификатор категории предложения',
			'deal_param_id' => 'Идентификатор параметра предложения',
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
		$criteria->compare('deal_category_id',$this->deal_category_id,true);
		$criteria->compare('deal_param_id',$this->deal_param_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsCategoriesParams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
