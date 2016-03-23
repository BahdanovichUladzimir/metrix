<?php

/**
 * This is the model class for table "Feedback".
 *
 * The followings are the available columns in table 'Feedback':
 * @property string $id
 * @property string $title
 * @property string $user_email
 * @property string $user_name
 * @property integer $user_id
 * @property string $status_id
 * @property integer $recipient_id
 * @property string $category_id
 * @property string $message
 * @property string $reply
 * @property string $created_date
 * @property string $reply_date
 *
 * The followings are the available model relations:
 * @property FeedbackStatuses $status
 * @property Users $recipient
 * @property FeedbackCategories $category
 */
class Feedback extends CActiveRecord
{

    public $verifyCode;
    public $formattedCreatedDate;
    public $formattedRepliedDate;


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Feedback';
	}

    public function behaviors(){
        return array(
            'SaveCreatedDateBehavior' => array(
                'class'=>'application.components.SaveCreatedDateBehavior',
                'createdDateAttribute' => 'created_date',
                'formattedCreatedDateAttribute' => 'formattedCreatedDate'
            ),
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
            array('title, message, user_name, user_email', 'required' , 'on' => 'guestCreate, authUserCreate'),
            array('verifyCode', 'required' , 'on' => 'guestCreate'),
            array('reply, recipient_id', 'required' , 'on' => 'adminReply'),
			array('user_email', 'email', /*'checkMX' => true, 'validateIDN' => true*/),
			array('user_id, recipient_id, category_id', 'numerical', 'integerOnly'=>true),
			array('title, user_email, user_name', 'length', 'max'=>255),
			array('message, reply', 'length', 'max'=>1000),
			array('status_id', 'length', 'max'=>11),
			array('created_date, reply_date', 'length', 'max'=>12),
            array(
                'verifyCode',
                'captcha',
                // авторизованным пользователям код можно не вводить
                'allowEmpty'=>!Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
                'on' => "guestCreate, authUserCreate"
            ),

            // The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, user_email, user_name, user_id, status_id, recipient_id, category_id, message, reply, created_date, reply_date', 'safe', 'on'=>'search'),
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
			'status' => array(self::BELONGS_TO, 'FeedbackStatuses', 'status_id'),
			'recipient' => array(self::BELONGS_TO, 'User', 'recipient_id'),
            'category' => array(self::BELONGS_TO, 'FeedbackCategories', 'category_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('feedbackModule','Message ID'),
			'title' => Yii::t('feedbackModule','Title'),
			'user_email' => Yii::t('feedbackModule','Email'),
			'user_name' => Yii::t('feedbackModule','User name'),
			'user_id' => Yii::t('feedbackModule','User ID'),
			'status_id' => Yii::t('feedbackModule','Status'),
			'recipient_id' => Yii::t('feedbackModule','Recipient ID'),
            'category_id' => Yii::t('feedbackModule','Category'),
            'message' => Yii::t('feedbackModule','Message text'),
			'reply' => Yii::t('feedbackModule','Reply text'),
			'created_date' => Yii::t('feedbackModule','Created date'),
			'reply_date' => Yii::t('feedbackModule','Reply created date'),
            'verifyCode' => Yii::t('feedbackModule','Verify code'),
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

		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.title',$this->title,true);
		$criteria->compare('t.user_email',$this->user_email,true);
		$criteria->compare('t.user_name',$this->user_name,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.status_id',$this->status_id,true);
		$criteria->compare('t.recipient_id',$this->recipient_id);
        $criteria->compare('t.category_id',$this->category_id,true);
        $criteria->compare('t.message',$this->message,true);
		$criteria->compare('t.reply',$this->reply,true);
		$criteria->compare('t.created_date',$this->created_date,true);
		$criteria->compare('t.reply_date',$this->reply_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder' => 't.status_id DESC',
            )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

    protected function afterFind() {
        parent::afterFind();
        $this->formattedRepliedDate = date("d.m.Y  H(idea)", $this->reply_date);
        $this->formattedCreatedDate = date("d.m.Y  H(idea)", $this->created_date);
    }
}
