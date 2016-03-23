<?php

class LoginController extends FrontendController
{
	public $defaultAction = 'login';
	//public $layout = "main";

    public function actionVkAuthenticate(){

        if(isset($_GET['access_token']) && isset($_GET['user_id'])){
            $userFields = array(
                'city',
                'country',
                'photo_max_orig',
                'contacts',
            );
            $fieldsString = implode(',',$userFields);
            $jsonVkUserInfo = file_get_contents("https://api.vk.com/method/users.get?user_id=".$_GET['user_id']."&fields=".$fieldsString."&v=5.34&access_token=".$_GET['access_token']);
            $vkUserInfo = CJSON::decode($jsonVkUserInfo);
            $model = new VkUserModel();
            $attributes = array(
                'uid'=>$_GET['user_id'],
                'accessToken'=>$_GET['access_token'],
                'accessTokenExpires'=>(int)$_GET['expires_in'],
                'provider'=>'vkontakte',
                'email'=>(isset($_GET['email']) && is_null(User::model()->find(':email=user.email',array(':email' => $_GET['email']))))? $_GET['email']:NULL
            );
            if(!is_null(Yii::app()->request->cookies['invite_code'])){
                $attributes['invitecode'] = Yii::app()->request->cookies['invite_code']->value;
            }
            if(isset($vkUserInfo['response']) && isset($vkUserInfo['response'][0])){
                $response = $vkUserInfo['response'][0];
                $attributes = array_merge(
                    $attributes,
                    array(
                        'first_name'=>isset($response['first_name']) ? $response['first_name'] : NULL,
                        'last_name'=>isset($response['last_name']) ? $response['last_name'] : NULL,
                        'photo'=>isset($response['photo_max_orig']) ? $response['photo_max_orig'] : NULL,
                        'city'=>isset($response['city'])? $response['city']['title'] : NULL,
                        'country'=>isset($response['country'])? $response['country']['title'] : NULL,
                    )
                );
            }
            $model->setAttributes($attributes);
            if($model->validate()){
                if($model->login()){
                    //перенапрявляем пользователя на страницу профиля
                    $message = "You have successfully signed up with Vkontakte.";
                    if(is_null($model->email)){
                        $message .= " To use the site please fill in the email field";
                    }
                    Yii::app()->user->setFlash("userVkAuthenticate",Yii::t('userModule',$message));
                    $this->redirect(Yii::app()->createUrl('/user/profile/editMainSettings'));
                }
            }
            else {
                //сообщение об ошибке
                Yii::app()->user->setFlash("userVkAuthenticate",Yii::t('userModule',"When you signed up with Vkontakte error occurred"));
                $this->redirect(Yii::app()->createUrl('/user/login/login'));
            }
        }
        else {
            //если этот метод вызван напрямую (без указания token)
            $this->redirect(Yii::app()->homeUrl, true);
        }
    }
    public function actionVkAuthRedirect(){
        $this->render('/user/vkauthredirect');
    }

    public function actionFbAuthenticate(){

        if(isset($_POST['user_data']) && isset($_POST['auth_user_data'])){
            $fbUserInfo = $_POST['user_data'];
            $model = new FbUserModel();
            $attributes = array(
                'uid'=>$_POST['auth_user_data']['userID'],
                'accessToken'=>$_POST['auth_user_data']['accessToken'],
                'accessTokenExpires'=>(int)$_POST['auth_user_data']['expiresIn'],
                'provider'=>'facebook',
                'email'=>(isset($fbUserInfo['email']) && is_null(User::model()->find(':email=user.email',array(':email' => $fbUserInfo['email']))))? $fbUserInfo['email']:NULL
            );
            if(!is_null(Yii::app()->request->cookies['invite_code'])){
                $attributes['invitecode'] = Yii::app()->request->cookies['invite_code']->value;
            }
            $attributes = array_merge(
                $attributes,
                array(
                    'first_name'=>isset($fbUserInfo['first_name']) ? $fbUserInfo['first_name'] : NULL,
                    'last_name'=>isset($fbUserInfo['last_name']) ? $fbUserInfo['last_name'] : NULL,
                    'photo'=>isset($fbUserInfo['picture']) ? $fbUserInfo['picture']['data']['url'] : NULL,
                    'name'=>isset($fbUserInfo['name']) ? $fbUserInfo['name'] : NULL,
                    'link'=>isset($fbUserInfo['link'])? $fbUserInfo['link'] : NULL,
                )
            );
            /*var_dump($_POST);
            if(isset($_POST['picture']) && isset($_POST['picture']['data']) && isset($_POST['picture']['data']['url'])){
                $attributes['photo'] = $_POST['picture']['data']['url'];
            }*/
            $model->setAttributes($attributes);
            if($model->validate()){
                if($model->login()){
                    //перенапрявляем пользователя на страницу профиля
                    $message = Yii::t("userModule","You have successfully signed up with Facebook.");
                    if(is_null($model->email)){
                        $message .= Yii::t("userModule"," To use the site please fill in the email field");
                    }
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => $message
                        )
                    );
                    //Yii::app()->user->setFlash("userVkAuthenticate",Yii::t('userModule',$message));

                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t("userModule",'When you signed up with Facebook error occurred.')
                        )
                    );
                }
            }
            else {
                //сообщение об ошибке
                echo CJSON::encode(
                    array(
                        'status' => 'error',
                        'message' => Yii::t("userModule",'When you signed up with Facebook error occurred.')
                    )
                );
            }
        }
        else {
            //если этот метод вызван напрямую (без указания token)
            throw new CHttpException(403, Yii::t("userModule",'Access denied.'));
        }
    }

}