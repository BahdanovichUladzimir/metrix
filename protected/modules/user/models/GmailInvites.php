<?php

/**
 * This is the model class for table "GmailInvites".
 *
 * The followings are the available columns in table 'GmailInvites':
 * @property string $id
 * @property integer $user_id
 * @property string $invite_email
 *
 * The followings are the available model relations:
 * @property User $user
 */
class GmailInvites extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'GmailInvites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('invite_email', 'length', 'max'=>255),
			array('invite_email', 'uniqueUserIdAndInviteEmail'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, invite_email', 'safe', 'on'=>'search'),
		);
	}

    public function uniqueUserIdAndInviteEmail($attribute,$params = array()){
        if(!$this->hasErrors())
        {
            $criteria = new CDbCriteria();
            $criteria->condition = 'user_id=:user_id AND invite_email=:invite_email';
            $criteria->params = array(
                ':user_id'=>$this->user_id,
                ':invite_email'=> $this->invite_email
            );
            $model = self::model()->find($criteria);
            if(!is_null($model)){
                $this->addError('invite_email',Yii::t('userModule','You have invited this friend'));
                //$this->addError('id',Yii::t('userModule','You have invited this friend'));
                return false;
            }
            else{
                return true;
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('core','ID'),
			'user_id' => Yii::t('core','User ID'),
			'invite_email' => Yii::t('core','Invite email'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('invite_email',$this->invite_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GmailInvites the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function afterSave(){
		$message = "Уважаемый ".$this->invite_email.",
		Ваш друг ".$this->user->username." приглашает Вас зарегистрироваться на информационном портале, посвященном организации праздников и досуга \"All For Holidays\".
		 Сайт all4holidays.com предоставляет возможность размещения объявлений об оказании услуг и продаже товаров,
		 которые необходимы для качественного проведения свадеб, вечеринок, детских праздников и других мероприятий.";
        $messagesModel = new EmailMessages();
        $messagesModel->from = Yii::app()->params['adminEmail'];
        $messagesModel->to = $this->invite_email;
        $messagesModel->subject = 'Subject';
        $messagesModel->message = $message;
        $messagesModel->type_id = 1;
        $messagesModel->is_sent = 0;
        $messagesModel->created_date = time();
        if($messagesModel->save()){
            return parent::afterSave();
        }
        else{
            return false;
        }
    }
}
