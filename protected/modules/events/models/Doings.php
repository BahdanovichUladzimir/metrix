<?php

/**
 * This is the model class for table "Doings".
 *
 * The followings are the available columns in table 'Doings':
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property EventsDoingsCategories $category
 * @property EventsTypesDoings[] $eventsTypesDoings
 * @property EventsTypes[] $eventsTypes
 */
class Doings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Doings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'required'),
			array('category_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, name, description', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'EventsDoingsCategories', 'category_id'),
			'eventsTypesDoings' => array(self::HAS_MANY, 'EventsTypesDoings', 'doing_id'),
			'eventsTypes' => array(self::MANY_MANY, 'EventsTypes', 'EventsTypesDoings(doing_id,type_id)'),
		);
	}

    public function behaviors(){
        return array(
            'ESaveRelatedBehavior' => array(
                'class' => 'application.components.ESaveRelatedBehavior'
            ),
        );
    }


    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category ID',
			'name' => 'Name',
			'description' => 'Description',
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
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTypesString(){
		return implode(", ", CHtml::listData($this->eventsTypes, 'id', 'label'));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Doings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
