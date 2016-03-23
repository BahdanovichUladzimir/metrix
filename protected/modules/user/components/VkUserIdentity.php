<?php
/**
 * Этот класс выполняет аутентификацию и, при необходимости, регистрацию посетителя.
 */
class VkUserIdentity implements IUserIdentity {

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
     * @param VkUserModel $vkUserModel модель, содержащая данные от сервиса Loginza
     * @return boolean true если пользователь найден или создан новый аккаунт, false - если недостаточно данных
     */
    public function authenticate($vkUserModel = null) {

        if(empty($vkUserModel->uid) || empty($vkUserModel->provider)){
            return false;
        }
        //сначала проверяем, существует ли такой пользователь в БД
        $criteria=new CDbCriteria;
        $criteria->condition = 'identity=:identity AND provider=:provider';
        $criteria->params = array(
            ':identity'=>$vkUserModel->uid,
            ':provider'=>$vkUserModel->provider
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
            $user->setScenario('vkUserCreate');
            $user->identity = $vkUserModel->uid;

            if(!is_null($vkUserModel->email)){
                $user->email = $vkUserModel->email;
            }
            if(!is_null($vkUserModel->invitecode)){
                Config::var_dump($vkUserModel->invitecode);

                $user->invitecode = $vkUserModel->invitecode;
            }

            $user->provider = $vkUserModel->provider;

            $user->access_token = $vkUserModel->accessToken;
            $user->access_token_expires = $vkUserModel->accessTokenExpires;

            $user->full_name = $vkUserModel->first_name." ".$vkUserModel->last_name;
            $username = 'vk_'.$vkUserModel->uid;

            if(is_null(User::model()->find(':username=username', array(':username'=>$username)))){
                $user->username = $username;
            }
            else{
                $user->username = User::generateRandomUniqueUserName("vk_");
            }

            $password = Yii::app()->getSecurityManager()->generateRandomString(15);
            $user->activkey=UserModule::encrypting(microtime().$password);
            $user->password=UserModule::encrypting($password);
            $user->superuser=0;
            $user->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);

            if($user->save()){
                $this->isAuthenticated = true;
                $profile = new Profile('vkCreate');
                if(!is_null($vkUserModel->email)){
                    $profile->email = $vkUserModel->email;
                }
                $profile->user_id = $user->id;
                $profile->first_name = $vkUserModel->first_name;
                $profile->last_name = $vkUserModel->last_name;
                $profile->vk = "https://vk.com/id".$vkUserModel->uid;
                $profile->vk_avatar = $vkUserModel->photo;
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