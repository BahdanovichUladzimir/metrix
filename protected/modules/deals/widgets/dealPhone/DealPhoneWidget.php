<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 21.03.2015
 */

class DealPhoneWidget extends CWidget{

    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public $dealParamName = 'phone_1';
    public $phone = NULL;
    public $publicPhone = NULL;
    public $invisiblePhone = NULL;
    public static $widgetId = 0;

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        if((sizeof($this->deal->dealsParamsValues) == 0)){
            return false;
        }
        if(is_null($this->phone)){
            foreach($this->deal->dealsParamsValues as $paramValue){
                if($paramValue->param->name == $this->dealParamName){
                    $this->phone = $paramValue->value;
                    break;
                }
            }
        }
        if(is_null($this->phone)){
            foreach($this->deal->dealsParamsValues as $paramValue){
                if($paramValue->param->type->name == "phone"){
                    $this->phone = $paramValue->value;
                    break;
                }
            }
        }
        if(is_null($this->phone) || strlen(trim($this->phone)) == 0){
            return false;
        }
        $this->publicPhone = DealCategoriesParams::getPublicPhoneNumber($this->phone);
        $this->invisiblePhone = Deals::hidePhone($this->phone);
        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'dealParamName' => $this->dealParamName,
                'phone' => $this->phone,
                'publicPhone' => $this->publicPhone,
                'invisiblePhone' => $this->invisiblePhone,
                'widgetId' => self::$widgetId
            )
        );
    }
}