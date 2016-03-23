<?php

/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 22.10.2015
 */
class EventLogin extends CFormModel
{
    public $password;
    /**
     * @var Events
     */
    public $event;

    public function init(){
        parent::init();
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // password are required
            array('password', 'required'),
            array('password', 'checkEventPassword'),
        );
    }

    public function checkEventPassword($attribute,$params){
        if (!$this->hasErrors()){
            if($this->password !== $this->event->password){
                $this->addError('password', Yii::t("eventsModule","Incorrect password."));
            }
        }

    }
    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'password' => Yii::t('eventsModule',"Password"),
        );
    }

}