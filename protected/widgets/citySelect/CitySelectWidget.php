<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 15.03.2015
 */

class CitySelectWidget extends CWidget{

    public static $widgetId = 0;
    public $moduleId = NULL;
    public $controllerId = NULL;
    public $actionId = NULL;
    public $currentCategoryId = NULL;
    public function init(){

        $this->moduleId = (isset(Yii::app()->controller->module)) ? Yii::app()->controller->module->getId() : NULL;
        $this->controllerId = Yii::app()->controller->getId();
        $this->actionId = Yii::app()->controller->action->getId();
        $this->currentCategoryId = isset(Yii::app()->controller->currentCategory) ? Yii::app()->controller->currentCategory : NULL;
    }

    public function run(){
        $criteria = new CDbCriteria();
        $criteria->order = 'priority ASC';
        $cities = Cities::model()->findAll($criteria);
        $userCityId = Yii::app()->request->cookies['cityId']->value;
        $userCityKey = Yii::app()->request->cookies['cityKey']->value;

        $uriArr = explode("/", Yii::app()->request->requestUri);
        $citiesArr = CHtml::listData(Cities::model()->findAll(),"id", "key");
        if(in_array($uriArr[1],$citiesArr)){
            $uri = implode("/" ,array_slice($uriArr,2));
        }
        else{
            $uri = implode("/",$uriArr);
        }


        $this->render(
            'default',
            array(
                'cities' => $cities,
                'uri'=> $uri,
                'userCityId' => (int)$userCityId,
                'userCityKey' => $userCityKey,
                'widgetId' => self::$widgetId,
                'moduleId' => $this->moduleId,
                'controllerId' => $this->controllerId,
                'actionId' => $this->actionId,
                'currentCategory' => !is_null($this->currentCategoryId) ? DealsCategories::model()->findByPk($this->currentCategoryId) : NULL,
            )
        );
        self::$widgetId++;
    }
}
