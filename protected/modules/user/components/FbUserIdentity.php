<?php
/**
 * Этот класс выполняет аутентификацию и, при необходимости, регистрацию посетителя.
 */
class FbUserIdentity implements IUserIdentity {

    private $id;
    private $name;
    private $user;
    private $isAuthenticated = false;
    private $states = array();



    /**
     * Аутентификация пользователя.
     * Этот метод ищет пользователя в БД. Если он не найден, создает нового.
     * Устанавливает значения атрибутов.
     *
     * @param FbUserModel $fbUserModel модель, содержащая данные от сервиса Loginza
     * @return boolean true если пользователь найден или создан новый аккаунт, false - если недостаточно данных
     */
    public function authenticate($fbUserModel = null) {

        if(empty($fbUserModel->uid) || empty($fbUserModel->provider)){
            return false;
        }
        //сначала проверяем, существует ли такой пользователь в БД
        $criteria=new CDbCriteria;
        $criteria->condition = 'identity=:identity AND provider=:provider';
        $criteria->params = array(
            ':identity'=>$fbUserModel->uid,
            ':provider'=>$fbUserModel->provider
        );
        $user = User::model()->find($criteria);
        if(!is_null($user)){
            $this->isAuthenticated = true;
            $user->setLastvisit(time());
            $user->save();
            //используем существующего пользователя
            $this->id = $user->id;
            $this->name = (null != $user->full_name) ? $user->full_name : $user->identity;
            return true;
        }
        else {
            //создаем нового
            $user = new User();
            $user->setScenario('fbUserCreate');
            $user->identity = $fbUserModel->uid;

            if(!is_null($fbUserModel->email)){
                $user->email = $fbUserModel->email;
            }
            if(!is_null($fbUserModel->invitecode)){
                $user->invitecode = $fbUserModel->invitecode;
            }

            $user->provider = $fbUserModel->provider;

            $user->access_token = $fbUserModel->accessToken;
            $user->access_token_expires = $fbUserModel->accessTokenExpires;

            $user->full_name = $fbUserModel->first_name." ".$fbUserModel->last_name;
            $username = 'fb_'.$fbUserModel->uid;

            if(is_null(User::model()->find(':username=username', array(':username'=>$username)))){
                $user->username = $username;
            }
            else{
                $user->username = User::generateRandomUniqueUserName("fb_");
            }

            $password = Yii::app()->getSecurityManager()->generateRandomString(15);
            $user->activkey=UserModule::encrypting(microtime().$password);
            $user->password=UserModule::encrypting($password);
            $user->superuser=0;
            $user->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);

            if($user->save()){
                $this->isAuthenticated = true;
                $profile = new Profile('fbCreate');
                if(!is_null($fbUserModel->email)){
                    $profile->email = $fbUserModel->email;
                }
                $profile->user_id = $user->id;
                $profile->first_name = $fbUserModel->first_name;
                $profile->last_name = $fbUserModel->last_name;
                $profile->facebook = $fbUserModel->link;
                //@todo сделать свойство fb_avatar
                $profile->fb_avatar = $fbUserModel->photo;
                //var_dump($profile->fb_avatar);

                if($profile->validate()){
                    $profile->save();
                }
                Yii::app()->authManager->assign("Authenticated", $user->id);
                $this->id = $user->id;
                $this->name = (null != $user->full_name) ? $user->full_name : $user->identity;
                return true;
            }
            else{
                $this->isAuthenticated = false;
                return false;
            }
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getIsAuthenticated() {
        return $this->isAuthenticated;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * return User
     */
    public function getUser(){
        return $this->user;
    }

    public function getPersistentStates() {
        return $this->states;
    }
}