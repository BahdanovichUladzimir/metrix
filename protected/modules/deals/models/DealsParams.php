<?php

/**
 * This is the model class for table "DealsParams".
 *
 * The followings are the available columns in table 'DealsParams':
 * @property string $id
 * @property string $type_id
 * @property string $field_size
 * @property string $field_size_min
 * @property string $required
 * @property string $match
 * @property string $range
 * @property string $error_message
 * @property string $other_validator
 * @property string $default
 * @property integer $position
 * @property integer $visible
 * @property string $widget
 * @property string $widget_params
 * @property string $name
 * @property string $label
 * @property string|int $filter
 * @property int $list_id
 *
 * The followings are the available model relations:
 * @property DealsCategoriesParams[] $dealsCategoriesParams
 * @property DealsParamsTypes $type
 * @property Lists $list
 * @property DealsParamsValues[] $dealsParamsValues
 */
class DealsParams extends CActiveRecord
{

	public static $requiredListData = array(
		0 => "Not required",
		1 => "Required",
	);

	public static $visibleListData = array(
		0 => "Not visible",
		1 => "Visible",
	);

	public static $typesListData = NULL;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsParams';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, label, type_id, field_size, field_size_min, required', 'required'),
			array('name', 'forbiddenNamesVerification'),
			array('position, visible, field_size, field_size_min', 'numerical', 'integerOnly'=>true),
			array('list_id', 'numerical', 'allowEmpty'=>true, 'integerOnly'=>true),
			array('list_id', 'requiredListId'),
			array('type_id', 'length', 'max'=>11),
			array('field_size, field_size_min', 'length', 'max'=>3),
			array('filter', 'length', 'max'=>1),
			array('required', 'length', 'max'=>1),
			array('match, range, error_message, default, widget', 'length', 'max'=>255),
			array('name, label', 'length', 'max'=>50),
			array('other_validator, widget_params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, type_id, field_size, field_size_min, required, match, range, error_message, other_validator, default, position, visible, widget, widget_params, name, label, filter', 'safe', 'on'=>'search'),
		);
	}

	public function requiredListId($attribute,$params=array()){
        if (!$this->hasErrors()){
            if($this->type->name == 'list'){
                $validator = CValidator::createValidator('required', $this, $attribute, $params);
                $validator->validate($this, array($attribute));
            }
        }
	}

	public function forbiddenNamesVerification(){
		if (!$this->hasErrors()){
			if($this->name == 'calendarTime' || $this->name == 'calendarDate'){
				$this->addError('name',Yii::t('dealsModule',"It is forbidden to create a parameter with the same name."));
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
			'dealsCategoriesParams' => array(self::HAS_MANY, 'DealsCategoriesParams', 'deal_param_id'),
			'type' => array(self::BELONGS_TO, 'DealsParamsTypes', 'type_id'),
			'list' => array(self::BELONGS_TO, 'Lists', 'list_id'),
			'dealsParamsValues' => array(self::HAS_MANY, 'DealsParamsValues', 'param_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dealsModule','Param ID'),
			'type_id' => Yii::t('dealsModule','Type'),
			'list_id' => Yii::t('dealsModule','List'),
			'field_size' => Yii::t('dealsModule','Field size'),
			'field_size_min' => Yii::t('dealsModule','Min field size'),
			'required' => Yii::t('dealsModule','Required'),
			'match' => Yii::t('dealsModule','Match'),
			'range' => Yii::t('dealsModule','Range'),
			'error_message' => Yii::t('dealsModule','Error message'),
			'other_validator' => Yii::t('dealsModule','Other validator'),
			'default' => Yii::t('dealsModule','Default'),
			'position' => Yii::t('dealsModule','Position'),
			'visible' => Yii::t('dealsModule','Visible'),
			'widget' => Yii::t('dealsModule','Widget'),
			'widget_params' => Yii::t('dealsModule','Widget params'),
			'name' => Yii::t('dealsModule','Param name'),
			'label' => Yii::t('dealsModule','Label'),
			'filter' => Yii::t('dealsModule','Filter'),
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
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('field_size',$this->field_size,true);
		$criteria->compare('field_size_min',$this->field_size_min,true);
		$criteria->compare('required',$this->required,true);
		$criteria->compare('match',$this->match,true);
		$criteria->compare('range',$this->range,true);
		$criteria->compare('error_message',$this->error_message,true);
		$criteria->compare('other_validator',$this->other_validator,true);
		$criteria->compare('default',$this->default,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('widget',$this->widget,true);
		$criteria->compare('widget_params',$this->widget_params,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('filter',$this->filter,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsParams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array|null
	 */
	public static function getTypesListData(){
		if(is_null(self::$typesListData)){
			self::$typesListData = CHtml::listData(DealsParamsTypes::model()->findAll(array('order'=>'label ASC')),'id','label');
		}
		return self::$typesListData;
	}

	/**
	 * @return array
	 */
	public static function getRequiredListData(){
		return self::$requiredListData;
	}

	/**
	 * @return array
	 */
	public static function getVisibleListData(){
		return self::$visibleListData;
	}

    public function getListListData(){
        if($this->type->name == 'list'){
            if(!is_null($this->list_id)){
                return CHtml::listData(ListItems::model()->findAll(':list_id=list_id',array(':list_id' => $this->list_id)),'value','name');
            }
            elseif(strlen($this->range)>0){
                return DealCategoriesParams::range($this->range);
            }
            else{
                return array(0=>'List items not found');
            }
        }
        else{
            return false;
        }
    }

	public function beforeSave(){
		if(strlen($this->name)>0){
			$this->name = strtolower(str_replace(' ', '_', trim($this->name)));
		}
		return parent::beforeSave();
	}
}
