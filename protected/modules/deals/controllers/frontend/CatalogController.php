<?php

class CatalogController extends FrontendController
{
    /**
     * @param null|string $urlSegment
     * @throws CHttpException
     */
    public function actionIndex($urlSegment = NULL){
        $criteria = new CDbCriteria();
        if(!is_null($urlSegment)){
            if(isset($_GET['Deals']['filter']['category']) && $_GET['Deals']['filter']['category']>0){
                $criteria->condition = "id=:id";
                $criteria->params = array(':id' => (int)$_GET['Deals']['filter']['category']);
                $category = DealsCategories::model()->find($criteria);

                if($urlSegment !== $category->url_segment){
                    $this->redirect(Yii::app()->createUrl(
                        '/deals/frontend/catalog/index/',
                        array(
                            'urlSegment' => $category->url_segment,
                            'city' => $this->userCityKey,
                            'Deals' => $_GET['Deals']
                            )
                        )
                    );
                }

            }
            else{
                $criteria->condition = "url_segment=:url_segment AND :status_id=status_id";
                $criteria->params = array(':url_segment' => CHtml::encode($urlSegment), ':status_id' => 1);
                $category = DealsCategories::model()->find($criteria);
            }
            if(is_null($category)){
               throw new CHttpException(404);
            }

            unset($criteria);

            $categoriesIds = DealsCategories::getCategoryChildrenIdsRecursively($category->id);
            array_push($categoriesIds,$category->id);
            // SEO
            $currentCity = Cities::model()->findByAttributes(array('key' => $this->userCityKey));
            $criteria = new CDbCriteria();
            $criteria->condition = ':city_id=city_id AND :language=language AND :category_id=category_id';
            $criteria->params = array(
                ':city_id' => $currentCity->id,
                ':language' => Yii::app()->language,
                ':category_id' => $category->id
            );
            $seoRule = DealsCategoriesSeo::model()->find($criteria);
            if(!is_null($seoRule)){
                $this->title = $seoRule->title;
                $this->description = $seoRule->description;
                $this->h1 = $seoRule->h1;
                $this->keywords = $seoRule->keywords;
                $this->seoText = $seoRule->seotext;
            }
            else{
                $this->title = $category->name.' '.$currentCity->seo_title;
                $this->h1 = $this->title;
            }

            Deals::$userCurrencyId = $this->userCurrencyId;
            Deals::$userCityId = $this->userCityId;
            $model=new Deals('search');
            $model->unsetAttributes();  // clear any default values
            $model->categoriesSearch = $categoriesIds;
            $model->city = $currentCity->key;
            $model->approve = 1;
            $model->archive = 0;
            $model->status_id = 1;
            if(isset($_GET['Deals']['filter'])){
                $model->filter=$_GET['Deals']['filter'];
            }
            if($category->hasParent()){
                $this->breadcrumbs=array(
                    $currentCity->name => Yii::app()->createUrl('/'.$this->userCityKey)
                    //$category->getParent()->name => $category->getParent()->getPublicUrl($this->userCityKey),
                    //$category->name
                );
                $this->breadcrumbs = $this->breadcrumbs+$category->getBreadcrumbs(false,$this->userCityKey);
            }
            else{
                $this->breadcrumbs=array(
                    $currentCity->name => Yii::app()->createUrl('/'.$this->userCityKey),
                    $category->name
                );
            }

            if(!is_null($this->randSort)){
                $model->randSort = $this->randSort;
            }
            $isShowSeoText = true;
            if(isset($_GET['Deals_page'])){
                $isShowSeoText = false;
            }
            $this->currentCategory = $category->id;
            Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-cookie/src/jquery.cookie.js');

            $geoObjects = array();
            if($category->hasCoordinatesParam()){
                $paramId = DealsParams::model()->findByAttributes(array('type_id' => DealsParamsTypes::model()->findByAttributes(array('name' => 'coordinates_widget'))->id))->id;
                foreach ($model->mapSearch($paramId)->getData() as $deal){
                    /**
                     * @var Deals $deal
                     */
                    $geoObj = array(
                        'lat' => explode(':',$deal->coordinates)[1],
                        'lon' => explode(':',$deal->coordinates)[0],
                        'properties' => array(
                            'hintContent'=> "<strong class='map-obj-hint'>".$deal->name."</strong>",
                            'clusterCaption'=> $deal->name,
                            //'balloonContentHeader' => '<h5 class="balloon-title">'.$deal->name.'</h5>',
                            'balloonContent' => $this->renderPartial('_mapDeal', array('deal' => $deal), true),
                            //'balloonContentFooter' => CHtml::link(Yii::t('dealsModule',"More..."),$deal->getPublicUrl(), array('target' => '_blank','class' => 'balloon-read-more-link')),
                        ),
                        'options' => array(
                            'draggable' => false,
                        )
                    );
                    array_push($geoObjects, $geoObj);
                }
            }

            $this->render(
                'category',
                array(
                    'dataProvider' => $model->search($category->page_count),
                    'model' => $model,
                    'category' => $category,
                    'isShowSeoText' => $isShowSeoText,
                    'geoObjects' => $geoObjects
                )
            );

        }
        else{
            $rootCategoriesIds = DealsCategories::getRootCategoriesIds(false,false);
            //Config::var_dump($rootCategoriesIds, true);
            $categories = DealsCategories::getCategoriesChildren($rootCategoriesIds);
            $this->render(
                'index',
                array(
                    'categories' => $categories,
                )
            );
        }
    }

