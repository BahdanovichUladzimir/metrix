<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 12.06.2015
 */

class FbUserModel extends CModel{

    public $uid;
    public $accessToken;
    public $accessTokenExpires;
    public $first_name;
    public $last_name;
    public $name;
    public $photo;
    public $provider;
    public $city;
    public $country;
    public $email;
    public $invitecode;
    public $link;

    public function rules() {
        return array(
            array('uid, provider', 'required'),
            array('uid, accessToken, provider, city, country, name', 'length', 'max'=>255),
            array('invitecode', 'length', 'max'=>128, 'min' => 4),
            array('accessTokenExpires', 'length', 'max'=>20),
            array('accessTokenExpires', 'numerical', 'integerOnly'=>true),
            array('photo, link', 'url'),
            array('email', 'email'),
            array('first_name, last_name', 'length', 'max'=>55),
        );
    }

    public function attributeLabels() {
        return array(
            'uid'=>Yii::t("userModule",'UID'),
            'accessToken'=>Yii::t("userModule",'Access token'),
            'accessTokenExpires'=>Yii::t("userModule",'Access token expires'),
            'first_name'=>Yii::t("userModule",'First Name'),
            'last_name'=>Yii::t("userModule",'Last Name'),
            'name'=>Yii::t("userModule",'Name'),
            'photo'=>Yii::t("userModule",'Photo'),
            'provider'=>Yii::t("userModule",'Provider'),
            'city'=>Yii::t("userModule",'City'),
            'country'=>Yii::t("userModule",'Country'),
            'email'=>Yii::t("userModule",'Email'),
            'invitecode'=>Yii::t("userModule",'Invite code'),
            'link'=>Yii::t("userModule",'Link'),
        );
    }



    /**
     * Аутентификация посетителя.
     * @return boolean true - если посетитель аутентифицирован, false - в противном случае.
     */
    public function login() {
        $identity = new FbUserIdentity();
        if($iden = $identity->authenticate($this)){
            $duration = 3600*24*30; // 30 days
            Yii::app()->user->login($identity,$duration);
            return true;
        }
        return false;
    }

    public function attributeNames() {
        return array(
            'uid',
            'accessToken',
            'accessTokenExpires',
            'first_name',
            'last_name',
            'photo',
            'provider',
            'city',
            'country',
            'email',
            'invitecode'
        );
    }
}