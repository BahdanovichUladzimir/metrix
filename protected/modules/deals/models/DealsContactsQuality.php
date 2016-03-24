<?php

/**
 * This is the model class for table "DealsContactsQuality".
 *
 * The followings are the available columns in table 'DealsContactsQuality':
 * @property string $id
 * @property string $deal_id
 * @property integer $quality
 *
 * The followings are the available model relations:
 * @property Deals $deal
 */
class DealsContactsQuality extends CActiveRecord
{
	public $dealName = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsContactsQuality';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quality', 'numerical', 'integerOnly'=>true),
			array('deal_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deal_id, quality, dealName', 'safe', 'on'=>'search'),
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
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dealsModule','ID'),
			'deal_id' => Yii::t('dealsModule','Deal'),
			'quality' => Yii::t('dealsModule','Quality'),
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
        $criteria->with = array(
            'deal',
        );
        $criteria->together=true;
        $criteria->order='t.quality ASC';

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.deal_id',$this->deal_id,true);
		$criteria->compare('t.quality',$this->quality);
        if(!is_null($this->dealName)){
            $criteria->compare('deal.name',$this->dealName,true);
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsContactsQuality the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
