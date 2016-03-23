<?php

/**
 * This is the model class for table "Dialogues".
 *
 * The followings are the available columns in table 'Dialogues':
 * @property string $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property integer $created_at
 * @property string $sender_new_messages
 * @property string $receiver_new_messages
 * @property string $sender_messages
 * @property string $receiver_messages
 *
 * The followings are the available model relations:
 * @property User $sender
 * @property User $receiver
 * @property UserMessages[] $userMessages
 */
class Dialogues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Dialogues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender_new_messages, receiver_new_messages, sender_messages, receiver_messages, sender_id, receiver_id, created_at', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sender_id, receiver_id, created_at, sender_new_messages, receiver_new_messages, sender_messages, receiver_messages', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        $userId = Yii::app()->user->getId();

        $condition = '(`userMessages`.`sender_id`=:user_id AND (`userMessages`.`deleted_by`!="sender" OR `userMessages`.`deleted_by` IS NULL)) OR (`userMessages`.`sender_id`!=:user_id AND (`userMessages`.`deleted_by`!="receiver" OR `userMessages`.`deleted_by` IS NULL))';
		return array(
			'sender' => array(self::BELONGS_TO, 'User', 'sender_id'),
			'receiver' => array(self::BELONGS_TO, 'User', 'receiver_id'),
			'userMessages' => array(
                self::HAS_MANY,
                'UserMessages',
                'dialog_id',
                'condition' => $condition,
                'params' => array(
                    ':user_id' => $userId
                ),
                'order'=>'userMessages.created_at DESC',
                'limit'=>20
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('core','ID'),
			'sender_id' => Yii::t('core','Sender ID'),
			'receiver_id' => Yii::t('core','Receiver ID'),
			'created_at' => Yii::t('core','Created at'),
			'sender_new_messages' => Yii::t('core','Sender new messages'),
			'receiver_new_messages' => Yii::t('core','Receiver new messages'),
			'sender_messages' => Yii::t('core','Sender messages'),
			'receiver_messages' => Yii::t('core','Receiver messages'),
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
		$criteria->compare('sender_id',$this->sender_id);
		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('sender_new_messages',$this->sender_new_messages,true);
		$criteria->compare('receiver_new_messages',$this->receiver_new_messages,true);
		$criteria->compare('sender_messages',$this->sender_messages,true);
		$criteria->compare('receiver_messages',$this->receiver_messages,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dialogues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterFind(){

    }

    public function beforeSave(){
        if($this->isNewRecord){
            $this->created_at = time();
        }
        return parent::beforeSave();
    }

    public function getErrorsString(){
        if($this->hasErrors()){
            $errorsString = '';
            foreach($this->getErrors() as $attribute => $errors){
                $errorsString.=implode(' ',$errors)." ";
            }
            return $errorsString;
        }
        else{
            return '';
        }
    }

    public function userDelete(){
        $connection = $this->getDbConnection();
        $transaction = $connection->beginTransaction();
        foreach($this->userMessages as $message){
            if(!$message->userDelete()){
                $transaction->rollback();
                return false;
            }
        }
        $transaction->commit();
        return true;
    }
}
