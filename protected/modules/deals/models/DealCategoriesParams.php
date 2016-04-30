<?php

/**
 * This is the model class for table "DealsCategoriesParams".
 *
 * The followings are the available columns in table 'DealsCategoriesParams':
 * @property string $id
 * @property string $deal_category_id
 * @property string $deal_param_id
 *
 * The followings are the available model relations:
 * @property DealsCategories $dealCategory
 * @property DealsParams $dealParam
 */
class DealCategoriesParams extends CFormModel
{
	/**
	 * @var Deals
	 */
	private $_deal = NULL;
	private $_rules = array();
	private $_categories = array();
	private $_categoriesParams = array();
	private $_aroundUndergrounds = array();
	private $_params = array();
	private $_e;
	private $_m;

    public $isShowCurrenciesSelect = false;
    public $userCityId = NULL;

    public $latitude;
    public $longitude;
    /**
     * @var Cities
     */
    public $userCity = NULL;

	public function __construct($scenario='', Deals $deal)
	{
		if(!is_null($deal)){
			$this->_deal = $deal;
		}
		$this->_categories = $deal->categories;

		$this->setScenario($scenario);
		$this->init();
		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();
	}

	public function init(){
		//берём параметры только текущих категорий
		$params = $this->getCurrentCategoriesParams();
		//берём все параметры которые есть в базе
		//$params = $this->getParams();
		$currentParams = array();
		if(!is_null($this->_deal)){
			$dealParams = $this->_deal->dealsParamsValues;
			foreach($dealParams as $dealParam){

				if($dealParam->param->name == "coordinates"){
					$currentParams['longitude'] = explode(':',$dealParam->value)[0];
					$currentParams['latitude'] = explode(':',$dealParam->value)[1];
				}
                if($dealParam->param->type->name == "list"){
                    $currentParams[$dealParam->param->name][] = $dealParam->value;
                }
                else{
                    $currentParams[$dealParam->param->name] = $dealParam->value;
                }
			}
		}

		foreach($params as $param){
			$tmpName = $param->name;
			if($tmpName == "coordinates"){
                if(is_null(Yii::app()->request->cookies['cityId'])){
                    $this->userCityId = Yii::app()->config->get('ADMIN_MODULE.DEFAULT_CITY_ID');
                }
                else{
                    $this->userCityId = Yii::app()->request->cookies['cityId']->value;
                }
                $this->userCity = Cities::model()->findByPk($this->userCityId);

				$this->latitude = (isset($currentParams['latitude'])) ? $currentParams['latitude'] : (is_null($this->userCity) ? 0 : $this->userCity->latitude);
				$this->longitude = (isset($currentParams['longitude'])) ? $currentParams['longitude'] : (is_null($this->userCity) ? 0 : $this->userCity->longitude);
			}
			$this->$tmpName = (isset($currentParams[$tmpName])) ? $currentParams[$tmpName] : ((isset($param->default)) ? $param->default : NULL);
		}
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		//берём параметры только текущих категорий
		$params = $this->getCurrentCategoriesParams();
		//берём все параметры
		//$params = $this->getParams();

		// создаём правила валидации для параметров категорий к которым относится товар
		if(sizeof($params)>0){
			$required = array();
			$numerical = array();
			$float = array();
			$decimal = array();
			$boolean = array();
			$url = array();
			$email = array();
			$rules = array();

			foreach($params as $param){
				$param_rule = array();
				/*if(isset($_POST['DealCategoriesParams']) && isset($_POST['DealCategoriesParams'][$param->name])){*/
					if ($param->required == '1')
						array_push($required,$param->name);
					if ($param->type->name=='float')
						array_push($float,$param->name);
					if ($param->type->name=='decimal')
						array_push($decimal,$param->name);
					if ($param->type->name=='integer' || $param->type->name=='price')
						array_push($numerical,$param->name);
					if ($param->type->name=='bool')
						array_push($boolean,$param->name);
					if ($param->type->name=='url')
						array_push($url,$param->name);
					if ($param->type->name=='email')
						array_push($email,$param->name);
					if ($param->type->name=='varchar' || $param->type->name=='text' || $param->type->name=="phone" || $param->type->name=='coordinates_widget') {
						$param_rule = array($param->name, 'length', 'max'=>(int)$param->field_size, 'min' => (int)$param->field_size_min);
						if ($param->error_message) $param_rule['message'] = Yii::t('dealsModule',$param->error_message);
						array_push($rules,$param_rule);
					}
					if($param->other_validator){
						if (strpos($param->other_validator,'{')===0) {
							$validator = (array)CJavaScript::jsonDecode($param->other_validator);
							foreach ($validator as $name=>$val) {
								$param_rule = array($param->name, $name);
								$param_rule = array_merge($param_rule,(array)$validator[$name]);
								if ($param->error_message) $param_rule['message'] = Yii::t('dealsModule',$param->error_message);
								array_push($rules,$param_rule);
							}
						} else {
							$param_rule = array($param->name, $param->other_validator);
							if ($param->error_message) $param_rule['message'] = Yii::t('dealsModule',$param->error_message);
							array_push($rules,$param_rule);
						}
					} elseif ($param->type->name=='date') {
						$param_rule = array($param->name, 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd', 'allowEmpty'=>true);
						if ($param->error_message) $param_rule['message'] = Yii::t('dealsModule',$param->error_message);
						array_push($rules,$param_rule);
					}
					if ($param->match) {
						$param_rule = array($param->name, 'match', 'pattern' => $param->match);
						if ($param->error_message) $param_rule['message'] = Yii::t('dealsModule',$param->error_message);
						array_push($rules,$param_rule);
					}
					if ($param->range) {
						$param_rule = array($param->name, 'in', 'range' => self::rangeRules($param->range));
						if ($param->error_message) $param_rule['message'] = Yii::t('dealsModule',$param->error_message);
						array_push($rules,$param_rule);
					}
				/*}*/
			}

			array_push($rules,array(implode(',',$required), 'required'));
			array_push($rules,array(implode(',',$numerical), 'numerical', 'integerOnly'=>true));
			array_push($rules,array(implode(',',$float), 'type', 'type'=>'float'));
			array_push($rules,array(implode(',',$decimal), 'match', 'pattern' => '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'));
			array_push($rules,array(implode(',',$boolean), 'boolean', 'falseValue' => '0', 'trueValue' => '1', 'strict' => false));
			array_push($rules,array(implode(',',$url), 'url', 'defaultScheme' => 'http', 'validateIDN' => true));
			array_push($rules,array(implode(',',$email), 'email'));
            array_push($rules,array('latitude, longitude', 'match', 'pattern' => '/^\s*[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?\s*$/'));

            $this->_rules = $rules;
		}
		return $this->_rules;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
            'latitude' => Yii::t('dealsModule','latitude'),
            'longitude' => Yii::t('dealsModule','longitude'),
        );
		foreach ($this->getCurrentCategoriesParams() as $param){
			$labels[$param->name] = Yii::t('dealsModule',$param->label);
		}

		return $labels;

	}

