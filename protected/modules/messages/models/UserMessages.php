<?php

/**
 * This is the model class for table "UserMessages".
 *
 * The followings are the available columns in table 'UserMessages':
 * @property string $id
 * @property string $body
 * @property string $is_read
 * @property string $deleted_by
 * @property string $created_at
 * @property string $dialog_id
 * @property integer $sender_id
 *
 * The followings are the available model relations:
 * @property Dialogues $dialog
 * @property User $sender
 */
class UserMessages extends CActiveRecord
{
    public $receiverId = NULL;
    public $formattedCreatedAt = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'UserMessages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('body', 'required'),
			array('sender_id', 'numerical', 'integerOnly'=>true),
			array('is_read', 'length', 'max'=>1),
			array('deleted_by', 'length', 'max'=>8),
			array('created_at', 'length', 'max'=>12),
			array('dialog_id', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, body, is_read, deleted_by, created_at, dialog_id, sender_id', 'safe', 'on'=>'search'),
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
			'dialog' => array(self::BELONGS_TO, 'Dialogues', 'dialog_id'),
			'sender' => array(self::BELONGS_TO, 'User', 'sender_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('core','ID'),
			'body' => Yii::t('core','Body'),
			'is_read' => Yii::t('core','Is read'),
			'deleted_by' => Yii::t('core','Deleted by'),
			'created_at' => Yii::t('core','Created at'),
			'dialog_id' => Yii::t('core','Dialog ID'),
			'sender_id' => Yii::t('core','Sender ID'),
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
		$criteria->compare('body',$this->body,true);
		$criteria->compare('is_read',$this->is_read,true);
		$criteria->compare('deleted_by',$this->deleted_by,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('dialog_id',$this->dialog_id,true);
		$criteria->compare('sender_id',$this->sender_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave(){
        if($this->isNewRecord){
            $this->created_at = time();
        }
        return parent::beforeSave();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserMessages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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

    public function afterSave(){
        $dialog = $this->dialog;
        if($this->isNewRecord){
            if($dialog->receiver_id == $this->sender_id){
                $sql = "UPDATE `Dialogues` SET `sender_messages` = `sender_messages`+1, `receiver_messages` = `receiver_messages`+1, `sender_new_messages`=`sender_new_messages`+1 WHERE `id`=".$this->dialog_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->execute();
            }
            elseif($dialog->sender_id == $this->sender_id){
                $sql = "UPDATE `Dialogues` SET `sender_messages` = `sender_messages`+1, `receiver_messages` = `receiver_messages`+1, `receiver_new_messages`=`receiver_new_messages`+1 WHERE `id`=".$this->dialog_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->execute();
            }
            else{
                //return false;
            }
        }
    }

    public function recountUserNewMessages(){
        $dialog = $this->dialog;
        if($this->is_read == 1){
            if(Yii::app()->user->getId() == $dialog->sender_id){
                $sql = "UPDATE `Dialogues` SET  `sender_new_messages`=`sender_new_messages`-1 WHERE `id`=".$this->dialog_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->execute();
            }
            elseif(Yii::app()->user->getId() == $dialog->receiver_id){
                $sql = "UPDATE `Dialogues` SET  `receiver_new_messages`=`receiver_new_messages`-1 WHERE `id`=".$this->dialog_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->execute();
            }
            else{
                //return false;
            }
        }
    }

    public function recountDialogMessages(){
        $dialog = $this->dialog;
        if(Yii::app()->user->getId() == $dialog->sender_id){
            $sql = "UPDATE `Dialogues` SET `sender_messages`=`sender_messages`-1 WHERE `id`=".$this->dialog_id;
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
        }
        elseif(Yii::app()->user->getId() == $dialog->receiver_id){
            $sql = "UPDATE `Dialogues` SET `receiver_messages`=`receiver_messages`-1 WHERE `id`=".$this->dialog_id;
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->execute();
        }
        else{
            //return false;
        }
    }

    public function afterDelete(){
        if(sizeof($this->dialog->userMessages) == 0){
            if($this->dialog->delete()){
                return parent::afterDelete();
            }
            else{
                return false;
            }
        }
    }

    public function afterFind(){
        if(is_null($this->receiverId)){
            if($this->sender_id == $this->dialog->sender_id){
                $this->receiverId = $this->dialog->receiver_id;
            }
            elseif($this->sender_id == $this->dialog->receiver_id){
                $this->receiverId = $this->dialog->sender_id;
            }
            else{
                $this->receiverId = NULL;
            }
        }
    }

    public function userDelete(){
        $user_id = Yii::app()->user->getId();
        if($this->is_read == 0){
            if($user_id == $this->dialog->sender_id){
                $sql = "UPDATE `Dialogues` SET  `sender_new_messages`=`sender_new_messages`-1 WHERE `id`=".$this->dialog_id." AND `sender_new_messages`>0";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->execute();
            }
            elseif($user_id == $this->dialog->receiver_id){
                $sql = "UPDATE `Dialogues` SET  `receiver_new_messages`=`receiver_new_messages`-1 WHERE `id`=".$this->dialog_id." AND `receiver_new_messages`>0";
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->execute();
            }
            else{
                //return false;
            }
        }
        if(is_null($this->deleted_by)){
            if($user_id == $this->sender_id){
                $this->deleted_by = 'sender';
            }
            elseif($user_id == $this->receiverId){
                $this->deleted_by = 'receiver';
            }
            if($this->save()){
                $this->recountDialogMessages();
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $deletedBy = $this->deleted_by;
            if($deletedBy == "sender"){
                if($user_id == $this->receiverId){
                    if($this->delete()){
                        $this->recountDialogMessages();
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                elseif($user_id == $this->sender_id){
                    return false;
                }
                else{
                    return false;
                }
            }
            elseif($deletedBy == "receiver"){
                if($user_id == $this->sender_id){
                    if($this->delete()){
                        $this->recountDialogMessages();
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                elseif($user_id == $this->receiverId){
                    return false;
                }
                else{
                    return false;
                }
            }
        }
    }

    public function getFormattedCreatedAt(){
        if(is_null($this->formattedCreatedAt)){
            $this->formattedCreatedAt = date("d.m.Y G:i", $this->created_at);
        }
        return $this->formattedCreatedAt;
    }

    public static function sendMessage($sender_id, $receiver_id, $body){
        if($sender_id == $receiver_id){
            return false;
        }
        $sender_id = (int)$sender_id;
        $receiver_id = (int)$receiver_id;
        $criteria = new CDbCriteria();
        $criteria->condition = '(receiver_id=:receiver_id AND sender_id=:sender_id) OR (receiver_id=:sender_id AND sender_id=:receiver_id)';
        $criteria->params = array(
            ':receiver_id' => (int)$receiver_id,
            ':sender_id' => (int)$sender_id
        );
        $dialog = Dialogues::model()->find($criteria);
        if(is_null($dialog)){
            $dialog = new Dialogues();
            $dialog->sender_id = (int)$sender_id;
            $dialog->receiver_id = (int)$receiver_id;
        }

        if($dialog->save()){
            $message = new UserMessages();
            $message->created_at = time();
            $message->body = $body;
            $message->sender_id = (int)$sender_id;
            $message->dialog_id = $dialog->id;
            if($message->save()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}
