<?php

/**
 * This is the model class for table "DealsParamsValues".
 *
 * The followings are the available columns in table 'DealsParamsValues':
 * @property string $id
 * @property string $deal_id
 * @property string $param_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Deals $deal
 * @property DealsParams $param
 */
class DealsParamsValues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsParamsValues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('deal_id, param_id', 'length', 'max'=>11),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, deal_id, param_id, value', 'safe', 'on'=>'search'),
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
			'param' => array(self::BELONGS_TO, 'DealsParams', 'param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('core','ID'),
			'deal_id' => Yii::t('core','Deal ID'),
			'param_id' => Yii::t('core','Param ID'),
			'value' => Yii::t('core','Value'),
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
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('param_id',$this->param_id,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsParamsValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return bool
	 */
	public function beforeSave(){
		if ($this->param->type->name == "phone"){
			$this->value = preg_replace("/[^0-9]/", "", $this->value);
		}
        return parent::beforeSave();
	}
}
