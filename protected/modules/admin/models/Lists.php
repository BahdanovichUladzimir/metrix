<?php

/**
 * This is the model class for table "List".
 *
 * The followings are the available columns in table 'List':
 * @property string $id
 * @property string $name
 * @property string $type
 *
 * The followings are the available model relations:
 * @property ListItems[] $listItems
 */
class Lists extends CActiveRecord
{

    public static $listsTypes = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Lists';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type', 'length', 'max'=>50),
			array('name', 'required'),
			array('name', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type', 'safe', 'on'=>'search'),
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
			'listItems' => array(
				self::HAS_MANY,
				'ListItems',
				'list_id',
				'order' => 'listItems.sort ASC, listItems.name ASC'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('adminModule','ID'),
			'name' => Yii::t('adminModule','Name'),
			'type' => Yii::t('adminModule','Type'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);

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
	 * @return Lists the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getListData(){
		$criteria = new CDbCriteria();
		$criteria->order = 'name ASC';
        return CHtml::listData(self::model()->findAll($criteria),'id', 'name');
    }

    public function getListItemsListData(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'list_id=:list_id';
        $criteria->params = array('list_id'=>$this->id);
        $criteria->order = 'sort ASC, name ASC';
        return CHtml::listData(ListItems::model()->findAll($criteria),'value','name');
    }

    public static function getListsTypes(){
        if(is_null(self::$listsTypes)){
            self::$listsTypes = array(
                'single' => 'Single',
                'multiple' => 'Multiple'
            );
        }
        return self::$listsTypes;
    }
}
