<?php

/**
 * This is the model class for table "Deals".
 *
 * The followings are the available columns in table 'Deals':
 * @property string $id
 * @property string $name
 * @property string $url_segment
 * @property string $intro
 * @property integer $approve
 * @property integer $archive
 * @property integer $negotiable
 * @property string $description
 * @property integer $user_id
 * @property integer $city_id
 * @property integer $currency_id
 * @property string $status_id
 * @property string|int $created_date
 * @property string|int $updated_date
 * @property string|int $published_date
 * @property integer $priority
 * @property integer $paid
 * @property integer $exceeding_limit_paid
 * @property integer $minPrice
 * @property integer $contacts_shows
 * @property bool $forAdults
 * @property integer $exceeding_category_limit_hidden
 * @property array $contactsQualitiesCounts
 *
 * The followings are the available model relations:
 * @property DealsStatuses $status
 * @property User $user
 * @property $city Cities
 * @property $currency Currencies
 * @property DealsImages[] $dealsImages
 * @property DealsImages[] $frontendDealsImages
 * @property DealsParamsValues[] $dealsParamsValues
 * @property DealsVideos[] $dealsVideos
 * @property DealsVideos[] $frontendDealsVideos
 * @property DealsDealsCategories[] $dealsDealsCategories
 * @property CookiesFavorites[] $cookiesFavorites
 * @property UsersFavorites[] $usersFavorites
 * @property DealsStatistics[] $dealsStatistics
 * @property DealLinks[] $dealLinks
 * @property DealLinks[] $frontendDealLinks
 * @property DealsStatistics $dealsCurrentStatistics
 * @property DealsCategories[] $categories
 * @property DealsContactsQuality[] contactsQuality
 * @property array $params
 */
class Deals extends CActiveRecord
{
	public $categoriesSearch = NULL;
    public $formattedPublishedDate;
    public $formattedCreatedDate;
    public $minPrice = NULL;
    public $ids = NULL;
    public $categoriesTree = NULL;

	private $_url = NULL;
	private $_publicUrl = NULL;
	private $_userUrl = NULL;

    public static $paramsFilters = array();
    public static $allParams = array();
    public $filter;

    public $metaKeywords = NUll;
    public $metaTitle = NUll;
    public $metaDescription = NULL;
    public $seoH1 = NULL;
    public $seoText = NULL;
    public $randSort = NULL;
    public $publicDescription;
    public $isShowCalendar = false;
    public $isShowPublicCalendar = false;
    /**
     * @var string
     */
    public $sphinxQuery;

    public $isShowPublicMap = true;
    /**
     * @var bool
     */
    public $forAdults = false;

    public $contactsQualitiesCounts = array();

    /**
     * @var null|int
     */
    public static $userCurrencyId = NULL;
    public static $userCityId = NULL;
    public static $paidStatuses = array();
    public static $dealsContactsQualities = array();
    public static $calendarParamId = 179;

    public function init(){
        parent::init();
        self::$allParams = DealsParams::model()->findAll('filter=:filter AND visible=:visible',array(':filter'=>1,':visible'=>1));
        if(sizeof(self::$allParams)>0){
            foreach (self::$allParams as $param){
                self::$paramsFilters[] = $param->name;
            }
        }
        self::$paidStatuses = array(
            0 => Yii::t('dealsModule', 'Unpaid'),
            1 => Yii::t('dealsModule', 'Paid'),
        );
        self::setDealsContactsQualities();
        self::$calendarParamId = DealsParams::model()->findByAttributes(array('name' => 'calendar'))->id;

    }

    public static function getDealsContactsQualities(){
        self::setDealsContactsQualities();
        return self::$dealsContactsQualities;
    }

