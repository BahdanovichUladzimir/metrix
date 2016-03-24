<?php

/**
 * This is the model class for table "Comments".
 *
 * The followings are the available columns in table 'Comments':
 * @property string $id
 * @property string $title
 * @property string $parent_id
 * @property string $description
 * @property string $app_category_id
 * @property string $app_category_item_id
 * @property integer $user_id
 * @property string $approve
 * @property string $created_date
 * @property string $published_date
 *
 * The followings are the available model relations:
 * @property AppCategories $appCategory
 * @property User $user
 */
class Comments extends CActiveRecord
{
    public $formattedPublishedDate = NULL;
    public $formattedCreatedDate = NULL;

    private $_adminUrl = NULL;
    private $_publicUrl = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Comments';
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
			array('description', 'isCanAddComment'),
			array('description', 'length', 'max'=>Yii::app()->config->get('COMMENTS_MODULE.COMMENT_MAX_LENGHT')),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('parent_id, app_category_item_id', 'length', 'max'=>11),
			array('app_category_id', 'length', 'max'=>3),
			array('approve', 'length', 'max'=>1),
			array('created_date, published_date', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, parent_id, description, app_category_id, app_category_item_id, user_id, approve, created_date, published_date', 'safe', 'on'=>'search'),
		);
	}

    public function isCanAddComment($attributes, $params){
        if(!$this->hasErrors())  // we only want to authenticate when no input errors
        {
            if($this->appCategory->id == Yii::app()->config->get("CORE.DEALS_APP_CATEGORY_ID")){
                if(!Yii::app()->user->getIsCanAddComment($this->app_category_item_id)){
                    $this->addError('description',Yii::t('commentsModule',"You can't add a comment to this deal."));
                }
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
			'appCategory' => array(self::BELONGS_TO, 'AppCategories', 'app_category_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}


    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('commentsModule','ID'),
			'title' => Yii::t('commentsModule','Title'),
			'parent_id' => Yii::t('commentsModule','Parent ID'),
			'description' => Yii::t('commentsModule','Comment text'),
			'app_category_id' => Yii::t('commentsModule','App category'),
			'app_category_item_id' => Yii::t('commentsModule','App category item ID'),
			'user_id' => Yii::t('commentsModule','User'),
			'approve' => Yii::t('commentsModule','Approve'),
			'created_date' => Yii::t('commentsModule','Created date'),
			'published_date' => Yii::t('commentsModule','Published date'),
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

        $criteria->order = 'approve ASC';
		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('app_category_id',$this->app_category_id,true);
		$criteria->compare('app_category_item_id',$this->app_category_item_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('approve',$this->approve,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('published_date',$this->published_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave(){
        if($this->approve == 1) {
            $this->published_date = time();
        }
        elseif($this->approve == 0){
            $this->published_date = 0;
        }
        if($this->isNewRecord) {
            $this->created_date = time();
        }
        return parent::beforeSave();
    }

    public function afterFind(){
        if($this->approve == 1) {
            $this->formattedPublishedDate = date("d.m.Y", $this->published_date);
        }
        $this->formattedCreatedDate = date("d.m.Y", $this->created_date);
    }

    public function getAdminUrl() {
        if (is_null($this->_adminUrl)) {
            $this->_adminUrl = Yii::app()->createUrl('/comments/backend/comments/view', array('id' => $this->id));
        }
        return $this->_adminUrl;
    }
    public function getPublicUrl() {
        if (is_null($this->_publicUrl)) {
            $this->_publicUrl = Yii::app()->createUrl('/comments/frontend/comments/view', array('id' => $this->id));
        }
        return $this->_publicUrl;
    }

    public static function getApproveListData(){
        return array(0=>'Not approved',1=>'Approved');
    }

    public function getAppCategoryItemLink(){
        if($this->appCategory->name == 'deals'){
            $deal = Deals::model()->findByPk($this->app_category_item_id);
			if(!is_null($deal)){
				return CHtml::link($deal->name,$deal->getPublicUrl());
			}
			else{
				return false;
			}
        }
        return false;
    }


}
