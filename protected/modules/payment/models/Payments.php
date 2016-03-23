<?php

/**
 * This is the model class for table "Payments".
 *
 * The followings are the available columns in table 'Payments':
 * @property string $id
 * @property string $type_id
 * @property string $app_category_id
 * @property string $app_item_id
 * @property integer $user_id
 * @property string $time
 * @property double $amount
 * @property double $real_amount
 *
 * The followings are the available model relations:
 * @property PaymentsTypes $type
 * @property AppCategories $appCategory
 * @property User $user
 */
class Payments extends CActiveRecord
{
    public $description = NULL;
    public $typeType;
    public $formattedDate = NULL;
    public $formattedTime = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Payments';
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
			array('amount, real_amount', 'numerical'),
			array('type_id, app_category_id', 'length', 'max'=>3),
			array('app_item_id, time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type_id, app_category_id, app_item_id, user_id, time, amount, real_amount, typeType', 'safe', 'on'=>'search'),
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
			'type' => array(self::BELONGS_TO, 'PaymentsTypes', 'type_id'),
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
			'id' => Yii::t('paymentModule','Payment ID'),
			'type_id' => Yii::t('paymentModule','Payment type'),
			'typeType' => Yii::t('paymentModule','Payment type type'),
			'app_category_id' => Yii::t('paymentModule','Application category'),
			'app_item_id' => Yii::t('paymentModule','Application category item ID'),
			'user_id' => Yii::t('paymentModule','User'),
			'time' => Yii::t('paymentModule','Date'),
			'amount' => Yii::t('paymentModule','Amount'),
			'real_amount' => Yii::t('paymentModule','Real amount'),
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
        $criteria->with = array(
            'type',
        );
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.type_id',$this->type_id,true);
		$criteria->compare('t.app_category_id',$this->app_category_id,true);
		$criteria->compare('t.app_item_id',$this->app_item_id,true);
        $criteria->compare('t.user_id',Yii::app()->user->getId());
		$criteria->compare('t.time',$this->time,true);
		$criteria->compare('t.amount',$this->amount);
		$criteria->compare('t.real_amount',$this->real_amount);
        if($this->typeType){
            $criteria->compare('type.type',$this->typeType,true);
        }

        return new KeenActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'withKeenLoading' => array('type'),
            'pagination'=>array(
                'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
	}
	public function adminSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with = array(
            'type',
        );
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.type_id',$this->type_id,true);
		$criteria->compare('t.app_category_id',$this->app_category_id,true);
		$criteria->compare('t.app_item_id',$this->app_item_id,true);
        $criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.time',$this->time,true);
		$criteria->compare('t.amount',$this->amount);
		$criteria->compare('t.real_amount',$this->real_amount);
        if($this->typeType){
            $criteria->compare('type.type',$this->typeType,true);
        }

        return new KeenActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'withKeenLoading' => array('type'),
            'pagination'=>array(
                'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
	}

    public function incomingSearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with = array(
            'type',
        );
        $criteria->order = 't.time DESC';
        //$criteria->compare('t.id',$this->id,true);
        //$criteria->compare('t.type_id',$this->type_id,true);
        //$criteria->compare('t.app_category_id',$this->app_category_id,true);
        //$criteria->compare('t.app_item_id',$this->app_item_id,true);
        $criteria->compare('t.user_id',Yii::app()->user->getId());
        //$criteria->compare('t.time',$this->time,true);
        //$criteria->compare('t.amount',$this->amount);
        //$criteria->compare('t.real_amount',$this->real_amount);
        $criteria->compare('type.type','incoming');


        return new KeenActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'withKeenLoading' => array('type'),
            'pagination'=>array(
                'pageSize'=>20, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
    }

    public function outgoingSearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with = array(
            'type',
        );
        $criteria->order = 't.time DESC';
        //$criteria->compare('t.id',$this->id,true);
        //$criteria->compare('t.type_id',$this->type_id,true);
        //$criteria->compare('t.app_category_id',$this->app_category_id,true);
        //$criteria->compare('t.app_item_id',$this->app_item_id,true);
        $criteria->compare('t.user_id',Yii::app()->user->getId());
        //$criteria->compare('t.time',$this->time,true);
        //$criteria->compare('t.amount',$this->amount);
        //$criteria->compare('t.real_amount',$this->real_amount);
        $criteria->compare('type.type','outgoing');

        return new KeenActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'withKeenLoading' => array('type'),
            'pagination'=>array(
                'pageSize'=>20, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
    }


    public function getDescription(){
        if(is_null($this->description)){
            if($this->type_id == 1){
                $this->description = Yii::t("paymentModule","Write-off of advertising");
            }
            elseif($this->type_id == 5){
                $this->description = Yii::t("paymentModule","Recharge with webmoney");
            }
            else{
                $this->description = "";
            }
        }
        return $this->description;
    }

    public function getFormattedDate(){
        if(is_null($this->formattedDate)){
            $this->formattedDate = date("d.m.Y", $this->time);
        }
        return $this->formattedDate;
    }
    public function getFormattedTime(){
        if(is_null($this->formattedTime)){
            $this->formattedTime = date("H:i", $this->time);
        }
        return $this->formattedTime;
    }

    public function beforeSave(){
        if($this->isNewRecord){
            if($this->type->type === 'incoming'){
                $this->user->ballance = (int)$this->user->ballance+$this->amount;
                if($this->user->save()){
                    return parent::beforeSave();
                }
                else{
                    return false;
                }
            }
            elseif($this->type->type === 'outgoing'){
                $this->user->ballance = (int)$this->user->ballance-$this->amount;
                if($this->user->save()){
                    return parent::beforeSave();
                }
                else{
                    return false;
                }
            }
            else{
                return parent::beforeSave();
            }
        }
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Payments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
