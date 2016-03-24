<?php

class MyController extends BackendController{

    /*public function actionSetUrlSegmentsToCategories(){
        Yii::import('application.modules.deals.models.*');
        $categories = DealsCategories::model()->findAll();
        foreach($categories as $category){
            $category->url_segment = CyrillicUrlTranslateBehavior::cyrillicToLatin($category->name);
            $category->save();
        }
    }*/

    /*public function actionClearAssets(){

    }
    public function actionClearCache(){

    }*/
    public function actionClearDbCache(){
        // Load all tables of the application in the schema
        Yii::app()->db->schema->getTables();
        // clear the cache of all loaded tables
        $refresh = Yii::app()->db->schema->refresh();
        Config::var_dump($refresh);

    }

    /*public function actionTestGeoip(){

        // IP-�����, ������� ����� ���������
        $ip = Yii::app()->request->getUserHostAddress();

        // ����������� IP � �����
        $int = sprintf("%u", ip2long($ip));

        $criteria = new CDbCriteria();
        $criteria->condition = "begin_ip<=:ip AND end_ip>=:ip";
        $criteria->params = array(
            ":ip" => $int
        );
        $ipCity= NetCityIp::model()->find($criteria);
        if(!is_null($ipCity)){
            $city = NetCity::model()->findByPk($ipCity->city_id);
            $country = NetCountry::model()->findByPk($city->country_id);
            echo "Your IP - ".$ip."<br>";
            echo "Your city - ".$city->name_en."<br>";
            echo "Your country  - ".$country->name_en."<br>";
        }
        else{
            echo "Your city not found";
        }

    }*/

    /*public function actionCreateLinksPreviews(){
        $links = DealLinks::model()->findAll();
        foreach($links as $link){
            if($link->link_type == "vimeo" && (strlen($link->thumb) == 0)){
                $url = $link->link;
                $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
                $videoId = (int)$urlParts[count($urlParts)-1];
                $link->link = "https://player.vimeo.com/video/".$videoId;
            }
            $link->save();
            echo "Link ".$link->link." was updated successfully!<br>";
        }
    }*/

    /*public function actionGenerateInviteKeys(){
        foreach(User::model()->findAll() as $user){
            if(strlen(trim($user->invitekey)) == 0){
                $user->invitekey = User::generateRandomUniqueUserName();
                $user->setScenario('generateInviteKey');
                if(!$user->save()){
                    Config::var_dump("User ID".$user->id);
                    Config::var_dump($user->getErrors());
                }
                else{
                    Config::var_dump('Invite key for user (ID-'.$user->id.") was generated successfully");

                }
            }
        }
    }*/

    /*public function actionReplaceNonFormattedPhones(){
        $profiles = Profile::model()->findAll();
        foreach($profiles as $profile){
            if(!is_null($profile->phone)){
                $oldPhone = $profile->phone;
                $profile->phone = preg_replace("/[^0-9]/", "", $profile->phone);
                $profile->save();
                echo "Phone ".$oldPhone." was replaced to ".$profile->phone."</br>";
            }
        }
    }*/

    /*public function actionCreateBannersPrices(){
        $price = 20;
        foreach(Cities::model()->findAll() as $city){
            foreach(DealsCategories::model()->findAll() as $category){
                $model = BannersPrices::model()->findByAttributes(array('city_id' => $city->id, 'category_id' => $category->id));
                if(is_null($model)){
                    $model = new BannersPrices();
                    $model->city_id = $city->id;
                    $model->category_id = $category->id;
                    $model->price = $price;
                    if($model->save()){
                        echo 'Banner price for city - '.$city->name.", category - ".$category->name." was created successfully! Amount - ".$price."<br>";
                    }
                    else{
                        echo 'When creating Banner price for city - '.$city->name.", category - ".$category->name." error occurred! Amount - ".$price."<br>";
                    }
                }
                else{
                    echo 'Banner price for city - '.$city->name.", category - ".$category->name." already exists!<br>";
                }
            }
        }
    }*/

    /*public function actionAddCalendarToOldDeals(){
        $calendarParam = DealsParams::model()->findByAttributes(array('name' => 'calendar'));
        $categoriesParams = DealsCategoriesParams::model()->findAllByAttributes(array('deal_param_id'=>$calendarParam->id));
        foreach($categoriesParams as $categoryParam){
            foreach($categoryParam->dealCategory->deals as $deal){


                $model = DealsParamsValues::model()->findByAttributes(array('deal_id'=>$deal->id, 'param_id' => $calendarParam->id));
                if(is_null($model)){
                    $model = new DealsParamsValues();
                    $model->deal_id = $deal->id;
                    $model->param_id = $calendarParam->id;
                    $model->value = 1;
                    $model->save();
                    Config::var_dump('calendar was added to deal '.$deal->name);

                }
            }
        }

    }*/

    /*public function actionClearDealsDescription(){
        $deals = Deals::model()->findAll();

        echo sizeof($deals)."<br>";
        foreach ($deals as $deal){
            $p = new CHtmlPurifier();
            $p->options = array(
                'HTML.AllowedElements' => Yii::app()->config->get('DEALS_MODULE.DESCRIPTION_ALLOWED_TAGS'),
                'HTML.AllowedAttributes' => '*.class'

            );
            $deal->description = $p->purify($deal->description);
            echo $deal->id."<br>";
            //echo $deal->validate()."<br>";
            $deal->setScenario("clearDealDescription");


            if($deal->save(false)){
                echo $deal->name." was saved successfully!<br>";
            }
            else{
                Config::var_dump($deal->getErrors());

                echo "When save deal ".$deal->name." error occurred!<br>";
            }
        }
    }*/
}
