<?php

/**
 * This is the model class for table "FeedbackQuestions".
 *
 * The followings are the available columns in table 'FeedbackQuestions':
 * @property string $id
 * @property string $title
 * @property string $status_id
 * @property string $question
 * @property string $reply
 * @property string $created_date
 * @property string $category_id
 *
 * The followings are the available model relations:
 * @property FeedbackQuestionsStatuses $status
 * @property FeedbackCategories $category
 */
class FeedbackQuestions extends CActiveRecord
{

    public $formattedCreatedDate;


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'FeedbackQuestions';
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
			array('title, question, reply, category_id, status_id', 'required'),
			array('title', 'length', 'max'=>255),
			array('status_id, category_id', 'length', 'max'=>11),
			array('created_date', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, status_id, question, reply, created_date, category_id', 'safe', 'on'=>'search'),
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
			'status' => array(self::BELONGS_TO, 'FeedbackQuestionsStatuses', 'status_id'),
			'category' => array(self::BELONGS_TO, 'FeedbackCategories', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('feedbackModule','Question ID'),
			'title' => Yii::t('feedbackModule','Question title'),
			'status_id' => Yii::t('feedbackModule','Status'),
			'question' => Yii::t('feedbackModule','Question text'),
			'reply' => Yii::t('feedbackModule','Reply text'),
			'created_date' => Yii::t('feedbackModule','Created date'),
			'category_id' => Yii::t('feedbackModule','Category'),
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
		$criteria->compare('status_id',$this->status_id,true);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('reply',$this->reply,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('category_id',$this->category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FeedbackQuestions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
