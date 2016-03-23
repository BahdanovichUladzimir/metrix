<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 15.03.2015
 */

class CurrencySelectWidget extends CWidget{

    public static $widgetId;
    public function init(){

    }

    public function run(){
        $currencies = Currencies::model()->findAll();
        $userCurrencyId = Yii::app()->request->cookies['currencyId']->value;
        $this->render(
            'default',
            array(
                'currencies' => $currencies,
                'userCurrencyId' => (int)$userCurrencyId,
                'widgetId' => self::$widgetId
            )
        );
        self::$widgetId++;
    }
}