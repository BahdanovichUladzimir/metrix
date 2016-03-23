<?php
/**
* Rights web user class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class RWebUser extends CWebUser
{
	/**
	* Actions to be taken after logging in.
	* Overloads the parent method in order to mark superusers.
	* @param boolean $fromCookie whether the login is based on cookie.
	*/
	public function afterLogin($fromCookie)
	{
		parent::afterLogin($fromCookie);

        if(!is_null(Yii::app()->request->cookies['favoritesId'])){
            $userId = $this->getId();
            $cookieId = Yii::app()->request->cookies['favoritesId']->value;
            $cookiesDeals = CookiesFavorites::model()->findAll("cookie_id=:cookieId", array(':cookieId' => $cookieId));
            if(sizeof($cookiesDeals)>0){
                foreach($cookiesDeals as $cookieDeal){
                    $existDeal = UsersFavorites::model()->find("user_id=:user_id AND deal_id=:deal_id", array(':user_id' => $userId, 'deal_id' => $cookieDeal->deal_id));
                    if(is_null($existDeal)){
                        $userDeal = new UsersFavorites();
                        $userDeal->user_id = $userId;
                        $userDeal->deal_id = $cookieDeal->deal_id;
                        $userDeal->save();
                    }
                    $cookieDeal->delete();
                }
            }
        }
		// Mark the user as a superuser if necessary.
		if( Rights::getAuthorizer()->isSuperuser($this->getId())===true ){
            $this->isSuperuser = true;
        }
	}

	/**
	* Performs access check for this user.
	* Overloads the parent method in order to allow superusers access implicitly.
	* @param string $operation the name of the operation that need access check.
	* @param array $params name-value pairs that would be passed to business rules associated
	* with the tasks and roles assigned to the user.
	* @param boolean $allowCaching whether to allow caching the result of access checki.
	* This parameter has been available since version 1.0.5. When this parameter
	* is true (default), if the access check of an operation was performed before,
	* its result will be directly returned when calling this method to check the same operation.
	* If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
	* to obtain the up-to-date access result. Note that this caching is effective
	* only within the same request.
	* @return boolean whether the operations can be performed by this user.
	*/
	public function checkAccess($operation, $params=array(), $allowCaching=true)
	{
		// Allow superusers access implicitly and do CWebUser::checkAccess for others.
		return $this->getId()==1 ? true : parent::checkAccess($operation, $params, $allowCaching);
	}

	/**
	* @param boolean $value whether the user is a superuser.
	*/
	public function setIsSuperuser($value)
	{
		$this->setState('Rights_isSuperuser', $value);
	}

	/**
	* @return boolean whether the user is a superuser.
	*/
	public function getIsSuperuser()
	{
		return $this->getState('Rights_isSuperuser');
	}
	
	/**
	 * @param array $value return url.
	 */
	public function setRightsReturnUrl($value)
	{
		$this->setState('Rights_returnUrl', $value);
	}
	
	/**
	 * Returns the URL that the user should be redirected to 
	 * after updating an authorization item.
	 * @param string $defaultUrl the default return URL in case it was not set previously. If this is null,
	 * the application entry URL will be considered as the default return URL.
	 * @return string the URL that the user should be redirected to 
	 * after updating an authorization item.
	 */
	public function getRightsReturnUrl($defaultUrl=null)
	{
		if( ($returnUrl = $this->getState('Rights_returnUrl'))!==null )
			$this->returnUrl = null;
		
		return $returnUrl!==null ? CHtml::normalizeUrl($returnUrl) : CHtml::normalizeUrl($defaultUrl);
	}

    public function getIsCanSetRating(){
        if(Yii::app()->user->isGuest){
            return false;
        }
        $userDealsCount = Deals::model()->countBySql("SELECT COUNT(`id`) FROM `Deals` WHERE user_id=:user_id", array(":user_id" => $this->getId()));
        return $userDealsCount == 0;
    }

    public function getIsCanAddComment($deal_id){
        if(Yii::app()->user->isGuest){
            return false;
        }
        $userDealsCount = Deals::model()->countBySql("SELECT COUNT(`id`) FROM `Deals` WHERE user_id=:user_id", array(":user_id" => $this->getId()));
        if($userDealsCount == 0){
            return true;
        }else{
            $isUserDeal = Deals::model()->countBySql("SELECT COUNT(`id`) FROM `Deals` WHERE id=:id AND user_id=:user_id", array(":user_id" => $this->getId(), ':id' => $deal_id));
            return $isUserDeal == 1;
        }
    }

    public function updateSession() {
        $user = Yii::app()->getModule('user')->user($this->id);
        $userAttributes = CMap::mergeArray(array(
            'email'=>$user->email,
            'username'=>$user->username,
            'create_at'=>$user->create_at,
            'lastvisit_at'=>$user->lastvisit_at,
        ),$user->profile->getAttributes());
        foreach ($userAttributes as $attrName=>$attrValue) {
            $this->setState($attrName,$attrValue);
        }
    }

    public function getNewMessagesCount(){
        $sql = "
        SELECT (t1.sum_1+t2.sum_2) AS `messages_count` FROM (
            (SELECT IFNULL(SUM(`sender_new_messages`),0) AS sum_1 FROM `Dialogues` WHERE `sender_id`=".$this->getId().") as t1,
            (SELECT IFNULL(SUM(`receiver_new_messages`),0) AS sum_2 FROM `Dialogues` WHERE `receiver_id`=".$this->getId().") as t2
	    );
        ";
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $row=$command->queryRow();
        return (int)$row['messages_count'];
    }
}
