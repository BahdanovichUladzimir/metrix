<?php

/**
 * This is the model class for table "FeedbackCategories".
 *
 * The followings are the available columns in table 'FeedbackCategories':
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $description
 * @property string $status_id
 *
 * The followings are the available model relations:
 * @property FeedbackCategoriesStatuses $status
 * @property FeedbackQuestions[] $feedbackQuestions
 */
class FeedbackCategories extends CActiveRecord
{

    private $_parent = NULL;
    private $_children = NULL;
    private $_url = NULL;
    private $_publicUrl = NULL;

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'FeedbackCategories';
	}

    public function behaviors(){
        return array('ESaveRelatedBehavior' => array(
            'class' => 'application.components.ESaveRelatedBehavior')
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			array('status_id', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, name, description, status_id', 'safe', 'on'=>'search'),
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
			'status' => array(self::BELONGS_TO, 'FeedbackCategoriesStatuses', 'status_id'),
			'feedbackQuestions' => array(self::HAS_MANY, 'FeedbackQuestions', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('FeedbackCategories','Category ID'),
			'parent_id' => Yii::t('FeedbackCategories','Parent category'),
			'name' => Yii::t('FeedbackCategories','Name'),
			'description' => Yii::t('FeedbackCategories','Description'),
			'status_id' => Yii::t('FeedbackCategories','Status'),
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
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status_id',$this->status_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FeedbackCategories the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getParent(){
        if($this->_parent === NULL){
            $this->_parent = self::model()->findByPk($this->parent_id);
        }
        return $this->_parent;
    }

    /**
     * @return array
     */
    public function getChildren(){
        if(is_null($this->_children)){
            $criteria = new CDbCriteria;
            $criteria->condition = ':parent_id=parent_id';
            $criteria->params = array(
                ':parent_id' => $this->id,
            );
            $this->_children = self::model()->findAll($criteria);
        }
        return $this->_children;
    }
    /**
     * @return array
     */
    public function getChildrenListData(){
        $children = $this->getChildren();
        $childrenListData = array();
        if(sizeof($children)>0){
            foreach($children as $child){
                /**
                 * @var $child $this
                 */
                $childrenListData[$child->id] = \CHtml::link($child->name,$child->getAdminUrl());
            }
        }
        return $childrenListData;
    }

    /**
     * @param bool $structured
     * @param bool $isNoneItem
     * @return array
     * return list data array for dropdown widget
     */
    public static function getListData($structured = true, $isNoneItem = true){
        if($structured){
            if($isNoneItem){
                return self::getDropdownItems()+array(0=>Yii::t("dealsModule",'None'));
            }
            else{
                return self::getDropdownItems();
            }
        }
        else{
            $listData = CHtml::listData(self::model()->findAll(array('order'=>'name ASC')),'id','name');
            if($isNoneItem){
                $listData = array_merge(array(0 => array(1 => Yii::t('dealsModule', 'None'))),$listData);
            }
            return $listData;
        }
    }

    public static function getDropdownItems($parentId=0, $level=0) {

        $categoriesFormatted = array();
        $categories = self::model()->findAllByAttributes(array(
            'parent_id' => $parentId,
        ));
        foreach ($categories as $category){
            $categoriesFormatted[(int)$category->id] = str_repeat('-', $level) ." ".$category->name;
            $children = self::getDropdownItems((int)$category->id, $level+1);
            $categoriesFormatted = $categoriesFormatted+$children;
        }
        return $categoriesFormatted;
    }

    public function getAdminUrl() {
        if ($this->_url === null) {
            $this->_url = Yii::app()->createUrl('/deals/backend/dealsCategories/view', array('id' => $this->id));
        }
        return $this->_url;
    }

    public function getPublicUrl(){
        if ($this->_publicUrl === null) {
            $this->_publicUrl = Yii::app()->createUrl('/categories/view', array('id' => $this->id));
        }
        return $this->_publicUrl;

    }
}
