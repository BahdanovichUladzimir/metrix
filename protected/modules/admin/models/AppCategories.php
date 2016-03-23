<?php

/**
 * This is the model class for table "AppCategories".
 *
 * The followings are the available columns in table 'AppCategories':
 * @property string $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Comments[] $comments
 * @property Rating[] $ratings
 */
class AppCategories extends CActiveRecord
{
    private $_url = NULL;
    private $_publicUrl = NULL;
    public static $listData;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'AppCategories';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>255),
			array('name', 'required'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comments', 'app_category_id'),
			'ratings' => array(self::HAS_MANY, 'Rating', 'app_category_id'),
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
	 * @return AppCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getAdminUrl() {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl('/admin/appCategories/update', array('id' => $this->id));
        }
        return $this->_url;
    }

    public function getPublicUrl(){
        if ($this->_publicUrl === null) {
            $this->_publicUrl = Yii::app()->createUrl('/cities/view', array('id' => $this->id));
        }
        return $this->_publicUrl;

    }

    public static function getListData(){
        if(is_null(self::$listData)){
            self::$listData = CHtml::listData(self::model()->findAll(),'id','name');
        }
        return self::$listData;
    }

}
