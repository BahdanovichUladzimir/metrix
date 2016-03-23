<?php

/**
 * This is the model class for table "SocialMediaPosting".
 *
 * The followings are the available columns in table 'SocialMediaPosting':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $link
 * @property string $post_date_time
 * @property string $posted_date_time
 * @property integer $status
 * @property string $type
 * @property string $network
 * @property SocialMediaPostingImages[] $images
 */
class SocialMediaPosting extends CActiveRecord
{
    public static $statuses = array();
    public static $types = array();
    public static $networks = array();

    public function init(){
        parent::init();
        self::$statuses = array(
            1 => Yii::t('cmsModule',"Not published"),
            2 => Yii::t('cmsModule',"To publish"),
            3 => Yii::t('cmsModule',"Published"),
        );
        self::$types = array(
            1 => Yii::t('cmsModule',"Page"),
            2 => Yii::t('cmsModule',"Deal"),
        );
        self::$networks = array(
            1 => Yii::t('cmsModule',"Vkontakte"),
            2 => Yii::t('cmsModule',"Facebook"),
        );
    }

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'SocialMediaPosting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, title, type, post_date_time, network, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('type, network', 'length', 'max'=>3),
			array('link', 'url'),
			array('lang', 'length', 'max'=>50),
			array('post_date_time, posted_date_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, post_date_time, posted_date_time, status, type, network, lang', 'safe', 'on'=>'search'),
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
            'images' => array(
                self::HAS_MANY,
                'SocialMediaPostingImages',
                'post_id'
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("cmsModule",'ID'),
			'title' => Yii::t("cmsModule",'Title'),
			'description' => Yii::t("cmsModule",'Description'),
			'link' => Yii::t("cmsModule",'Link'),
			'post_date_time' => Yii::t("cmsModule",'Post DateTime'),
			'posted_date_time' => Yii::t("cmsModule",'Posted DateTime'),
			'status' => Yii::t("cmsModule",'Status'),
			'type' => Yii::t("cmsModule",'Type'),
			'network' => Yii::t("cmsModule",'Network'),
			'lang' => Yii::t("cmsModule",'Language'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('post_date_time',$this->post_date_time,true);
		$criteria->compare('posted_date_time',$this->posted_date_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('network',$this->network,true);
		$criteria->compare('lang',$this->lang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getStatusName(){
        return self::$statuses[$this->status];
    }
    public function getTypeName(){
        return self::$types[$this->type];
    }
    public function getNetworkName(){
        return self::$networks[$this->network];
    }
	public function beforeSave(){
		$this->title = strip_tags(trim($this->title));
		$this->description = strip_tags(trim($this->description));
		return parent::BeforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SocialMediaPosting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
