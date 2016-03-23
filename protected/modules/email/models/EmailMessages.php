<?php

/**
 * This is the model class for table "EmailMessages".
 *
 * The followings are the available columns in table 'EmailMessages':
 * @property string $id
 * @property string $from
 * @property string $to
 * @property string $subject
 * @property string $message
 * @property string $created_date
 * @property string $sent_date
 * @property integer $recipient_id
 * @property string $is_sent
 * @property string $type_id
 *
 * The followings are the available model relations:
 * @property Users $recipient
 * @property EmailMessagesTypes $type
 */
class EmailMessages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'EmailMessages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'required'),
			array('recipient_id', 'numerical', 'integerOnly'=>true),
			array('from, to, subject', 'length', 'max'=>200),
			array('created_date, sent_date', 'length', 'max'=>10),
			array('is_sent', 'length', 'max'=>1),
			array('type_id', 'length', 'max'=>3),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, from, to, subject, message, created_date, sent_date, recipient_id, is_sent, type_id', 'safe', 'on'=>'search'),
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
			'recipient' => array(self::BELONGS_TO, 'Users', 'recipient_id'),
			'type' => array(self::BELONGS_TO, 'EmailMessagesTypes', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('core','ID'),
			'from' => Yii::t('core','From email'),
			'to' => Yii::t('core','To email'),
			'subject' => Yii::t('core','Subject'),
			'message' => Yii::t('core','Message'),
			'created_date' => Yii::t('core','Created date'),
			'sent_date' => Yii::t('core','Sent date'),
			'recipient_id' => Yii::t('core','Recipient user ID'),
			'is_sent' => Yii::t('core','Is sent'),
			'type_id' => Yii::t('core','Type ID'),
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
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('sent_date',$this->sent_date,true);
		$criteria->compare('recipient_id',$this->recipient_id);
		$criteria->compare('is_sent',$this->is_sent,true);
		$criteria->compare('type_id',$this->type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmailMessages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
