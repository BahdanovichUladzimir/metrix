<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 */

class DealPriceWidget extends CWidget{

    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public static $widgetId = 0;

    public function init(){
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        if(is_null($this->deal->getMinPrice()) || ($this->deal->getMinPrice() <= 0)){
            return false;
        }

        if (isset(Yii::app()->request->cookies['currencyId'])){
            $userCurrency = Currencies::model()->findByPk((int)Yii::app()->request->cookies['currencyId']->value);
        }
        if(empty($this->deal->currency)){
            $this->deal->currency = Currencies::model()->findByPk(1);
        }
        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'userCurrency' => $userCurrency,
                'widgetId' => self::$widgetId
            )
        );
        self::$widgetId++;

    }
}