<?php

class RegistrationController extends FrontendController
{
	public $defaultAction = 'registration';
	//public $layout = "auth";
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

    private function _addBonusForInvite($model){
        $invites = GmailInvites::model()->findAll('invite_email=:email', array(':email' => $model->email));
        if(sizeof($invites)>0){
            foreach($invites as $invite){
                $payment = new Payments();
                $payment->amount = Yii::app()->config->get('USER_MODULE.GMAIL_INVITE_BONUS_AMOUNT');
                $payment->real_amount = Yii::app()->config->get('USER_MODULE.GMAIL_INVITE_BONUS_AMOUNT');
                $payment->time = time();
                $payment->user_id = $invite->user_id;
                $payment->user = $invite->user;
                $payment->app_category_id = 3;
                $payment->app_item_id = $invite->id;
                $payment->type_id = 1;
                $payment->save();
            }
            $payment = new Payments();
            $payment->amount = Yii::app()->config->get('USER_MODULE.GMAIL_INVITE_BONUS_AMOUNT');;
            $payment->real_amount = Yii::app()->config->get('USER_MODULE.GMAIL_INVITE_BONUS_AMOUNT');;
            $payment->time = time();
            $payment->user_id = $model->id;
            $payment->app_category_id = 3;
            $payment->app_item_id = $invites[0]->id;
            $payment->type_id = 1;
            $payment->save();
        }
    }

	public function actionAuthorization(){

        $this->layout = '//layouts/auth';
		if(Yii::app()->user->isGuest){
            // Если в запросе пришёл инвайт код (пользователь перешёл по ссылке от другого пользователя), то записывем его в куку
			$loginModel=new UserLogin();
            $registrationModel = new RegistrationForm();
            $profileModel=new Profile();
            if(Yii::app()->getRequest()->getQuery('invite_code')){
                $cookie = new CHttpCookie('invite_code', Yii::app()->getRequest()->getQuery('invite_code'));
                $cookie->expire = time()+60*60*24;
                Yii::app()->request->cookies['invite_code'] = $cookie;
                $registrationModel->invitecode = Yii::app()->getRequest()->getQuery('invite_code');
            }

            // collect user input data
			if(isset($_POST['UserLogin']))
			{
				$loginModel->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($loginModel->validate()){
					$this->lastViset();
					if(Yii::app()->user->returnUrl=='/index.php'){
						$this->redirect(Yii::app()->controller->module->returnUrl);
					}
					else{
						$this->redirect(Yii::app()->user->returnUrl);
					}
				}

			}
            elseif(isset($_POST['RegistrationForm'])){
                // ajax validator
                if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
                {
                    echo UActiveForm::validate(array($registrationModel,$profileModel));
                    Yii::app()->end();
                }
                $registrationModel->attributes=$_POST['RegistrationForm'];

                $profileModel->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                if($registrationModel->validate() && $profileModel->validate())
                {
                    $soucePassword = $registrationModel->password;
                    $registrationModel->activkey=UserModule::encrypting(microtime().$registrationModel->password);
                    $registrationModel->password=UserModule::encrypting($registrationModel->password);
                    $registrationModel->verifyPassword=UserModule::encrypting($registrationModel->verifyPassword);
                    $registrationModel->superuser=0;
                    $registrationModel->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
                    $registrationModel->setLastvisit(time());

                    if ($registrationModel->save()) {
                        $registrationMessage = Yii::app()->config->get("USER_MODULE.REGISTRATION_MESSAGE");
                        UserMessages::sendMessage(1,$registrationModel->id,$registrationMessage);
                        $profileModel->user_id=$registrationModel->id;
                        $profileModel->save();
                        Yii::app()->authManager->assign("Authenticated", $registrationModel->id);
                        if (Yii::app()->controller->module->sendActivationMail) {
                            $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $registrationModel->activkey, "email" => $registrationModel->email));
                            //UserModule::sendMail($registrationModel->email,Yii::t('userModule',"You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),Yii::t('userModule',"Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
                            $isSendMail = UserModule::sendSmtpMail($registrationModel->email, Yii::app()->params['adminEmail'], Yii::t('userModule',"You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),Yii::t('userModule',"Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
                            //var_dump($isSendMail);
                        }

                        if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
                            $identity=new UserIdentity($registrationModel->username,$soucePassword);
                            $identity->authenticate();
                            Yii::app()->user->login($identity,0);
                            $this->_addBonusForInvite($registrationModel);
                            $this->redirect(Yii::app()->controller->module->returnUrl);
                        } else {
                            if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
                                Yii::app()->user->setFlash('registration',Yii::t('userModule',"Thank you for your registration. Contact Admin to activate your account."));
                            } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
                                Yii::app()->user->setFlash('registration',Yii::t('userModule',"Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(Yii::t('userModule','Login'),Yii::app()->controller->module->loginUrl))));
                            } elseif(Yii::app()->controller->module->loginNotActiv) {
                                Yii::app()->user->setFlash('registration',Yii::t('userModule',"Thank you for your registration. Please check your email or login."));
                            } else {
                                Yii::app()->user->setFlash('registration',Yii::t('userModule',"Thank you for your registration. Please check your email."));
                            }
                            $this->_addBonusForInvite($registrationModel);
                            $this->refresh();
                        }

                    }
                }
                else{
                    $profileModel->validate();
                }
            }
            $data = array(
                'loginModel'=>$loginModel,
                'registrationModel'=> $registrationModel,
                'profileModel'=>$profileModel,
            );
            if(Yii::app()->getRequest()->getQuery('invite_code')){
                $data['inviteCode'] = Yii::app()->getRequest()->getQuery('invite_code');
            }
            $this->render(
                '/user/auth',
                $data
            );
        }
		else{
			$this->redirect(Yii::app()->controller->module->returnUrl);
		}
    }
    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }
    public function actionSetInviteCode(){
        if(isset($_POST) && isset($_POST['code']) && strlen(trim($_POST['code']))>0){
            $userId = Yii::app()->user->getId();
            $user = User::model()->findByPk($userId);
            if(!is_null($user)){
                $user->setScenario("setInviteCode");
                $user->invitecode = trim($_POST['code']);
                if(Yii::app()->request->isAjaxRequest){
                    if($user->save()){
                        echo CJSON::encode(
                            array(
                                'status' => 'success',
                                'message' => 'Invite code was saved successfully.'
                            )
                        );
                    }
                    else{
                        echo CJSON::encode(
                            array(
                                'status' => 'success',
                                'message' => 'When save invite code error occurred.',
                                'errors' => $user->getErrors()
                            )
                        );
                    }
                }
            }
        }
    }
}