    public static function setDealsContactsQualities(){
        self::$dealsContactsQualities = array(
            1 => Yii::t('dealsModule', 'The phone works'),
            2 => Yii::t('dealsModule', 'The phone doesn\'t respond'),
            3 => Yii::t('dealsModule', 'The phone is not available'),
            4 => Yii::t('dealsModule', 'Wrong number'),
        );
    }

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Deals';
	}
	public function behaviors(){
		return array(
			'ESaveRelatedBehavior' => array(
				'class' => 'application.components.ESaveRelatedBehavior'
			),
			'SetPublishedDateBehavior' => array(
				'class' => 'application.components.SetPublishedDateBehavior',
                'formattedPublishedDateAttribute' => 'formattedPublishedDate',
			),
            'SaveCreatedDateBehavior' => array(
                'class'=>'application.components.SaveCreatedDateBehavior',
                'createdDateAttribute' => 'created_date',
                'formattedCreatedDateAttribute' => 'formattedCreatedDate'
            ),
            'CyrillicUrlTranslateBehavior' => array(
                'class'=>'application.components.CyrillicUrlTranslateBehavior',
                'inputAttributeName' => 'name',
                'outputAttributeName' => 'url_segment'
            ),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
        $descrptionPurifier = new CHtmlPurifier();
        $descrptionPurifier->options = array(
            'HTML.AllowedElements' => Yii::app()->config->get('DEALS_MODULE.DESCRIPTION_ALLOWED_TAGS'),
            'HTML.AllowedAttributes' => '*.class'
        );
        $introPurifier = new CHtmlPurifier();
        $introPurifier->options = array(
            'HTML.AllowedElements' => Yii::app()->config->get('DEALS_MODULE.INTRO_ALLOWED_TAGS'),
            'HTML.AllowedAttributes' => '*.class'

        );

		return array(
			array('name, url_segment, intro', 'required'),
			array('categories', 'required', 'message' => Yii::t('dealsModule','You must select category.')),
			array('city_id', 'required', 'message' => Yii::t('dealsModule','You must select city.')),
			array('user_id', 'required', 'on' => 'adminUpdate, adminCreate, userCreate'),
			array('currency_id, city_id, user_id, approve, archive, priority, paid, exceeding_limit_paid, exceeding_category_limit_hidden', 'numerical', 'integerOnly'=>true),
			array('name, url_segment, randSort', 'length', 'max'=>255),
			array('description', 'length', 'max'=>50000),
			array('status_id', 'length', 'max'=>3),
			array('exceeding_category_limit_hidden', 'length', 'max'=>2),
			array('approve, archive, negotiable, priority, paid, exceeding_limit_paid', 'length', 'max'=>1),
			array('created_date, published_date, updated_date', 'length', 'max'=>12),
			array('intro', 'length', 'max'=>200),
            array('description','filter','filter'=>array($obj=$descrptionPurifier,'purify')),
            array('intro','filter','filter'=>array($obj=$introPurifier,'purify')),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, intro, approve, archive, description, user_id, city_id, currency_id, status_id, created_date, updated_date, published_date, priority, paid, exceeding_limit_paid, categoriesSearch', 'safe', 'on'=>'search'),
			array('name, approve, archive, status_id, created_date, published_date, priority, paid, exceeding_limit_paid, categoriesSearch', 'safe', 'on'=>'userSearch'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'status' => array(self::BELONGS_TO, 'DealsStatuses', 'status_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'dealsImages' => array(
                self::HAS_MANY,
                'DealsImages',
                'deal_id',
                'order' => 'preview DESC'
            ),
			'frontendDealsImages' => array(
                self::HAS_MANY,
                'DealsImages',
                'deal_id',
                'condition' => '`frontendDealsImages`.`approve`=:images_approve',
                'params' => array(
                    ':images_approve' => 1
                ),
                'order' => 'preview DESC'
            ),
			'dealsParamsValues' => array(
                self::HAS_MANY,
                'DealsParamsValues',
                'deal_id',
                'with' => array(
                    'param' => array(
                        'order' => 'param.type_id'
                    )
                ),
            ),
			'dealsVideos' => array(self::HAS_MANY, 'DealsVideos', 'deal_id'),
			'frontendDealsVideos' => array(
                self::HAS_MANY,
                'DealsVideos',
                'deal_id',
                'condition' => 'frontendDealsVideos.approve=:videos_approve',
                'params' => array(
                    ':videos_approve' => 1
                )
            ),
			'dealsDealsCategories' => array(self::HAS_MANY, 'DealsDealsCategories', 'deal_id'),
			'categories' => array(self::MANY_MANY,  'DealsCategories', 'Deals_DealsCategories(deal_id, category_id)'),
			'params' => array(self::MANY_MANY,  'DealsParams', 'DealsParamsValues(deal_id, param_id)'),
            'cookiesFavorites' => array(self::HAS_MANY, 'CookiesFavorites', 'deal_id'),
            'usersFavorites' => array(self::HAS_MANY, 'UsersFavorites', 'deal_id'),
            'dealsStatistics' => array(self::HAS_MANY, 'DealsStatistics', 'deal_id'),
            'dealLinks' => array(self::HAS_MANY, 'DealLinks', 'deal_id'),
            'frontendDealLinks' => array(
                self::HAS_MANY,
                'DealLinks',
                'deal_id',
                'condition' => 'frontendDealLinks.approve=:links_approve',
                'params' => array(
                    ':links_approve' => 1
                )
            ),
            'dealsCurrentStatistics' => array(
                self::HAS_ONE,
                'DealsStatistics',
                'deal_id',
                'condition' => 'date=:date',
                'params' => array(
                    ':date' => date('Y-m-d')
                )
            ),
            'session' => array(self::MANY_MANY,  'Session', 'SessionFavorites(deal_id, session_id)'),
            'users' => array(self::MANY_MANY,  'User', 'UsersFavorites(deal_id, user_id)'),
            'calendar' =>  array(self::HAS_MANY, 'Calendar', 'deal_id'),
            'contactsQuality' =>  array(self::HAS_MANY, 'DealsContactsQuality', 'deal_id'),
        );
        return $relations;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dealsModule','ID'),
			'name' => Yii::t('dealsModule','Deal name'),
			'url_segment' => Yii::t('dealsModule','URL segment'),
			'intro' => Yii::t('dealsModule','Deal intro'),
			'approve' => Yii::t('dealsModule','Approve'),
			'archive' => Yii::t('dealsModule','Archive'),
			'negotiable' => Yii::t('dealsModule','Negotiable'),
			'description' => Yii::t('dealsModule','Deal description'),
			'user_id' => Yii::t('dealsModule','User'),
			'city_id' => Yii::t('dealsModule','City'),
			'status_id' => Yii::t('dealsModule','Status'),
			'currency_id' => Yii::t('dealsModule','Currency'),
			'created_date' => Yii::t('dealsModule','Created date'),
			'updated_date' => Yii::t('dealsModule','Updated date'),
			'published_date' => Yii::t('dealsModule','Published date'),
			'priority' => Yii::t('dealsModule','Priority'),
			'categories' => Yii::t('dealsModule','Categories'),
			'exceeding_limit_paid' => Yii::t('dealsModule','Exceeding limit paid'),
			'paid' => Yii::t('dealsModule','Paid'),
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

    public function scopes()
    {
        return array(
            'published'=>array(
                'condition'=>'t.approve = 1 AND t.archive = 0 AND t.status_id = 1',
            ),
        );
    }


    public function adminSearch()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with = array(
            'categories',
            'dealsParamsValues'
        );
        $criteria->together=true;
        $criteria->order='t.approve ASC, t.created_date DESC';

        //$criteria->addNotInCondition('t.user_id',explode(',',Yii::app()->config->get("DEALS_MODULE.HIDDEN_USERS")));
        $criteria->group=('t.id');
        $criteria->compare('t.id',$this->id,true);
        $criteria->compare('t.name',$this->name,true);
        $criteria->compare('t.url_segment',$this->url_segment,true);
        //$criteria->compare('t.intro',$this->intro,true);
        $criteria->compare('t.approve',$this->approve);
        $criteria->compare('t.archive',$this->archive);
        //$criteria->compare('t.negotiable',$this->negotiable);
        //$criteria->compare('t.description',$this->description,true);
        $criteria->compare('t.user_id',$this->user_id);
        $criteria->compare('t.city_id',$this->city_id);
        $criteria->compare('t.status_id',$this->status_id,true);
        //$criteria->compare('t.currency_id',$this->currency_id,true);
        //$criteria->compare('t.updated_date',$this->updated_date,true);
        //$criteria->compare('t.created_date',$this->created_date,true);
        //$criteria->compare('t.published_date',$this->published_date,true);
        $criteria->compare('t.priority',$this->priority);
        $criteria->compare('t.paid',$this->paid);
        if(!is_null($this->categoriesSearch)){
            $criteria->compare('categories.id',$this->categoriesSearch,true);
        }
        /*if(!is_null($this->city)){
            $cityObj = Cities::model()->findByAttributes(array('key'=>$this->city));
            $criteria->addCondition("t.city_id=:city_id");
            $criteria->params[':city_id'] = (int)$cityObj->id;
        }*/
        if(!is_null($this->filter) && is_array($this->filter) && sizeof($this->filter)>0){
            foreach($this->filter as $param=>$value){
                if(in_array($param,self::$paramsFilters)){
                    if(is_array($value)){
                        $paramModel = DealsParams::model()->find('name=:name',array(':name' => $param));
                        $criteria->addCondition('dealsParamsValues.id=:param_id');
                        if(isset($value['min']) || isset($value['max'])){
                            $criteria->addBetweenCondition('dealsParamsValues.value', $value['min'], $value['max']);
                        }
                        else{
                            $criteria->addInCondition('dealsParamsValues.value',$value,'OR');
                        }
                        $criteria->params[":param_id"] = $paramModel->id;
                    }
                    else{
                        $paramModel = DealsParams::model()->find('name=:name',array(':name' => $param));
                        $criteria->addCondition('dealsParamsValues.id=:param_id AND dealsParamsValues.value=:value');
                        $criteria->params[":param_id"] = $paramModel->id;
                        $criteria->params[":value"] = $value;
                    }

                }
            }
        }
        if(!is_null($this->ids)){
            $criteria->addInCondition('t.id',$this->ids);
        }
        return new KeenActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'withKeenLoading' => array('categories'),
            'pagination'=>array(
                'pageSize'=>20, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
    }


	public function search($pageSize = 20)
	{
		$criteria=new CDbCriteria;
		$criteria->with = array(
			'categories',
            //'dealsParamsValues',
            'calendar'
		);
		$criteria->together=true;
        $criteria->condition ='t.status_id=:status_id AND t.approve=:approve AND t.`archive`=:archive AND t.`exceeding_category_limit_hidden`=:exceeding_category_limit_hidden';
        $criteria->params = array(
            ':status_id' => '1',
            ':approve' => '1',
            ':archive' => '0',
            ':exceeding_category_limit_hidden' => '0',
        );
        if(is_null($this->randSort)){
            $criteria->order = 't.priority DESC';
        }
        else{
            $criteria->order = 't.priority DESC, rand('.$this->randSort.') ASC';
        }
        $criteria->order = 't.priority DESC, rand('.$this->randSort.')';
		//$criteria->group=('t.id');
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.url_segment',$this->url_segment,true);
		$criteria->compare('t.user_id',$this->user_id);
        if(!is_null($this->categoriesSearch)){
            $criteria->compare('categories.id',$this->categoriesSearch,true);
        }
        if(!is_null($this->city)){
            $cityObj = Cities::model()->findByAttributes(array('key'=>$this->city));
            $criteria->addCondition("t.city_id=:city_id");
            $criteria->params[':city_id'] = (int)$cityObj->id;
        }
        if(!is_null($this->filter) && is_array($this->filter) && sizeof($this->filter)>0){
            foreach($this->filter as $param=>$value){
                if($param === "calendarDate" && strlen(trim($this->filter['calendarDate']))>0){
                    $dateTime = trim($value);
                    $unixDateTime = DateTime::createFromFormat('!d.m.Y', $dateTime)->format('U');

                    $sql = "SELECT DAYOFYEAR(FROM_UNIXTIME(".$unixDateTime.")) AS dayOfYear, YEAR(FROM_UNIXTIME(".$unixDateTime.")) AS year;";
                    $connection = Yii::app()->db;
                    $command = $connection->createCommand($sql);
                    $dataReader = $command->queryRow();

                    $condition = '
                        `t`.`id` NOT IN (SELECT `Calendar`.`deal_id` FROM `Calendar`
                        WHERE DAYOFYEAR(FROM_UNIXTIME(`Calendar`.`start`))<='.$dataReader["dayOfYear"].'
                        AND DAYOFYEAR(FROM_UNIXTIME(`Calendar`.`end`))>='.$dataReader["dayOfYear"].'
                        AND YEAR(FROM_UNIXTIME(`Calendar`.`start`))="'.$dataReader["year"].'"
                        AND YEAR(FROM_UNIXTIME(`Calendar`.`end`))="'.$dataReader["year"].'"
                        )
                    ';

                    if(array_key_exists("calendarTime", $this->filter) && strlen(trim($this->filter['calendarTime']))>0){
                        $dateTime = $dateTime." ".trim($this->filter['calendarTime']);
                        $unixDateTime = DateTime::createFromFormat('!d.m.Y H:i', $dateTime)->format('U');

                        $condition = '
                            `t`.`id` NOT IN (SELECT `Calendar`.`deal_id` FROM `Calendar`
                            WHERE `Calendar`.`start`<='.$unixDateTime.'
                            AND `Calendar`.`end`>='.$unixDateTime.')
                        ';
                    }
                    $criteria->addCondition($condition);
                }
                if(in_array($param,self::$paramsFilters)){
                    if(is_array($value)){
                        $paramModel = DealsParams::model()->find('name=:name',array(':name' => $param));
                        //Config::var_dump($paramModel->type->name);

                        //Config::var_dump(self::$userCurrencyId);


                        if(isset($value['min']) && isset($value['max'])){
                            if(is_numeric($value['min']) && is_numeric($value['max'])){
                                $condition = '
                                        `t`.`id` IN (SELECT `DealsParamsValues`.`deal_id` FROM `DealsParamsValues`
                                        WHERE `DealsParamsValues`.`param_id`='.$paramModel->id.'
                                        AND `DealsParamsValues`.`value`
                                        BETWEEN '.$value["min"].' AND '.$value["max"].')
                                    ';
                                if($paramModel->type->name === "price"){
                                    if(!is_null(self::$userCurrencyId)){
                                        // Получаем текущую валюту
                                        $userCurrency = Currencies::model()->findByPk(self::$userCurrencyId);
                                        if(!is_null($userCurrency)){
                                            $connection=Yii::app()->db; // так можно делать, если в конфигурации настроен компонент соединения "db"
                                            // Выбираем все id товаров с текущей валютой
                                            $cityCondition = is_null(self::$userCityId) ? '' : " AND `Deals`.`city_id`=".self::$userCityId." ";
                                            // @todo Добавить условие по категориям
                                            /*if(!is_null($this->categoriesSearch)){
                                                $categoriesJoin = '

                                                ';
                                                $categoriesCondition = '
                                                ';
                                            }
                                            else{
                                                $categoriesJoin = '';
                                                $categoriesCondition = '';
                                            }*/
                                            $sql = '
                                                SELECT `DealsParamsValues`.`deal_id`
                                                FROM `DealsParamsValues`
                                                LEFT JOIN `Deals` ON(`DealsParamsValues`.`deal_id`=`Deals`.`id`)
                                                WHERE `DealsParamsValues`.`param_id`='.$paramModel->id.'
                                                '.$cityCondition.'
                                                AND `Deals`.`currency_id`='.$userCurrency->id.'
                                                AND `DealsParamsValues`.`value`
                                                BETWEEN '.$value["min"].' AND '.$value["max"].'
                                            ';
                                            $command=$connection->createCommand($sql);
                                            /**
                                             * @var array Массив idшников товаров у которых валюта такая же как текущая
                                             */
                                            $ids = array(0);
                                            $ids=array_merge($ids,$command->queryColumn());

                                            // Берём оставшиеся валюты и получаем idшники товаров с условием курса валют
                                            foreach(Currencies::model()->findAll('id<>:id', array(':id' => $userCurrency->id)) as $currency){
                                                $sql = '
                                                    SELECT `DealsParamsValues`.`deal_id`
                                                    FROM `DealsParamsValues`
                                                    LEFT JOIN `Deals` ON(`DealsParamsValues`.`deal_id`=`Deals`.`id`)
                                                    WHERE `DealsParamsValues`.`param_id`='.$paramModel->id.'
                                                    '.$cityCondition.'
                                                    AND `Deals`.`currency_id`='.$currency->id.'
                                                    AND `Deals`.`city_id`
                                                    AND `DealsParamsValues`.`value`
                                                    BETWEEN '.$value["min"]/$currency->rate*$userCurrency->rate.' AND '.$value["max"]/$currency->rate*$userCurrency->rate.'
                                                ';
                                                $command=$connection->createCommand($sql);
                                                $tmpIds = $command->queryColumn();
                                                $ids=array_merge($ids,$tmpIds);

                                            }
                                            $condition = '
                                                `t`.`id` IN ('.implode(',',$ids).')
                                            ';
                                        }
                                    }
                                }
                                $criteria->addCondition($condition);
                            }
                            elseif(is_numeric($value['min'])){
                                $condition = '
                                    `t`.`id` IN (SELECT `DealsParamsValues`.`deal_id` FROM `DealsParamsValues`
                                    WHERE `DealsParamsValues`.`param_id`='.$paramModel->id.'
                                    AND `DealsParamsValues`.`value`>'.$value["min"].')
                                ';
                                $criteria->addCondition($condition);
                            }
                            elseif(is_numeric($value['max'])){
                                $condition = '
                                    `t`.`id` IN (SELECT `DealsParamsValues`.`deal_id` FROM `DealsParamsValues`
                                    WHERE `DealsParamsValues`.`param_id`='.$paramModel->id.'
                                    AND `DealsParamsValues`.`value`<'.$value["max"].')
                                ';
                                $criteria->addCondition($condition);
                            }

                        }
                        else{
                            $values = array();
                            foreach($value as $k=>$v){
                                if(strlen($v)>0){
                                    $values[] = "'".CHtml::encode($v)."'";
                                }
                                else{
                                    $values[] = '';
                                }
                            }
                            $values = implode(', ',$values);
                            if(strlen(trim($values)) > 0){
                                $condition = '
                                    `t`.`id` IN (SELECT `DealsParamsValues`.`deal_id` FROM `DealsParamsValues`
                                    WHERE `DealsParamsValues`.`param_id`='.$paramModel->id.'
                                    AND `DealsParamsValues`.`value` IN ('.$values.'))
                                ';
                                $criteria->addCondition($condition);
                            }
                        }
                    }
                    else{
                        $paramModel = DealsParams::model()->find('name=:name',array(':name' => $param));
                        $criteria->addCondition('dealsParamsValues.id=:param_id AND dealsParamsValues.value=:value');
                        $criteria->params[":param_id"] = $paramModel->id;
                        $criteria->params[":value"] = $value;
                    }

                }
            }
        }
        if(!is_null($this->ids)){
            $criteria->addInCondition('t.id',$this->ids);
        }
		return new KeenActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'withKeenLoading' => array('categories'),
			'pagination'=>array(
				'pageSize'=>$pageSize, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
		));
	}

	public function userSearch($userId = NULL)
	{
        if(is_null($userId)){
            return false;
        }

		$criteria=new CDbCriteria;
        $criteria->condition = ":user_id=t.user_id";
        $criteria->params = array(
            'user_id' => (int)$userId,
        );
		$criteria->with = array(
			'categories',
		);
		$criteria->together=true;
		$criteria->group=('t.id');
		$criteria->compare('t.id',$this->id,true);
		$criteria->compare('t.name',$this->name,true);
		//$criteria->compare('t.url_segment',$this->url_segment,true);
		//$criteria->compare('t.intro',$this->intro,true);
		$criteria->compare('t.approve',$this->approve);
		$criteria->compare('t.archive',$this->archive);
		//$criteria->compare('t.negotiable',$this->negotiable);
		//$criteria->compare('t.description',$this->description,true);
		//$criteria->compare('t.user_id',$this->user_id);
		//$criteria->compare('t.city_id',$this->city_id);
		$criteria->compare('t.status_id',$this->status_id,true);
		//$criteria->compare('t.currency_id',$this->currency_id,true);
		//$criteria->compare('t.created_date',$this->created_date,true);
		//$criteria->compare('t.updated_date',$this->updated_date,true);
		//$criteria->compare('t.published_date',$this->published_date,true);
		$criteria->compare('t.priority',$this->priority);

		if($this->categoriesSearch){
			$criteria->compare('categories.id',$this->categoriesSearch,true);
		}
        $dependency = new CDbCacheDependency('SELECT MAX(`created_date`) FROM Deals');
		return new EActiveDataProviderEx($this, array(
			'criteria'=>$criteria,
			'withKeenLoading' => array('categories'),
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
            'cache' => array(60*60*24, $dependency)
		));
	}

    public function getCategoryDeals($categoryId, $city){
        $criteria = new CDbCriteria();
        $criteria->condition ='t.status_id=:status_id AND t.approve=:approve AND t.archive=:archive';
        $criteria->params = array(
            ':status_id' => 1,
            ':approve' => 1,
            ':archive' => 0,
        );
        $criteria->with = array(
            'categories'
        );
        $criteria->together=true;
        $criteria->compare('categories.id',(int)$categoryId);
        if(!is_null($city)){
            $cityObj = Cities::model()->findByAttributes(array('key'=>$city));
            $criteria->addCondition("t.city_id=:city_id");
            $criteria->params[':city_id'] = (int)$cityObj->id;
        }
        return new CActiveDataProvider($this,array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
    }

    public function getCategoriesDeals($categoriesIds,$city){
        $criteria = new CDbCriteria();
        $criteria->condition = 't.status_id=:status_id AND t.approve=:approve AND t.archive=:archive';
        $criteria->params = array(
            ':status_id' => 1,
            ':approve' => 1,
            ':archive' => 0,
        );
        $criteria->with = array(
            'categories'
        );
        $criteria->together=true;
        //$criteria->compare('categories.id',$categoriesIds);
        $criteria->addInCondition('categories.id',$categoriesIds);
        if(!is_null($city)){
            $cityObj = Cities::model()->findByAttributes(array('key'=>$city));
            $criteria->addCondition("t.city_id=:city_id");
            $criteria->params[':city_id'] = (int)$cityObj->id;
        }
        return new CActiveDataProvider($this,array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
            ),
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Deals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array
	 * return list data array for dropdown widget
	 */
	public static function getApproveListData(){
		return array(0=>Yii::t("dealsModule",'Not approved'),1=>Yii::t("dealsModule",'Approved'), 2=>Yii::t("dealsModule",'Sent for revision'));
	}

	public static function getArchiveListData(){
		return array(0=>Yii::t("dealsModule",'Not archive'),1=>Yii::t("dealsModule",'Archive'));
	}
	public static function getPriorityListData(){
		return range(1,9);
	}

	public function getAdminUrl() {
		if (is_null($this->_url)) {
			$this->_url = Yii::app()->createUrl('/deals/backend/deals/view', array('id' => $this->id));
		}
		return $this->_url;
	}

	public function getPublicUrl(){
        //@todo предусмотреть вариант с новым url
		if (is_null($this->_publicUrl)) {
			$this->_publicUrl = Yii::app()->createUrl(
                '/deals/frontend/catalog/deal',
                array(
                    'id' => $this->id,
                    'city' => $this->city->key,
                    'urlSegment' => $this->getFirstCategory()->url_segment,
                    'dealUrlSegment' => $this->url_segment
                )
            );
		}
		return $this->_publicUrl;
	}
    public function getUserUrl(){
		if (is_null($this->_userUrl)) {
			$this->_userUrl = Yii::app()->createUrl('/deals/user/userDeals/view', array('id' => $this->id));
		}
		return $this->_userUrl;
	}

	public function getCategoriesString(){
		$categories = array();
		foreach($this->categories as $category)
		{
            /**
             * @var $category DealsCategories
             */
			$categories[$category->id] = CHtml::link($category->name,$category->getAdminUrl());
		}
		return implode(', ', $categories);
	}

	public function createMediaDirs($id = NULL){
		if(is_null($id)){
			$id = $this->id;
		}
		$mainDir = realpath(Yii::app()->getBasePath()."/../uploads/deals/").DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR;
		$imagesDir = $mainDir.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
		$videosDir = $mainDir.DIRECTORY_SEPARATOR."videos".DIRECTORY_SEPARATOR;
		$linksDir = $mainDir.DIRECTORY_SEPARATOR."links".DIRECTORY_SEPARATOR;
		$videosThumbsDir = $videosDir."thumbs".DIRECTORY_SEPARATOR;
		if(!is_dir($mainDir)){
			if(mkdir($mainDir)){
                chmod($mainDir, 0775);
            }
		}
		if(!is_dir($imagesDir) && is_dir($mainDir)){

			if(mkdir($imagesDir)){
                chmod($imagesDir, 0775);
            }
		}
		if(!is_dir($videosDir)&& is_dir($mainDir)){
			if(mkdir($videosDir)){
                chmod($videosDir, 0775);
			};
		}
		if(!is_dir($linksDir)&& is_dir($mainDir)){
			if(mkdir($linksDir)){
                chmod($linksDir, 0775);
			};
		}
        if(!is_dir($videosThumbsDir) && is_dir($videosDir)){
            if(mkdir($videosThumbsDir)){
                chmod($videosThumbsDir, 0775);
            }
        }
		if(is_dir($mainDir) && is_dir($imagesDir) && is_dir($videosDir) && is_dir($linksDir) && is_dir($videosThumbsDir)){
			return true;
		}
		return false;
	}

	public function deleteMediaDirs($id = NULL){
		if(is_null($id)){
			$id = $this->id;
		}
		$mainDir = realpath(Yii::app()->getBasePath()."/../uploads/deals/").DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR;
		$imagesDir = $mainDir."images".DIRECTORY_SEPARATOR;
		$videosDir = $mainDir."videos".DIRECTORY_SEPARATOR;
		$linksDir = $mainDir."links".DIRECTORY_SEPARATOR;
		$videosThumbsDir = $videosDir."thumbs".DIRECTORY_SEPARATOR;

		if(is_dir($imagesDir) && (sizeof(glob($imagesDir."/*")) == 0)){
			rmdir($imagesDir);
		}
		if(is_dir($videosThumbsDir) && (sizeof(glob($videosThumbsDir."/*")) == 0)){
			rmdir($videosThumbsDir);
		}
		if(is_dir($videosDir) && (sizeof(glob($videosDir."/*")) == 0)){
			rmdir($videosDir);
		}
		if(is_dir($linksDir) && (sizeof(glob($linksDir."/*")) == 0)){
			rmdir($linksDir);
		}
		if(is_dir($mainDir) && (sizeof(glob($mainDir."/*")) == 0)){
			rmdir($mainDir);
		}
		if(!is_dir($mainDir) && !is_dir($imagesDir) && !is_dir($videosDir) && !is_dir($linksDir)){
			return true;
		}
		return false;
	}

	public function afterSave()
	{
		if($this->isNewRecord){
			$this->createMediaDirs();
		}
		parent::afterSave();
	}

    public function afterFind()
    {
        if(strlen(trim($this->description))>0){
            $this->publicDescription = self::text2Link($this->description);
        }
        foreach($this->categories as $category){
            if($category->for_adults == "1"){
                $this->forAdults = true;
                break;
            }
        }
        if(!is_null(DealsParamsValues::model()->findByAttributes(array('deal_id' => $this->id, 'param_id' => self::$calendarParamId, 'value' => '1')))){
            $this->isShowCalendar = true;
            $calendarEventsCount = Calendar::model()->countByAttributes(array('deal_id' => $this->id));
            if($calendarEventsCount>0){
                $this->isShowPublicCalendar = true;
            }
        }
    }

    public function beforeDelete(){
		foreach($this->dealsImages as $image){
			if(!$image->delete()){
				return false;
			}
		}
		foreach($this->dealsVideos as $video){
			if(!$video->delete()){
                return false;
			}
		}
		foreach($this->dealLinks as $link){
			if(!$link->delete()){
                return false;
			}
		}
		if(!$this->deleteMediaDirs()){
            return false;
		}
        if(!$this->deleteComments()){
            return false;
        }
        if(!is_null($this->user) && !is_null($this->user->email) && strlen(trim($this->user->email))>0 && ($this->user_id != Yii::app()->user->getId())){
            $message = Yii::t(
                'dealsModule',
                "Dear {userName}! Deal \"{name}\" was deleted.",
                array(
                    '{userName}' => CHtml::encode($this->user->username),
                    '{name}' => CHtml::encode($this->name)
                )
            );
            /*$messagesModel = new EmailMessages();
            $messagesModel->from = Yii::app()->params['adminEmail'];
            $messagesModel->to = $this->user->email;
            $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');;
            $messagesModel->message = $message;
            $messagesModel->type_id = 1;
            $messagesModel->is_sent = 0;
            $messagesModel->created_date = time();
            $messagesModel->recipient_id = $this->user->id;
            $messagesModel->save();*/
            UserMessages::sendMessage(1,$this->user_id,$message);

        }
		return parent::beforeDelete();
	}

    public function afterDelete(){
        if(sizeof($this->categories)>0){
            foreach($this->categories as $category){
                $criteria = new CDbCriteria();
                $criteria->with='categories';
                $criteria->condition = 't.user_id=:user_id AND exceeding_category_limit_hidden=:exceeding_category_limit_hidden AND categories.id=:category_id';
                $criteria->params = array(
                    ':user_id' => $this->user_id,
                    ':category_id' => $category->id,
                    ':exceeding_category_limit_hidden' => 0
                );
                $userCategoryDealsCount = Deals::model()->count($criteria);
                if($userCategoryDealsCount<$category->free_deals_count){
                    /**
                     * @var $newVisibleDeal Deals
                     */
                    $criteria->params[':exceeding_category_limit_hidden'] = 1;
                    $newVisibleDeal = Deals::model()->find($criteria);
                    if(!is_null($newVisibleDeal)){
                        $newVisibleDeal->setScenario('recountVisibleDealsAfterDealDelete');
                        $newVisibleDeal->exceeding_category_limit_hidden = 0;
                        $newVisibleDeal->exceeding_limit_paid = 0;
                        $newVisibleDeal->save();
                    }
                }
            }
        }
        return parent::afterDelete();
    }

    public function getMinPrice(){
        //Config::var_dump($this->params);

        if(sizeof($this->params)>0 && is_null($this->minPrice)){

            $prices = array();
            $priceParams = DealsParamsValues::model()->findAllBySql("SELECT * FROM `DealsParamsValues` WHERE `deal_id`=$this->id AND `param_id` in (SELECT `id` FROM `DealsParams` WHERE type_id=(SELECT `id` FROM `DealsParamsTypes` WHERE `name`='price'))");
            foreach($priceParams as $priceParam){
                array_push($prices, (int)$priceParam->value);
            }
            if(sizeof($prices)>0){
                $this->minPrice = min($prices);
            }
            else{
                $this->minPrice = 0;
            }
        }
        return $this->minPrice;
    }

    /**
     * @return DealsCategories
     */
    public function getFirstCategory(){
        if(sizeof($this->categories)>0){
            return $this->categories[0];
        }
    }

    public function isInFavorites(){
        if(Yii::app()->user->isGuest){
            if (is_null(Yii::app()->request->cookies['favoritesId'])){
                return false;
            }
            else{
                $favorite = CookiesFavorites::model()->find("cookie_id=:cookie_id AND deal_id=:deal_id", array(':cookie_id' => Yii::app()->request->cookies['favoritesId'], 'deal_id' => $this->id));
                if(is_null($favorite)){
                    return false;
                }
                else{
                    return true;
                }
            }
        }
        else{
            $userId = Yii::app()->user->getId();
            $favorite = UsersFavorites::model()->find("user_id=:user_id AND deal_id=:deal_id", array(':user_id' => $userId, 'deal_id' => $this->id));
            if(is_null($favorite)){
                return false;
            }
            else{
                return true;
            }
        }
    }

    public function setStatistics(){
        $nowStatistics = DealsStatistics::model()->find('date=:date AND deal_id=:deal_id',array(':date' => date('Y-m-d'), ':deal_id' => $this->id));
        if(is_null($nowStatistics)){
            $nowStatistics = new DealsStatistics();
            $nowStatistics->date = date('Y-m-d');
            $nowStatistics->deal_id = $this->id;
        }
        if(is_null(Yii::app()->request->cookies['dealsViews'])){
            $views = array($this->id);
            Yii::app()->request->cookies['dealsViews'] = new CHttpCookie('dealsViews', implode(',',$views));
            $nowStatistics->unique_views = (int)$nowStatistics->unique_views+1;
        }
        else{
            $views = explode(',',Yii::app()->request->cookies['dealsViews']->value);
            // если деал находится в куках, значит добавляем товару просмотр
            if(in_array($this->id,$views)){
                $nowStatistics->views = (int)$nowStatistics->views+1;
            }
            // если в куках нету, добовляем уникальный просмотр и добавляем id в куки
            else{
                array_push($views,$this->id);
                Yii::app()->request->cookies['dealsViews'] = new CHttpCookie('dealsViews', implode(',',$views));
                $nowStatistics->unique_views = (int)$nowStatistics->unique_views+1;
            }
        }
        $nowStatistics->save();
    }

    public function getMetaTitle(){
        if(is_null($this->metaTitle)){
            $this->metaTitle = $this->name.', '.$this->getFirstCategory()->name." ".$this->city->seo_title;
        }
        return $this->metaTitle;
    }

    public function getMetaDescription(){
        if(is_null($this->metaDescription)){
            $this->metaDescription = $this->intro;
        }
        return $this->metaDescription;
    }

    public function getMetaKeyWords(){
        if(is_null($this->metaKeywords)){
            $this->metaKeywords = "";
        }
        return $this->metaKeywords;
    }

    public function getSeoH1(){
        if(is_null($this->seoH1)){
            $this->seoH1 = $this->name;
        }
        return $this->seoH1;
    }

    public function getSeoText(){
        if(is_null($this->seoText)){
            $this->seoText = $this->description;
        }
        return $this->seoText;
    }

    public function deleteComments(){
        $criteria = new CDbCriteria();
        $criteria->condition = ':app_category_id=app_category_id AND :app_category_item_id=app_category_item_id';
        $criteria->params = array(
            ':app_category_id' => 1,
            ':app_category_item_id' => $this->id
        );
        Comments::model()->deleteAll($criteria);
        return true;
    }

    public function getDealAuthorLink(){
        $hiddenUsers = explode(',',Yii::app()->config->get('DEALS_MODULE.HIDDEN_USERS'));
        if(!in_array($this->user_id,$hiddenUsers)){
            return CHtml::link($this->user->getCommentUserName(),$this->user->getPublicUrl(), array('class' => 'author-link'));
        }
        else{
            return false;
        }
    }

    public function beforeSave(){
        $excludedScenarios = array(
            'writeOffForDealsPriorityPlacement',
            'clearDealDescription',
            'showContacts',
            'writeOffForDealsPriorityPlacement',
            'recountVisibleDealsAfterDealDelete'
        );
        if(!in_array($this->getScenario(),$excludedScenarios)){
            if($this->isNewRecord){
                $this->status_id = 1;
            }
            if(!Yii::app()->getModule('user')->isModerator()){
                $this->approve = 0;
                /*if(!is_null($this->user) && !is_null($this->user->email) && strlen(trim($this->user->email))>0){
                    $message = Yii::t(
                        'dealsModule',
                        "Dear {userName}! Deal \"{name}\" was sent for moderation.",
                        array(
                            '{userName}' => CHtml::encode($this->user->username),
                            '{name}' => CHtml::encode($this->name)
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $this->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $this->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$this->user_id,$message);
                }*/
            }
        }
        return parent::beforeSave();
    }

    public function getRelatedDeals(){
        $criteria = new CDbCriteria();
        $criteria->order = "RAND()";
        $criteria->limit = 4;
        $criteria->offset = 'RAND()';
        $criteria->with = array(
            'categories',
        );
        $criteria->together=true;
        $criteria->condition = 't.id<>:id AND t.city_id=:city_id AND t.status_id=:status_id AND t.approve=:approve AND t.archive=:archive AND t.exceeding_category_limit_hidden=:exceeding_category_limit_hidden AND t.user_id NOT IN('.Yii::app()->config->get('DEALS_MODULE.HIDDEN_USERS').')';
        $criteria->params = array(
            ':id' => $this->id,
            ':city_id' => $this->city_id,
            ':status_id' => 1,
            ':approve' => 1,
            ':archive' => 0,
            ':exceeding_category_limit_hidden' => 0
        );
        $criteria->addNotInCondition('categories.id',CHtml::listData($this->categories, 'id', 'id'));
        return self::model()->findAll($criteria);
    }

    public function getIsShowPublicMap(){
        foreach($this->dealsParamsValues as $paramValue){
            if($paramValue->param->type->name == 'coordinates_widget'){
                $longitude = explode(':',$paramValue->value)[0];
                $latitude = explode(':',$paramValue->value)[1];
                $cityLatitude = $this->city->latitude;
                $cityLongitude = $this->city->longitude;

                if($longitude<$cityLongitude-5
                    ||
                    $longitude>$cityLongitude+5
                    ||
                    $latitude<$cityLatitude-5
                    ||
                    $latitude>$cityLatitude+5
                    ||
                    ($latitude == $cityLatitude && $longitude == $cityLongitude)
                ){
                    $this->isShowPublicMap = false;
                }
                else{
                    $this->isShowPublicMap = true;
                }
            }
        }
        return $this->isShowPublicMap;
    }

    /**
     * @return DealsCategories[]
     */
    public function getExceedingLimitCategories(){
        $categories = array();
        foreach($this->categories as $category){
            $criteria = new CDbCriteria();
            $criteria->with='categories';
            $criteria->condition = 't.user_id=:user_id AND categories.id=:category_id';
            $criteria->params = array(
                ':user_id' => $this->user_id,
                ':category_id' => $category->id
            );
            $userCategoryDealsCount = Deals::model()->count($criteria);
            if($userCategoryDealsCount>$category->free_deals_count){
                $categories[] = $category;

            }
        }
        return $categories;
    }

    public function getExceedingLimitCategoriesString(){
        $categories = array();

        foreach($this->getExceedingLimitCategories() as $category){
            $categories[] = $category->name;
        }
        return implode(", ", $categories);
    }

    public function getPaidAmountForExceedingLimitCategories(){
        $paidCategories = $this->getExceedingLimitCategories();
        //Config::var_dump($paidCategories);

        $amount = 0;
        foreach ($paidCategories as $paidCategory) {
            /**
             * @var $paidCategory DealsCategories
             */
            if($amount<$paidCategory->paid_placement_price){
                $amount = $paidCategory->paid_placement_price;
            }
        }
        return $amount;
    }

    public function getContactsQualities(){
        if(sizeof($this->contactsQualitiesCounts) == 0){
            foreach(self::$dealsContactsQualities as $k=>$v){
                $this->contactsQualitiesCounts[$k] = DealsContactsQuality::model()->countByAttributes(array('deal_id' => $this->id, 'quality' => $k));
            }
        }
        return $this->contactsQualitiesCounts;
    }

    public static function text2Link($text) {
        //$text = html_entity_decode($text);
        $text = str_replace('<'," <", $text);
        $text = htmlentities($text);
        $text = str_replace("&nbsp;",' ',$text);
        $text =  preg_replace('/\b(https?:\/\/[\S]+[^\s,.;]{1})/si', '<a target="_blank" rel="nofollow" href="$1">$1</a>', $text);
        return (html_entity_decode($text));
    }

    public static function cropText($text = '', $length = 80){
        $str = strip_tags($text);
        if (strlen($str) > $length) {
            $str = substr($str, 0, $length);
            $str = substr($str, 0, strrpos($str, ' '));
            $str.='...';
        }
        return $str;
    }

    public static function getUnapprovedDeals(){

        $criteria = new CDbCriteria();
        $criteria->condition = 'approve<>:approve';
        $criteria->params = array(
            ':approve'=>1
        );
        $criteria->addNotInCondition('t.user_id',explode(",",Yii::app()->config->get("DEALS_MODULE.HIDDEN_USERS")));
        return self::model()->findAll($criteria);
    }

    public static function hidePhone($phone, $isAddShadow = false){
        $shadow = preg_replace("/[0-9]{1}/", "X", substr($phone,3,strlen($phone)));
        $hiddenPhone = substr($phone,0,2);
        if($isAddShadow){
            $hiddenPhone.=$shadow;
        }
        return DealCategoriesParams::getPublicPhoneNumber($hiddenPhone);
    }
}