    /**
     * @param int|null $id
     * @throws CHttpException
     */
    public function actionDeal($id){
        $criteria = new CDbCriteria();
        $userId = Yii::app()->user->getId();
        $criteria->with = array(
            'dealsImages',
            'dealsVideos',
            'dealLinks',
            /*'frontendDealsImages',
            'frontendDealsVideos',
            'frontendDealLinks'*/
        );

        /*$criteria->with = array(
            'dealsImages' => array(
                'on' => 'dealsImages.deal_id=t.id AND dealsImages.approve=1',
            ),
            'dealsVideos' => array(
                'on' => 'dealsVideos.deal_id=t.id AND dealsVideos.approve=1',
            ),
        );*/
        $criteria->condition = 't.id='.$id;
        /*$criteria->params = array(
            ':id'=>$id,
        );*/
        //$model = Deals::model()->find($criteria);
        $model = $this->loadDeal($id);
        $this->currentCategory = $model->categories[0]->id;
        if(is_null($model)){
            throw new CHttpException(404, Yii::t('core','Page not found.'));
        }
        if(($model->approve == 0 || $model->status_id == 2 || $model->exceeding_category_limit_hidden == '1')&& $userId !== $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(404, Yii::t('core','Page not found.'));
        }

        if(Yii::app()->request->requestUri != $model->getPublicUrl()) {
            $this->redirect($model->getPublicUrl());
        }
        $category = $model->getFirstCategory();
        $currentCity = Cities::model()->findByAttributes(array('key' => $this->userCityKey));
        $this->breadcrumbs=array(
            $currentCity->name => Yii::app()->createUrl('/'.$this->userCityKey),
        );

        $this->breadcrumbs = $this->breadcrumbs+$category->getBreadcrumbs(true,$this->userCityKey);

        $this->breadcrumbs[] = $model->name;
        $paramsModel = $this->loadParamsModel($model);
        $model->setStatistics();

        $this->title = $model->getMetaTitle();
        $this->description = $model->getMetaDescription();
        $this->h1 = $model->getSeoH1();
        $this->keywords = $model->getMetaKeyWords();
        $this->seoText = $model->getSeoText();

        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');

        $this->render(
            'deal',
            array(
                'deal' => $model,
                'paramsModel' => $paramsModel
            )
        );
    }

