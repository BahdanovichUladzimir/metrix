<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.03.2015
 */

class DealParamsWidget extends CWidget{
    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public $userCurrency = NULL;
    public static $widgetId = 0;

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        if((sizeof($this->deal->params) == 0)){
            return false;
        }
        if (isset(Yii::app()->request->cookies['currencyId'])){
            $this->userCurrency = Currencies::model()->findByPk((int)Yii::app()->request->cookies['currencyId']->value);
        }
        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'userCurrency' => $this->userCurrency,
                'widgetId' => self::$widgetId
            )
        );
    }
}