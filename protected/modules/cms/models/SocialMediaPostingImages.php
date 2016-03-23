<?php

/**
 * This is the model class for table "SocialMediaPostingImages".
 *
 * The followings are the available columns in table 'SocialMediaPostingImages':
 * @property string $id
 * @property string $image_id
 * @property string $status
 * @property string $post_id
 *
 * The followings are the available model relations:
 * @property SocialMediaPosting $post
 * @property DealsImages $image
 */
class SocialMediaPostingImages extends CActiveRecord
{
	public static $statuses = array();

    public function init(){
        parent::init();
        self::$statuses = array(
            1 => Yii::t('cmsModule',"Not loaded"),
            2 => Yii::t('cmsModule',"Uploading"),
            3 => Yii::t('cmsModule',"Uploaded"),
        );
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'SocialMediaPostingImages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_id, post_id', 'length', 'max'=>10),
			array('status', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image_id, status, post_id', 'safe', 'on'=>'search'),
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
			'post' => array(self::BELONGS_TO, 'SocialMediaPosting', 'post_id'),
			'image' => array(self::BELONGS_TO, 'DealsImages', 'image_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image_id' => 'Deal image ID',
			'status' => 'Status',
			'post_id' => 'Post ID',
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
		$criteria->compare('image_id',$this->image_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('post_id',$this->post_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SocialMediaPostingImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
