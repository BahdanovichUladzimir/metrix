<?php

/**
 * This is the model class for table "Dictionary".
 *
 * The followings are the available columns in table 'Dictionary':
 * @property string $id
 * @property string $name
 * @property string $letter
 * @property string $description
 *
 * The followings are the available model relations:
 * @property CmsPagesDictionary[] $cmsPagesDictionaries
 * @property CmsPages[] $cmsPage
 */
class Dictionary extends CActiveRecord
{

    public static $rusAlphabet = array(
        'А',
        'Б',
        'В',
        'Г',
        'Д',
        'Е',
        'Ё',
        'Ж',
        'З',
        'И',
        'Й',
        'К',
        'Л',
        'М',
        'Н',
        'О',
        'П',
        'Р',
        'С',
        'Т',
        'У',
        'Ф',
        'Х',
        'Ц',
        'Ч',
        'Ш',
        'Щ',
        'Ъ',
        'Ы',
        'Ь',
        'Э',
        'Ю',
        'Я'
    );

    public static $enAlphabet = array(
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'Q',
        'R',
        'S',
        'T',
        'U',
        'V',
        'W',
        'X',
        'Y',
        'Z',
    );

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Dictionary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, letter', 'required'),
			array('name', 'length', 'max'=>255),
			array('description', 'length', 'max'=>3000),
			array('letter', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, letter, description', 'safe', 'on'=>'search'),
			array('cmsPagesDictionaries', 'safe'),
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
			'cmsPagesDictionaries' => array(self::HAS_MANY, 'CmsPagesDictionary', 'dictionary_id'),
            'cmsPage'=>array(self::MANY_MANY, 'CmsPage', 'CmsPagesDictionary(page_id, dictionary_id)'),

        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t("cmsModule",'ID'),
			'name' => Yii::t("cmsModule",'Name'),
			'letter' => Yii::t("cmsModule",'Letter'),
			'description' => Yii::t("cmsModule",'Description'),
            'cmsPagesDictionaries' => Yii::t("cmsModule",'Pages')
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('letter',$this->letter,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave(){
		if(isset($this->letter) && !is_null($this->letter)){
			$this->letter = strtoupper($this->letter);
		}
		return parent::beforeSave();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dictionary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