    /**
     * @return array
     *
     */
	public function getCurrentCategoriesParams(){
		if(!$this->_categoriesParams){
			if(isset($this->_categories) && sizeof($this->_categories)>0){
				$allParamsNamesList = array();
				foreach ($this->_categories as $category){
                    /**
                     * @var $category DealsCategories
                     */
                    $categoryParams = $category->getCategoryParamsWithParentCategoryParamsRecursively();
					if(isset($categoryParams) && sizeof($categoryParams)>0){
						foreach($categoryParams as $param){
							if(!in_array($param->name,$allParamsNamesList)){
								array_push($allParamsNamesList, $param->name);
								array_push($this->_categoriesParams, $param);
                                // устанавливаем метку, что нужно отображать поля "Валюта" и "Торг" во вьюхе
                                if($param->type->name == 'price'){
                                    $this->isShowCurrenciesSelect = true;
                                }
							}
						}
					}
				}
			}
		}
		return $this->sortByTagName($this->_categoriesParams, 'type_id');
	}

	public function getParams(){
		if(!$this->_params){
			$criteria = new CDbCriteria;
			$criteria->condition = 'visible=:visible';
			$criteria->params = array(':visible' => 1);
			$this->_params = DealsParams::model()->findAll($criteria);
		}
		return $this->_params;
	}
	private function rangeRules($str) {
		$rules = explode(';',$str);
		for ($i=0;$i<count($rules);$i++)
			$rules[$i] = current(explode("==",$rules[$i]));
		return $rules;
	}

