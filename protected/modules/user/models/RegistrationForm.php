<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
	public $agreement;
	
	public function rules() {
		$rules = array(
			array('username, password, verifyPassword, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => Yii::t('userModule',"Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => Yii::t('userModule',"Incorrect password (minimal length 4 symbols).")),
			array('invitecode', 'length', 'max'=>128, 'min' => 4),
			array('email', 'email'),
			array('username', 'unique', 'message' => Yii::t('userModule',"This user's name already exists.")),
			array('email', 'unique', 'message' => Yii::t('userModule',"This user's email address already exists.")),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('userModule',"Retype Password is incorrect.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => Yii::t('userModule',"Incorrect symbols (A-z0-9).")),
			array('agreement', 'boolean', 'falseValue' => '0', 'trueValue' => '1'),
		);
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		}
		
		array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => Yii::t('userModule',"Retype Password is incorrect.")));
		return $rules;
	}

    /**
     * @return array customized attribute labels (name=>label)
     */
	public function attributeLabels(){
		return array(
			'username' => Yii::t('userModule','Username'),
			'email' => Yii::t('userModule','Email'),
			'password' => Yii::t('userModule','Password'),
			'verifyPassword' => Yii::t('userModule','Verify password'),
			'required' => Yii::t('userModule','Required'),
			'verifyCode' => Yii::t('userModule','Verify code'),
			'invitecode' => Yii::t('userModule','Invite code'),
		);
	}
}