    public function actionSetDealRating(){
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST) && isset($_POST['deal_id']) && isset($_POST['ratings']) && sizeof($_POST['ratings'])>0){
                if(Yii::app()->user->getIsCanSetRating()){
                    $user_id = Yii::app()->user->getId();
                    $transaction = Yii::app()->db->beginTransaction();
                    foreach($_POST['ratings'] as $rating){
                        $criteria = new CDbCriteria();
                        $criteria->condition = 'user_id=:user_id AND deal_id=:deal_id AND rating_id=:rating_id';
                        $criteria->params = array(
                            ':user_id' => $user_id,
                            ':deal_id' => (int)$_POST['deal_id'],
                            ':rating_id' => (int)$rating['id']
                        );
                        $model = UsersRatingsValues::model()->find($criteria);
                        if(is_null($model)){
                            $model = new UsersRatingsValues();
                        }
                        $model->deal_id = (int)$_POST['deal_id'];
                        $model->rating_id = (int)$rating['id'];
                        $model->value = (int)$rating['value'];
                        $model->user_id = $user_id;
                        $model->note = (isset($_POST['note'])) ? $_POST['note'] : "";
                        if(!$model->save()){
                            $transaction->rollback();
                            $message = '';

                            foreach($model->getErrors() as $attribute=>$error){
                                $message.=$error[0];
                                $message.=" ";
                            }

                            echo json_encode(
                                array(
                                    'status' => 'error',
                                    'message' => $message
                                )
                            );
                            Yii::app()->end();
                        }
                    }
                    $transaction->commit();
                    echo json_encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule',"Rating was sent successfully")
                        )
                    );
                }

            }
        }
    }

    public function actionGetTotalDealRating($deal_id){
        if (Yii::app()->request->isAjaxRequest) {
            $deal = Deals::model()->findByPk($deal_id);
            $currentRatingsIds = array();
            $currentRatings = array();
            foreach ($deal->categories as $category) {
                foreach ($category->ratings as $rating) {
                    if (!in_array((int)$rating->id, $currentRatingsIds)) {
                        $currentRatings[] = $rating;
                        $currentRatingsIds[] = $rating->id;
                    }
                }
            }

            // Получаем общий рейтинг товара
            $criteria = new CDbCriteria();
            $criteria->select = 'SUM(value) AS ratingsTotal, COUNT(*) as ratingsCount, rating_id, value';
            $criteria->condition = ':deal_id=deal_id';
            $criteria->params = array(':deal_id' => $deal->id);
            $criteria->addInCondition('rating_id', $currentRatingsIds);
            $currentRatingsTotal = UsersRatingsValues::model()->find($criteria);
            $currentTotalRating = $currentRatingsTotal->ratingsTotal / $currentRatingsTotal->ratingsCount;
            echo round($currentTotalRating);
        }
    }

    public function actionProofOfAge(){
        $this->renderPartial(
            'proof_of_age'
        );
    }

    public function actionCalendar($deal_id){
        $events = Calendar::model()->findAllByAttributes(array("deal_id" => $deal_id));
        $eventsArray = array();
        foreach ($events as $event) {
            $eventsArray[] = array(
                "id"=> $event->id,
                "title"=> $event->title,
                "url"=> $event->url,
                "class"=> "event-warning",
                "start"=> round($event->start*1000),
                "end"=> round($event->end*1000),
                "description"=> $event->description,
            );
        }
        echo CJSON::encode(
            array(
                'success' => '1',
                'result' => $eventsArray
            )
        );
    }
    
    /**
     * @param $id
     * @return DealsCategories
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealsCategories::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @param $id
     * @return Deals
     * @throws CHttpException
     */
    public function loadDeal($id){
        $model=Deals::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @param int|Deals $deal
     *
     * @return DealCategoriesParams|null
     * @throws CHttpException
     */
    public function loadParamsModel($deal){
        if($deal instanceof Deals){
            $model = new DealCategoriesParams('update',$deal);
        }
        elseif(is_int($deal)){
            $dealObj = Deals::model()->findByPk($deal);
            $model = new DealCategoriesParams('update',$dealObj);
        }
        else{
            $model = NULL;
        }
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    public static function createCategoryBreadcrumbsRecursively($categoryId = 0, $userCityKey = 'msk', $isLastItemIsLink = false){
        $category = DealsCategories::model()->findByPk($categoryId);
        $breadcrumbs = array();
        if($category->hasParent()){
            $breadcrumbs = array_merge($breadcrumbs,self::createCategoryBreadcrumbsRecursively($category->getParent()->id,$userCityKey));
        }
        if($isLastItemIsLink){
            $breadcrumbs[$category->name] = $category->getPublicUrl($userCityKey);
        }
        else{
            $breadcrumbs[] = $category->name;
        }

        return $breadcrumbs;
    }

    public function actionShowPhone(){
        if(isset($_POST['deal_id']) && isset($_POST['param_name'])){
            $deal = Deals::model()->findByPk((int)$_POST['deal_id']);
            $phone = NULL;
            foreach($deal->dealsParamsValues as $paramValue){
                if($paramValue->param->name == $_POST['param_name']){
                    $phone = $paramValue->value;
                    break;
                }
            }

            if(!is_null($phone)){
                $publicPhone = DealCategoriesParams::getPublicPhoneNumber($phone);
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'status'=>"success",
                        'phone'=>$publicPhone,
                        'message'=>Yii::t("dealsModule","Phone was find successfully."),
                    ));
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'status'=>"error",
                        'message'=>Yii::t("dealsModule","Phone not found."),
                    ));
                }
            }

        }
    }

    public function actionGetDealContacts($deal_id){
        $model = Deals::model()->findByPk($deal_id);
        $model->contacts_shows = $model->contacts_shows+1;
        $model->setScenario('showContacts');
        $model->save();
        $phones = array();
        foreach($model->params as $param){
            if($param->type->name == 'phone'){
                $phones[] = array(
                    'param' => $param,
                    'paramValue' => DealsParamsValues::model()->findByAttributes(array('param_id' => $param->id, 'deal_id' => $deal_id))
                );
            }
        }
        $this->renderPartial('dealContacts',array(
            'deal' => $model,
            'phones' => $phones
        ));
    }
    public function actionSetContactsQuality(){
        if(isset($_POST) && isset($_POST['deal_id'])){
            if(isset($_POST['quality'])){
                $model = new DealsContactsQuality();
                $model->deal_id = $_POST['deal_id'];
                $model->quality = $_POST['quality'];
                if($model->save()){
                    echo CJSON::encode(array(
                        'status'=>"success",
                        'message'=>Yii::t("dealsModule","Quality was saved successfully."),
                    ));
                }
                else{
                    echo CJSON::encode(array(
                        'status'=>"error",
                        'message'=>Yii::t("dealsModule","When save quality error occurred."),
                    ));

                }
            }
            else{
                echo CJSON::encode(array(
                    'status'=>"error",
                    'message'=>Yii::t("dealsModule","Not specified quality."),
                ));
            }
        }
    }

    /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
    protected function performAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-categories-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
