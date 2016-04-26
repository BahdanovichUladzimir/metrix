<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MainController extends RController
{
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $keywords;
    /**
     * @var string
     */
    public $h1;

    /**
     * @var string
     */
    public $seoText;

    /**
     * @var int
     */
    public $userCityId;
    /**
     * @var string
     */
    public $userCityKey;
    /**
     * @var int
     */
    public $userCurrencyId;

    public $translation;

    public $randSort;

    public $geoipCity = NULL;

    public $geoipCountry = NULL;

    public $userIp = NULL;

    public $currentCategory = NULL;

    public $pageClass = '';

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /**
     *
     */
    public function init(){
        parent::init();
        Yii::app()->setLanguage('ru');
        if(Yii::app()->getRequest()->getQuery('city')){
            $model = Cities::model()->findByAttributes(array('key' => Yii::app()->getRequest()->getQuery('city')));
            if(!is_null($model)){
                $this->userCityId = $model->id;
            }
            else{
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }else{
            if(is_null(Yii::app()->request->cookies['cityId'])){
                $this->userCityId = $this->getDefaultCityId();
            }
            else{
                $this->userCityId = Yii::app()->request->cookies['cityId']->value;
            }
        }
        $this->userCityKey = Cities::model()->findByPk((int)$this->userCityId)->key;
        Yii::app()->request->cookies['cityId'] = new CHttpCookie('cityId', $this->userCityId);
        Yii::app()->request->cookies['cityKey'] = new CHttpCookie("cityKey", $this->userCityKey);


        if (is_null(Yii::app()->request->cookies['randSort'])){
            $this->randSort = strval(rand(1,100));
            $cookie = new CHttpCookie('randSort', $this->randSort);
            $cookie->expire = time()+60*15;
            Yii::app()->request->cookies['randSort'] = $cookie;
        }
        else{
            $this->randSort = Yii::app()->request->cookies['randSort']->value;
        }


        if (is_null(Yii::app()->request->cookies['lastVisit'])){
            $cookie = new CHttpCookie('lastVisit', time());
            $cookie->expire = time()+60*5;
            Yii::app()->request->cookies['lastVisit'] = $cookie;
            $userId = Yii::app()->user->getId();
            $userIp = Yii::app()->request->userHostAddress;
            if(!is_null($userId)){
                $ipExists = UsersIps::model()->find('user_id=:user_id AND ip=:ip', array(':user_id'=>$userId,'ip' => $userIp));
                if(sizeof($ipExists) == 0){
                    $model = new UsersIps();
                    $model->user_id = $userId;
                    $model->ip = $userIp;
                    if($model->save()){
                        $dbUser = User::model()->findByPk($userId);
                        if(!is_null($dbUser)){
                            $dbUser->setLastvisit(time());
                        }
                    };
                }
            }
        }

        if (Yii::app()->request->cookies['currencyId'] === null){
            $defaultCurrencyId = Yii::app()->config->get('ADMIN_MODULE.DEFAULT_CURRENCY_ID');
            $userCountryCurrencyId = Cities::model()->findByPk((int)Yii::app()->request->cookies['cityId']->value)->country->currency_id;
            $this->userCurrencyId = (int)(!is_null($userCountryCurrencyId)) ? new CHttpCookie('currencyId', $userCountryCurrencyId) : new CHttpCookie('currencyId', $defaultCurrencyId);
            Yii::app()->request->cookies['currencyId'] = $this->userCurrencyId;
        }
        else{
            $this->userCurrencyId = (int)Yii::app()->request->cookies['currencyId']->value;
        }
        // тут только обновляем, создаём при добавлении в избранное

        if (!is_null(Yii::app()->request->cookies['favoritesId'])){
            $cookie = Yii::app()->request->cookies['favoritesId'];
            $expire = time()+Yii::app()->config->get('DEALS_MODULE.FAVORITES_COOKIE_DB_EXPIRE');
            FavoritesCookies::model()->updateByPk($cookie->value, array('expire' => $expire));
        }
        else{
            $securityManager = new CSecurityManager();
            $cookieId = $securityManager->generateRandomString(24);
            // @todo сделать проверку на уникальность куки в базе и на уникальность cookieId строки
            $cookie = new CHttpCookie('favoritesId', $cookieId);
            $userExpire = time()+Yii::app()->config->get('DEALS_MODULE.FAVORITES_COOKIE_USER_EXPIRE');
            $dbExpire = time()+Yii::app()->config->get('DEALS_MODULE.FAVORITES_COOKIE_DB_EXPIRE');
            $cookie->expire = $userExpire;
            $model = new FavoritesCookies();
            $model->id = $cookieId;
            $model->expire = $dbExpire;
            $model->save();
            Yii::app()->request->cookies['favoritesId'] = $cookie;
        }

        $this->translation = MessageSource::getCurrentLanguageTranslation(Yii::app()->getLanguage());
    }

    /**
     * @return array
     */
    public function filters()
    {
        return array(
            array('application.filters.BackendAccessFilter'),
        );
    }

    public function getDefaultCityId(){
        // IP-адрес, который нужно проверить
        $this->userIp = Yii::app()->request->getUserHostAddress();

        // Преобразуем IP в число
        $int = sprintf("%u", ip2long($this->userIp));

        $criteria = new CDbCriteria();
        $criteria->condition = "begin_ip<=:ip AND end_ip>=:ip";
        $criteria->params = array(
            ":ip" => $int
        );
        $ipCity= GeoipCitiesIps::model()->find($criteria);


        if(!is_null($ipCity)){
            $this->geoipCity = GeoipCities::model()->findByPk($ipCity->city_id);
            if(!is_null($this->geoipCity)){
                //$this->geoipCountry = GeoipCountries::model()->findByPk($this->geoipCity->country_id);
                $citiesGeoipCitiesModel = CitiesGeoipCities::model()->findByAttributes(array('geoip_city_id' => $this->geoipCity->id));
                if(!is_null($citiesGeoipCitiesModel)){
                    $dbCity = Cities::model()->findByPk($citiesGeoipCitiesModel->city_id);

                    if(!is_null($dbCity)){
                        return $dbCity->id;
                    }
                }
            }
        }
        return Yii::app()->config->get('ADMIN_MODULE.DEFAULT_CITY_ID');
    }

}