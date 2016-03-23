<?php

/**
 * This is the model class for table "ListItems".
 *
 * The followings are the available columns in table 'ListItems':
 * @property string $id
 * @property string $list_id
 * @property string $name
 * @property string $value
 * @property string|int $sort
 *
 * The followings are the available model relations:
 * @property Lists $list
 */
class ListItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ListItems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('list_id, name, value', 'required'),
            array('value','uniqueListValue'),
			array('name, value', 'length', 'max'=>50),
			array('sort', 'length', 'max'=>10),
			array('sort', 'default', 'value'=>0),
			array('sort', 'numerical', 'integerOnly'=>true, 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, list_id, name, value, sort', 'safe', 'on'=>'search'),
		);
	}

    public function uniqueListValue($attribute,$params=array())
    {
        if (!$this->hasErrors()){
            $criteria = new CDbCriteria();
            $criteria->condition = 'list_id=:list_id AND value=:value';
            $criteria->params = array(
                ":list_id" => $this->list_id,
                ":value" => $this->value
            );
			if (!$this->isNewRecord){
				$criteria->condition .=" and id!=$this->id";
			}
            $item = self::model()->find($criteria);
            if(!is_null($item)){
                $this->addError('value',Yii::t('adminModule','Item already exists in this list'));
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
			'list' => array(self::BELONGS_TO, 'Lists', 'list_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('adminModule','ID'),
			'list_id' => Yii::t('adminModule','List ID'),
			'name' => Yii::t('adminModule','Name'),
			'value' => Yii::t('adminModule','Value'),
			'sort' => Yii::t('adminModule','Sort'),
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

		$criteria->compare('id',$this->id,false);
		$criteria->compare('list_id',$this->list_id,false);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('sort',$this->sort,true);
        $criteria->order = 'list_id ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>20, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ListItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
