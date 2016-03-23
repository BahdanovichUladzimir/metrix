<?php

/**
 * This is the model class for table "UsersRatingsValues".
 *
 * The followings are the available columns in table 'UsersRatingsValues':
 * @property string $id
 * @property integer $user_id
 * @property string $deal_id
 * @property string $rating_id
 * @property integer $value
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Deals $deal
 * @property Ratings $rating
 * @property Users $user
 */
class UsersRatingsValues extends CActiveRecord
{

    public $ratingsTotal = 0;
    public $ratingsCount = 0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'UsersRatingsValues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, value', 'numerical', 'integerOnly'=>true),
			array('user_id, deal_id, rating_id, value', 'required'),
			array('deal_id, rating_id', 'length', 'max'=>10),
			//array('user_id', 'uniqueDealIdRatingIdUserId'),
			array('note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, deal_id, rating_id, value, note', 'safe', 'on'=>'search'),
		);
	}

    public function uniqueDealIdRatingIdUserId($attribute,$params){
        if(!$this->hasErrors())  // we only want to authenticate when no input errors
        {
            $criteria = new CDbCriteria();
            $criteria->condition = 'user_id=:user_id AND deal_id=:deal_id AND rating_id=:rating_id';
            $criteria->params = array(
                ':user_id' => $this->user_id,
                ':deal_id' => $this->deal_id,
                ':rating_id' => $this->rating_id,
            );
            $model = self::model()->find($criteria);
            if(!is_null($model)){
                $this->addError('user_id',Yii::t('dealsModule','Such a record already exists.'));
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
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
			'rating' => array(self::BELONGS_TO, 'Ratings', 'rating_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
			'deal_id' => Yii::t('core','Deal ID'),
			'rating_id' => Yii::t('core','Rating ID'),
			'value' => Yii::t('core','Value'),
			'note' => Yii::t('core','Note'),
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
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('rating_id',$this->rating_id,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersRatingsValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