	public static function range($str,$fieldValue=NULL) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])) $array[$item[0]] = ((isset($item[1]))?$item[1]:$item[0]);
		}
		if (isset($fieldValue))
			if (isset($array[$fieldValue])) return $array[$fieldValue]; else return '';
		else
			return $array;
	}

	public function __set($name,$value)
	{
		$setter='set'.$name;
		if(method_exists($this,$setter))
			return $this->$setter($value);
		elseif(strncasecmp($name,'on',2)===0 && method_exists($this,$name))
		{
			// duplicating getEventHandlers() here for performance
			$name=strtolower($name);
			if(!isset($this->_e[$name]))
				$this->_e[$name]=new CList;
			return $this->_e[$name]->add($value);
		}
		elseif(is_array($this->_m))
		{

			foreach($this->_m as $object)
			{
				if($object->getEnabled() && (property_exists($object,$name) || $object->canSetProperty($name)))
					return $object->$name=$value;
			}
		}
		else{
			if(!property_exists($this, $name)){
				$this->$name = $value;
			}
		}
		/*if(method_exists($this,'get'.$name))
			throw new CException(Yii::t('yii','Property "{class}.{property}" is read only.',
				array('{class}'=>get_class($this), '{property}'=>$name)));
		else
			throw new CException(Yii::t('yii','Property "{class}.{property}" is not defined.',
				array('{class}'=>get_class($this), '{property}'=>$name)));*/
	}

	public function getAroundUndergrounds($distance = 1) {
		if(!$this->_aroundUndergrounds){
			$this->_aroundUndergrounds = Underground::model()->coordinates($this->latitude, $this->longitude, $distance)->findAll();
		}
		return $this->_aroundUndergrounds;
	}
	public function  getAroundUndergroundsListData($distance = 1){
		return CHtml::listData($this->getAroundUndergrounds($distance),'id','name');
	}

	public function getAroundUndergroundsString($distance = 1){
		$undergrounds = array();
		foreach($this->getAroundUndergrounds($distance) as $underground)
		{
			$undergrounds[$underground->id] = CHtml::link($underground->name,$underground->getAdminUrl());
		}
		return implode(', ', $undergrounds);
	}

	//80291346950
	//80441346950
	//80331346950
	//80251346950
	//80171346950

	//+375447625868
	//+375297625868
	//+375177625868
	//+375337625868
	//+375257625868
    public static function getPublicPhoneNumber($number = NULL){
        if(is_null($number)){
            return false;
        }
        else{
            $rest = $number;
            if (strlen($number) == 11) {
                if (substr($number, 0, 1) == '7') {
                    $rest = '+' . substr($number, 0, 1) . ' (' . substr($number, 1, 3) . ') ' . substr($number, 4, 3) . '-' . substr($number, 7, 2) . '-' . substr($number, 9, 2);
                }
                if (substr($number, 0, 1) == '8') {
                    if(substr($number, 1, 3) == '029' || substr($number, 1, 3) == '033' || substr($number, 1, 3) == '044' || substr($number, 1, 3) == '025' || substr($number, 1, 3) == '017'){
                        $rest = '+375 (' . substr($number, 2, 2) . ') ' . substr($number, 4, 3) . '-' . substr($number, 7, 2) . '-' . substr($number, 9, 2);
                    }
                    else{
                        $rest = '+7 (' . substr($number, 1, 3) . ') ' . substr($number, 4, 3) . '-' . substr($number, 7, 2) . '-' . substr($number, 9, 2);
                    }
                }
            } elseif (strlen($number) == 10/* && substr($number, 0, 1) == '9'*/) {
                $rest = '+7 (' . substr($number, 0, 3) . ') ' . substr($number, 3, 3) . '-' . substr($number, 6, 2) . '-' . substr($number, 8, 2);
            } elseif (strlen($number) == 12 && substr($number, 0, 1) == '3') {
                $rest = '+' . substr($number, 0, 3) . ' (' . substr($number, 3, 2) . ') ' . substr($number, 5, 3) . '-' . substr($number, 8, 2) . '-' . substr($number, 10, 2);
            } elseif (strlen($number) == 7) {
                $rest = substr($number, 0, 3) . '-' . substr($number, 3, 2) . '-' . substr($number, 5, 2);
            } elseif (strlen($number) == 13 && substr($number, 0, 4) == "+375") {
                $rest = '+375 (' . substr($number, 4, 2) . ') ' . substr($number, 6, 3) . '-' . substr($number, 9, 2) . '-' . substr($number, 11, 2);
            }
            return $rest;
        }
    }

	public static function getFormattedUrl($url = NULL){
        if(is_null($url)){
            return false;
        }
        else{
            if (substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://') {
                return $url;
            }
            else{
                return "http://".$url;
            }
        }
    }

	public static function sortByTagName($arr, $tagName){
		$index = array();
		foreach($arr as $a) $index[] = $a->$tagName;
		array_multisort($index, $arr);
		return $arr;
	}
}
