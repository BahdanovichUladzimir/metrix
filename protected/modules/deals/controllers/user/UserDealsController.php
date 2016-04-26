<?php

/**
 * Class DealsController
 */
class UserDealsController extends UserFrontendController
{

    public function getDeal(){
        if(isset($this->actionParams['id'])){
            return $this->loadModel($this->actionParams['id']);
        }
        elseif(isset($this->actionParams['deal_id'])){
            return $this->loadModel($this->actionParams['deal_id']);
        }
        else{
            return NULL;
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @throws CHttpException
     * @throws CException
     */
    /*public function actionView($id){

        if(Yii::app()->user->getId() != $this->deal->user_id && !Yii::app()->getModule('user')->isAdmin()){
            throw new CHttpException(403,'Access denied!');
        }
        // рендерим сначала блок статистики, потом блок товара, view из фронтенда
        // render блока статистики, а в него render_partial обычную вьюху с фронтенда
        Yii::import('xupload.models.XUploadForm');
        $imagesModel = new XUploadForm();
        $model = $this->loadModel($id);
        $linksDataProvider = DealLinks::model()->dealSearch($model->id);
        $this->render(
            'view',
            array(
                'model'=>$model,
                'approveList' => Deals::getApproveListData(),
                'imagesModel' => $imagesModel,
                'linksDataProvider' => $linksDataProvider,
                'linksModel' => new DealLinks()
            )
        );
    }*/

    public function actionPhoto($id){
        $model = $this->loadModel($id);
        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        Yii::import('xupload.models.XUploadForm');
        $imagesModel = new XUploadForm();
        $linksDataProvider = DealLinks::model()->dealSearch($model->id);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');
        $this->render(
            'photo',
            array(
                'model'=>$model,
                'approveList' => Deals::getApproveListData(),
                'imagesModel' => $imagesModel,
                'linksDataProvider' => $linksDataProvider,
                'linksModel' => new DealLinks()
            )
        );
    }

    public function actionVideo($id){
        $model = $this->loadModel($id);

        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        Yii::import('xupload.models.XUploadForm');
        $videosModel = new XUploadForm();
        $linksDataProvider = DealLinks::model()->dealSearch($model->id);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');
        $this->render(
            'video',
            array(
                'model'=>$model,
                'approveList' => Deals::getApproveListData(),
                'videosModel' => $videosModel,
                'linksDataProvider' => $linksDataProvider,
                'linksModel' => new DealLinks()
            )
        );
    }

    public function actionSocialMediaVideo($id){
        $model = $this->loadModel($id);
        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        Yii::import('xupload.models.XUploadForm');
        $linksDataProvider = DealLinks::model()->dealSearch($model->id);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');

        $this->render(
            'social_media_video',
            array(
                'model'=>$model,
                'approveList' => Deals::getApproveListData(),
                'linksDataProvider' => $linksDataProvider,
                'linksModel' => new DealLinks()
            )
        );
    }


    public function actionCreate(){
        if($this->user->agreement == '0'){
            $this->redirect(Yii::app()->createUrl('/user/agreement/agreement?returnUrl='.Yii::app()->request->requestUri));
        };

        Yii::import('xupload.models.XUploadForm');
        $model=new Deals('userCreate');
        $imagesModel = new XUploadForm();
        $paramsModel = $paramsModel=$this->loadParamsModel($model);
        $this->myPerformAjaxValidation($model);
        if(isset($_POST['Deals'])){
            $categoriesIds = array();
            if(isset($_POST['Deals']['categories']) && sizeof($_POST['Deals']['categories'])>0){
                $categories = DealsCategories::model()->findAllByPk($_POST['Deals']['categories']);
                if(sizeof($categories)>0){
                    foreach($categories as $category){
                        $criteria = new CDbCriteria();
                        $criteria->with='categories';
                        $criteria->condition = 't.user_id=:user_id AND categories.id=:category_id';
                        $criteria->params = array(
                            ':user_id' => $this->userId,
                            ':category_id' => $category->id
                        );
                        $userCategoryDealsCount = Deals::model()->count($criteria);
                        if($userCategoryDealsCount>=$category->free_deals_count){
                            $model->exceeding_category_limit_hidden = 1;
                            Yii::app()->user->setFlash(
                                'backendDealsError',
                                Yii::t(
                                    "dealsModule",
                                    'Exceeded limit deals for the category "{name}"! Turn paid impressions.',
                                    array('{name}' => $category->name)
                                )
                            );

                        }
                    }
                }
                $categoriesIds = $_POST['Deals']['categories'];
                unset($_POST['Deals']['categories']);
                $model->categories = $categories;
                $model->categoriesTree = DealsCategories::getParentsRecursively($model->categories[0]);
            }
            $model->attributes=$_POST['Deals'];
            $model->user_id = $this->userId;
            $paramsValid = true;
            if(isset($_POST['DealCategoriesParams'])){
                $dealCatsParams = $_POST['DealCategoriesParams'];

                // если параметр имееет тип phone(телефон). Вырезаем все ненужные символы
                foreach($dealCatsParams as $k=>$v){
                    $param = DealsParams::model()->findByAttributes(array('name' => $k));
                    if($param->type->name == 'phone'){
                        $dealCatsParams[$k] = preg_replace("/[^0-9]/", "", $v);
                    }
                }
                // получаем из виджета longitude И latitude если они пришли, и задаём параметр coordinates
                // удаляем из массива longitude и latitude
                if(isset($dealCatsParams['longitude']) || isset($dealCatsParams['latitude'])){
                    $coordinatesArr = array(
                        'longitude' => (isset($dealCatsParams['longitude'])) ? $dealCatsParams['longitude'] : "0",
                        'latitude' => (isset($dealCatsParams['latitude'])) ? $dealCatsParams['latitude'] : "0",
                    );
                    $coordinates = implode(":",$coordinatesArr);
                    $dealCatsParams['coordinates'] = $coordinates;
                    //unset($dealCatsParams['longitude']);
                    //unset($dealCatsParams['latitude']);
                }
                $paramsModel=new DealCategoriesParams('update',DealsCategories::model()->findAllByPk($categoriesIds),$model);
                $paramsModel->attributes = $dealCatsParams;
                $paramsValid = $paramsModel->validate();
            }

            if($model->validate() && $paramsValid){
                $transaction = Yii::app()->db->beginTransaction();
                if($saveWithRelated = $model->saveWithRelated(array('categories'))){

                    if(isset($dealCatsParams)){
                        $isParamSave = false;
                        $this->_clearParams($model);
                        foreach($dealCatsParams as $k => $v){
                            if($k == "latitude" || $k == "longitude"){
                                continue;
                            }
                            if(is_array($v)){
                                foreach($v as $value){
                                    $dealsParamsValuesModel = new DealsParamsValues;
                                    $dealsParamsValuesModel->deal_id = (int)$model->id;
                                    $param = DealsParams::model()->find('name=:name',array(':name' => $k));
                                    $dealsParamsValuesModel->param_id = $param->id;
                                    if($param->type->name == "phone"){
                                        $v=preg_replace("#[^0-9]#i","",$value);
                                    }
                                    $dealsParamsValuesModel->value = $value;
                                    if($dealsParamsValuesModel->validate()){
                                        if($dealsParamsValuesModel->save()){
                                            $isParamSave = true;
                                        }
                                        else{
                                            $isParamSave = false;
                                            break;
                                        }
                                    }
                                    else{
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When update deal "{name}" error occurred!', array('{name}' => $model->name)));
                                    }
                                }
                            }
                            else{
                                $dealsParamsValuesModel = new DealsParamsValues;
                                $dealsParamsValuesModel->deal_id = (int)$model->id;
                                $param = DealsParams::model()->find('name=:name',array(':name' => $k));
                                $dealsParamsValuesModel->param_id = $param->id;
                                if($param->type->name == "phone"){
                                    $v=preg_replace("#[^0-9]#i","",$v);
                                }
                                $dealsParamsValuesModel->value = $v;
                                if($dealsParamsValuesModel->validate()){
                                    if($dealsParamsValuesModel->save()){
                                        $isParamSave = true;
                                    }
                                    else{
                                        $isParamSave = false;
                                        break;
                                    }
                                }
                                else{
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When update deal "{name}" error occurred!', array('{name}' => $model->name)));
                                }

                            }
                        }
                        if($isParamSave){
                            $transaction->commit();
                            Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", 'Deal "{name}" was created successfully!', array('{name}' => $model->name)));
                            $this->redirect(array('photo','id'=>$model->id));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When create deal "{name}" error occurred!', array('{name}' => $model->name)));
                        }

                    }
                    else{
                        $this->_clearParams($model);
                        $transaction->commit();
                        Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", 'Deal "{name}" was created successfully!', array('{name}' => $model->name)));
                        $this->redirect(array('photo','id'=>$model->id));
                    }
                }
                else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When create deal "{name}" error occurred!', array('{name}' => $model->name)));
                }
            }

        }
        $aroundUndergrounds = Underground::model()->coordinates($paramsModel->latitude, $paramsModel->longitude, 1)->findAll();
        $postData = array();
        if(isset($_POST)){
            $postData = $_POST;
        }
        if(isset($_GET['currentCategory'])){
            $currentCategoryModel = DealsCategories::model()->findByPk($_GET['currentCategory']);
            $model->categories = array($currentCategoryModel);
            if(sizeof($currentCategoryModel->getChildren())==0){
                $paramsModel = $paramsModel=$this->loadParamsModel($model);
            }
        }
        $this->render('create',array(
            'model'=>$model,
            'imagesModel' => $imagesModel,
            'paramsModel'=>$paramsModel,
            'categoriesList' => DealsCategories::getListData(true, false, 1, true),
            'statusesList' => DealsStatuses::getListData(),
            'approveList' => Deals::getApproveListData(),
            'priorityList' => Deals::getPriorityListData(),
            'archiveList' => Deals::getArchiveListData(),
            'usersList' => User::getAllUsersListData(),
            'citiesList' => Cities::getAllCitiesListData(),
            'currenciesList' => Currencies::getCurrenciesListData(),
            'aroundUndergrounds' => $aroundUndergrounds,
            'user' => $this->user,
            'postData' => $postData,
        ));
    }

    /**
     * @param $id
     * @throws CDbException
     * @throws CException
     * @throws CHttpException
     */
    public function actionUpdate($id){
        $model=$this->loadModel($id);

        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        Yii::import('xupload.models.XUploadForm');

        $imagesModel = new XUploadForm();
        $model->setScenario('userUpdate');
        $paramsModel=$this->loadParamsModel($model);
        // Эта часть работает только при условии что товар отнросится к 1 категории
        /**
         * @var DealsCategories
         */
        //$currentCategoryParent = $model->categories[0]->getParent();

        $this->myPerformAjaxValidation($model);

        if(isset($_POST['Deals'])){
            $categoriesIds = array();
            if(isset($_POST['Deals']['categories']) && sizeof($_POST['Deals']['categories'])>0){
                $categories = DealsCategories::model()->findAllByPk($_POST['Deals']['categories']);
                $categoriesIds = $_POST['Deals']['categories'];
                unset($_POST['Deals']['categories']);
                $model->categories = $categories;
                $model->categoriesTree = DealsCategories::getParentsRecursively($model->categories[0]);
            }
            $model->attributes=$_POST['Deals'];
            //$model->user_id = $this->userId;
            $paramsValid = true;
            if(isset($_POST['DealCategoriesParams'])){
                $dealCatsParams = $_POST['DealCategoriesParams'];
                //Config::var_dump($dealCatsParams);


                // если параметр имееет тип phone(телефон). Вырезаем все ненужные символы
                foreach($dealCatsParams as $k=>$v){
                    $param = DealsParams::model()->findByAttributes(array('name' => $k));
                    if($param->type->name == 'phone'){
                        $dealCatsParams[$k] = preg_replace("/[^0-9]/", "", $v);
                    }
                }
                // получаем из виджета longitude И latitude если они пришли, и задаём параметр coordinates
                // удаляем из массива longitude и latitude
                if(isset($dealCatsParams['longitude']) || isset($dealCatsParams['latitude'])){
                    $coordinatesArr = array(
                        'longitude' => (isset($dealCatsParams['longitude'])) ? $dealCatsParams['longitude'] : "0",
                        'latitude' => (isset($dealCatsParams['latitude'])) ? $dealCatsParams['latitude'] : "0",
                    );
                    $coordinates = implode(":",$coordinatesArr);
                    $dealCatsParams['coordinates'] = $coordinates;
                    //unset($dealCatsParams['longitude']);
                    //unset($dealCatsParams['latitude']);
                }

                $paramsModel=new DealCategoriesParams('update',DealsCategories::model()->findAllByPk($categoriesIds),$model);
                $paramsModel->attributes = $dealCatsParams;
                $paramsValid = $paramsModel->validate();
            }

            if($model->validate() && $paramsValid){
                $transaction = Yii::app()->db->beginTransaction();
                if($saveWithRelated = $model->saveWithRelated(array('categories'))){

                    if(isset($dealCatsParams)){
                        $isParamSave = false;
                        $this->_clearParams($model);

                        foreach($dealCatsParams as $k => $v){
                            if($k == "latitude" || $k == "longitude"){
                                continue;
                            }
                            if(is_array($v)){
                                foreach($v as $value){
                                    $dealsParamsValuesModel = new DealsParamsValues;
                                    $dealsParamsValuesModel->deal_id = (int)$model->id;
                                    $param = DealsParams::model()->find('name=:name',array(':name' => $k));
                                    $dealsParamsValuesModel->param_id = $param->id;
                                    if($param->type->name == "phone"){
                                        $v=preg_replace("#[^0-9]#i","",$value);
                                    }
                                    $dealsParamsValuesModel->value = $value;
                                    if($dealsParamsValuesModel->validate()){
                                        if($dealsParamsValuesModel->save()){
                                            $isParamSave = true;
                                        }
                                        else{
                                            $isParamSave = false;
                                            break;
                                        }
                                    }
                                    else{
                                        $transaction->rollback();
                                        Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When update deal "{name}" error occurred!', array('{name}' => $model->name)));
                                    }
                                }
                            }
                            else{
                                $dealsParamsValuesModel = new DealsParamsValues;
                                $dealsParamsValuesModel->deal_id = (int)$model->id;
                                $param = DealsParams::model()->find('name=:name',array(':name' => $k));
                                $dealsParamsValuesModel->param_id = $param->id;
                                if($param->type->name == "phone"){
                                    $v=preg_replace("#[^0-9]#i","",$v);
                                }
                                $dealsParamsValuesModel->value = $v;
                                if($dealsParamsValuesModel->validate()){
                                    if($dealsParamsValuesModel->save()){
                                        $isParamSave = true;
                                    }
                                    else{
                                        $isParamSave = false;
                                        break;
                                    }
                                }
                                else{
                                    $transaction->rollback();
                                    Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When update deal "{name}" error occurred!', array('{name}' => $model->name)));
                                }

                            }

                        }
                        if($isParamSave){
                            $transaction->commit();
                            Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", 'Deal "{name}" was updated successfully!', array('{name}' => $model->name)));
                            $this->redirect(array('photo','id'=>$model->id));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When update deal "{name}" error occurred!', array('{name}' => $model->name)));
                        }
                    }
                    else{
                        $this->_clearParams($model);
                        $transaction->commit();
                        Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", 'Deal "{name}" was updated successfully!', array('{name}' => $model->name)));
                        $this->redirect(array('photo','id'=>$model->id));
                    }
                }
                else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When update deal "{name}" error occurred!', array('{name}' => $model->name)));
                }
            }

        }
        $aroundUndergrounds = Underground::model()->coordinates($paramsModel->latitude, $paramsModel->longitude, 1)->findAll();

        $postData = array();
        if(isset($_POST)){
            $postData = $_POST;
        }
        $this->render(
            'update',
            array(
                'model'=>$model,
                'imagesModel' => $imagesModel,
                'paramsModel' => $paramsModel,
                //'categoriesList' => CHtml::listData($currentCategoryParent->getChildren(),'id','name'),
                'statusesList' => DealsStatuses::getListData(),
                'approveList' => Deals::getApproveListData(),
                'priorityList' => Deals::getPriorityListData(),
                'archiveList' => Deals::getArchiveListData(),
                'usersList' => User::getAllUsersListData(),
                'citiesList' => Cities::getAllCitiesListData(),
                'currenciesList' => Currencies::getCurrenciesListData(),
                'aroundUndergrounds' => $aroundUndergrounds,
                'user' => $this->user,
                'postData' => $postData
            )
        );
    }

    /**
     * @throws CException
     */
    public function actionGetDealCategoriesParams(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_GET['deal_id'])){
                $model= Deals::model()->findByPk((int)$_GET['deal_id']);
            }
            else{
                $model = new Deals('userCreate');
            }
            if(isset($_GET['categories'])){
                $criteria = new CDbCriteria();
                $criteria->order = 'name ASC';
                $categories = DealsCategories::model()->findAllByPk($_GET['categories'], $criteria);

                if(sizeof($categories)>0){
                    $children = array();
                    foreach($categories as $category){
                        $children = array_merge($children,DealsCategories::getCategoryChildren($category->id));
                    }
                    if(sizeof($children)>0){
                        $this->myPerformAjaxValidation($model);
                        $html = $this->renderPartial(
                            '_categories_list',
                            array(
                                'categoriesList' => CHtml::listData($children,'id','name'),
                                'label' => false,
                                'model' => $model
                            ),
                            true,
                            true
                        );
                        $status = 'continue';
                        $message = 'continue';

                    }
                    else{
                        $paramsModel = new DealCategoriesParams('update',$categories, $model);
                        $this->myPerformAjaxValidation($model);
                        //Config::var_dump($paramsModel->rules());
                        $this->paramsModelPerformAjaxValidation($paramsModel);
                        $html = $this->renderPartial(
                            '_dealParams',
                            array(
                                'model'=>$model,
                                'categories' => $categories,
                                'paramsModel'=>$paramsModel,
                                'currenciesList' => Currencies::getCurrenciesListData(),
                            ),
                            true,
                            true
                        );
                        $status = 'end';
                        $message = 'end';

                    }
                }
                else{
                    $html = '';
                    $message = Yii::t('dealsModule','You must select category');
                    $status = 'empty';
                }

                echo CJSON::encode(
                    array(
                        'html' => $html,
                        'status' => $status,
                        'message' => $message
                    )
                );
                Yii::app()->end();

            }
            else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        }
    }

    /**
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id){

        $deal = Deals::model()->findByPk((int)$id);
        if(!is_null($deal)){
            if(Yii::app()->user->getId() != $deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }
            if(Yii::app()->request->isPostRequest){
                // we only allow deletion via POST request
                $model = $this->loadModel($id);
                if($model->delete()){
                    $message = Yii::t('dealsModule',"Deal <strong>{dealName}</strong> was deleted successfully!", array("{dealName}" => $model->name));
                    if(Yii::app()->request->isAjaxRequest){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }
                    else{
                        Yii::app()->user->setFlash('deleteDeal',$message);
                        $this->redirect("/user/profile/privateProfile");
                    }
                }
                else{
                    if(Yii::app()->request->isAjaxRequest){
                        $message = Yii::t('dealsModule',"When delete deal <strong>{dealName}</strong> error occurred!", array("{dealName}" => $model->name));
                        echo CJSON::encode(array(
                            'status' => 'error',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }
                }
            }
            else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }


    public function actionAddToFavorites($id){
        if(Yii::app()->request->isAjaxRequest){
            if(Yii::app()->user->isGuest){
                $cookieId = Yii::app()->request->cookies['favoritesId']->value;
                // @todo подключить saveWithRelatedBehavior
                $existsModel = CookiesFavorites::model()->find("cookie_id=:cookie_id AND deal_id=:deal_id", array(':cookie_id' => $cookieId, 'deal_id' => $id));
                if(is_null($existsModel)){
                    $favoritesModel = new CookiesFavorites();
                    $favoritesModel->cookie_id = $cookieId;
                    $favoritesModel->deal_id = $id;
                    $this->performAjaxValidation($favoritesModel);
                    if($favoritesModel->save()){
                        echo json_encode(
                            array(
                                'status' => 'success',
                                'message' => Yii::t('dealsModule',"Deals is successfully added to favorites.")
                            )
                        );
                        Yii::app()->end();
                    }
                    else{
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t('dealsModule',"When added to favorites error occurred.")
                            )
                        );
                        Yii::app()->end();
                    }
                }
                else{
                    echo json_encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('dealsModule',"This deal is already in favorites.")
                        )
                    );
                    Yii::app()->end();
                }
                unset($existsModel);
            }
            else{
                $userId = Yii::app()->user->getId();
                $existsModel = UsersFavorites::model()->find("user_id=:user_id AND deal_id=:deal_id", array(':user_id' => $userId, 'deal_id' => $id));
                if(is_null($existsModel)){
                    $favoritesModel = new UsersFavorites();
                    $favoritesModel->user_id = $userId;
                    $favoritesModel->deal_id = $id;
                    $this->performAjaxValidation($favoritesModel);
                    if($favoritesModel->save()){
                        echo json_encode(
                            array(
                                'status' => 'success',
                                'message' => Yii::t('dealsModule',"Deals is successfully added to favorites.")
                            )
                        );
                        Yii::app()->end();
                    }
                    else{
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t('dealsModule',"When added to favorites error occurred.")
                            )
                        );
                        Yii::app()->end();
                    }

                }
                else{
                    echo json_encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('dealsModule',"This deal is already in favorites.")
                        )
                    );
                    Yii::app()->end();
                }
                unset($existsModel);
            }
        }
        else{
            throw new CHttpException(404, "Page not found");
        }
    }

    public function actionDeleteFromFavorites($id){
        if(Yii::app()->request->isAjaxRequest){
            if(Yii::app()->user->isGuest){
                if (is_null(Yii::app()->request->cookies['favoritesId'])){
                    echo json_encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('dealsModule',"Cookie not found")
                        )
                    );
                    Yii::app()->end();
                }
                else{
                    $cookieId = Yii::app()->request->cookies['favoritesId']->value;
                    $cookiesFavorite = CookiesFavorites::model()->find("cookie_id=:cookie_id AND deal_id=:deal_id", array(':cookie_id' => $cookieId, 'deal_id' => $id));
                    if(!is_null($cookiesFavorite)){
                        if(!$cookiesFavorite->delete()){
                            echo json_encode(
                                array(
                                    'status' => 'error',
                                    'message' => Yii::t('dealsModule',"When deleted deal {deal_name} from favorites error occurred", array("{deal_name}" => $cookiesFavorite->deal->name))
                                )
                            );
                        }
                        else{
                            echo json_encode(
                                array(
                                    'status' => 'success',
                                    'message' => Yii::t('dealsModule',"Deal (deal_name) was deleted from favorites successfully", array("{deal_name}" => $cookiesFavorite->deal->name))
                                )
                            );
                        }
                    }
                    else{
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t('dealsModule',"Favorite not found.")
                            )
                        );
                        Yii::app()->end();
                    }
                }
            }
            else{
                $userId = Yii::app()->user->getId();
                $usersFavorite = UsersFavorites::model()->find("user_id=:user_id AND deal_id=:deal_id", array(':user_id' => $userId, 'deal_id' => $id));
                if(!is_null($usersFavorite)){
                    if(!$usersFavorite->delete()){
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t('dealsModule',"When deleted deal {deal_name} from favorites error occurred.", array("{deal_name}" => $usersFavorite->deal->name))
                            )
                        );
                    }
                    else{
                        echo json_encode(
                            array(
                                'status' => 'success',
                                'message' => Yii::t('dealsModule',"Deal (deal_name) was deleted from favorites successfully", array("{deal_name}" => $usersFavorite->deal->name))
                            )
                        );
                    }

                }
                else{
                    echo json_encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('dealsModule',"Favorite not found.")
                        )
                    );
                    Yii::app()->end();
                }
            }
        }
        else{
            throw new CHttpException(404, "Page not found");
        }
    }

    /**
     * @param $deal_id
     * @throws CException
     * @throws CHttpException
     */
    public function actionUpload($deal_id){
        if(Yii::app()->user->getId() != $this->deal->user_id){
            throw new CHttpException(403,'Access denied!');
        }
        $largeThumbWidth = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_WIDTH");
        $largeThumbHeight = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_HEIGHT");
        $mediumThumbWidth = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_WIDTH");
        $mediumThumbHeight = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_HEIGHT");
        $smallThumbWidth = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_WIDTH");
        $smallThumbHeight = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_HEIGHT");
        $smallThumbPrefix = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX");
        $mediumThumbPrefix = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX");
        $largeThumbPrefix = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX");
        $videoThumbsExt = Yii::app()->config->get("DEALS_MODULE.VIDEO_THUMBS_EXT");

        //This is for IE which doens't handle 'Content-type: application/json' correctly
        header( 'Vary: Accept' );
        if( isset( $_SERVER['HTTP_ACCEPT'] )
            && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
            header( 'Content-type: application/json' );
        } else {
            header( 'Content-type: text/plain' );
        }

        Yii::import("xupload.models.XUploadForm");
        $model = new XUploadForm;
        $model->file = CUploadedFile::getInstance($model,'file');
        //We check that the file was successfully uploaded
        if($model->file!==null){
            //Grab some data
            $model->mime_type = $model->file->getType();
            $fileType = explode("/", $model->mime_type)[0];
            if($fileType == 'image'){
                $fileValidator=CValidator::createValidator(
                    'EPictureValidator',
                    $model,
                    'file',
                    array(
                        'minWidth' => 80,
                        'minHeight' => 80,
                    )
                );
                $model->validatorList->add($fileValidator);
            }
            $model->size = $model->file->getSize();
            $model->name = $model->file->getName();
            //(optional) Generate a random name for our file
            $filename = md5(Yii::app()->user->getId().microtime().$model->name);
            $fileNameWithoutExt = $filename;
            $fileExt = $model->file->getExtensionName();
            $filename .= ".".$fileExt;
            if($model->validate()){

                /**
                 * Получаем текущий товар и создаём директории для медиафайлов если не созданы
                 * @var $currentDeal Deals
                 */
                $currentDeal = Deals::model()->findByPk($deal_id);
                if($currentDeal->createMediaDirs()){
                    //Получаем тип файла (image или video)

                    if($fileType == 'image'){
                        $imagesDir = realpath(Yii::app()->getBasePath()."/../uploads/deals").DIRECTORY_SEPARATOR.$deal_id.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
                        $imagesUrl = Yii::app( )->getBaseUrl( )."/uploads/deals/".$deal_id."/images/";
                        $originalPath = $imagesDir.$filename;
                        $originalUrl = $imagesUrl.$filename;
                        // Сохраняем оригинальный файл
                        $model->file->saveAs($originalPath);
                        chmod($originalPath,0777);

                        $largeThumbPath = $imagesDir.$largeThumbPrefix.$filename;
                        $mediumThumbPath = $imagesDir.$mediumThumbPrefix.$filename;
                        $smallThumbPath = $imagesDir.$smallThumbPrefix.$filename;
                        //$largeThumbUrl = $imagesUrl.$largeThumbPrefix.$filename;
                        //$mediumThumbUrl = $imagesUrl.$mediumThumbPrefix.$filename;
                        $thumbUrl = $imagesUrl.$smallThumbPrefix.$filename;

                        // Делаем тумбы
                        $this->_createThumb($originalPath, $largeThumbPath, $largeThumbWidth, $largeThumbHeight);
                        $this->_createThumb($originalPath, $mediumThumbPath, $mediumThumbWidth, $mediumThumbHeight);
                        $this->_createThumb($originalPath, $smallThumbPath, $smallThumbWidth, $smallThumbHeight);

                        $imageSize = getimagesize($originalPath);
                        $origWidth = $imageSize[0];
                        $origHeight = $imageSize[1];

                        // Сохраняем запись в базе данных
                        $imagesModel = new DealsImages();
                        $imagesModel->file_name = $filename;
                        $imagesModel->path = $originalPath;
                        $imagesModel->dir_path = $imagesDir;
                        $imagesModel->dir_url = $imagesUrl;
                        $imagesModel->ext = $fileExt;
                        $imagesModel->name = $fileNameWithoutExt;
                        $imagesModel->width = $origWidth;
                        $imagesModel->height = $origHeight;
                        $imagesModel->url = $originalUrl;
                        $imagesModel->deal_id = $deal_id;
                        if($imagesModel->validate()){
                            $imagesModel->save();
                        }
                        else{
                            echo json_encode(
                                array(
                                    array(
                                        "error" => $imagesModel->getErrors()
                                    )
                                )
                            );
                            Yii::log("XUploadSaveImagesBehavior: ".CVarDumper::dumpAsString($model->getErrors()),
                                CLogger::LEVEL_ERROR, "XUploadSaveImagesBehavior"
                            );
                        }
                        echo json_encode(
                            array(
                                array(
                                    "name" => $model->name,
                                    "type" => $model->mime_type,
                                    "alias" => $imagesModel->alias,
                                    "file_type" => $fileType,
                                    "size" => $model->size,
                                    "url" => $imagesUrl.$filename,
                                    "thumbnail_url" => $thumbUrl,
                                    "image_id" => $imagesModel->id,
                                    "deal_id" => $deal_id,
                                    "delete_url" => $this->createUrl(
                                        "deleteImage",
                                        array(
                                            "_method" => "delete",
                                            "file" => $filename,
                                            "deal_id" => $deal_id,
                                            "image_id" => $imagesModel->id
                                        )
                                    ),
                                    "delete_type" => "POST"
                                )
                            )
                        );
                    }
                    elseif($fileType == "video"){
                        Yii::import("vendor.ffprobe.Ffprobe");
                        $ffprobe = new Ffprobe('ffprobe');
                        $videosDir = realpath(Yii::app()->getBasePath()."/../uploads/deals").DIRECTORY_SEPARATOR.$deal_id.DIRECTORY_SEPARATOR."videos".DIRECTORY_SEPARATOR;
                        $thumbsDir = $videosDir."thumbs".DIRECTORY_SEPARATOR;
                        $originalThumb = $thumbsDir.$fileNameWithoutExt.".".$videoThumbsExt;
                        $videosUrl = Yii::app( )->getBaseUrl( )."/uploads/deals/".$deal_id."/videos/";
                        $thumbsUrl = $videosUrl."thumbs/";
                        $originalPath = $videosDir.$filename;
                        $originalUrl = $videosUrl.$filename;
                        // Сохраняем оригинальный файл
                        if($model->file->saveAs($originalPath)){
                            chmod($originalPath,0777);
                            $thumbUrl = "dafault_image.jpg";
                            if($this->createVideoThumb($originalPath, $originalThumb, 1)){
                                $largeThumbPath = $thumbsDir.$largeThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;
                                $mediumThumbPath = $thumbsDir.$mediumThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;
                                $smallThumbPath = $thumbsDir.$smallThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;

                                $this->_createThumb($originalThumb, $largeThumbPath, $largeThumbWidth, $largeThumbHeight);
                                $this->_createThumb($originalThumb, $mediumThumbPath, $mediumThumbWidth, $mediumThumbHeight);
                                $this->_createThumb($originalThumb, $smallThumbPath, $smallThumbWidth, $smallThumbHeight);
                                $thumbUrl = $thumbsUrl.$smallThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;

                            };
                            $ffprobe->setIsShowFormat(true);
                            $ffprobe->setPrintFormat('json');
                            $ffprobe->setIsShowStreams(true);
                            $ffprobe->setIsPretty(true);
                            $output = $ffprobe->getInfo($originalPath);
                            $stdErrParams = $this->_parseStdErrParams($output['errors']);
                            $videoInfo = json_decode($output['output']);
                            $videosModel = new DealsVideos();
                            if(isset($videoInfo->streams[0])){
                                $firstStream = $videoInfo->streams[0];
                                $videosModel->width = (int)$firstStream->width;
                                $videosModel->height = (int)$firstStream->height;
                            }

                            $videosModel->duration = ($stdErrParams && !is_null($stdErrParams['duration'])) ? $stdErrParams['duration'] : NULL;
                            $videosModel->file_name = $filename;
                            $videosModel->path = $originalPath;
                            $videosModel->name = $fileNameWithoutExt;
                            $videosModel->ext = $fileExt;
                            $videosModel->dir_path = $videosDir;
                            $videosModel->dir_url = $videosUrl;
                            $videosModel->url = $originalUrl;
                            $videosModel->deal_id = $deal_id;
                            if($videosModel->validate()){
                                $videosModel->save();
                            }
                            else{
                                echo json_encode(
                                    array(
                                        "error" => $videosModel->getErrors()
                                    )
                                );
                                Yii::log("XUpload upload: ".CVarDumper::dumpAsString($model->getErrors()),
                                    CLogger::LEVEL_ERROR, "XUpload upload"
                                );
                                Yii::app()->end();
                            }
                            echo json_encode(
                                array(
                                    array(
                                        "name" => $model->name,
                                        "type" => $model->mime_type,
                                        "alias" => $videosModel->alias,
                                        "file_type" => $fileType,
                                        "size" => $model->size,
                                        "url" => CHtml::encode($originalUrl),
                                        "thumbnail_url" => $thumbUrl,
                                        "video_id" => $videosModel->id,
                                        "deal_id" => $deal_id,
                                        "delete_url" => $this->createUrl(
                                            "deleteVideo",
                                            array(
                                                "_method" => "delete",
                                                "file" => $filename,
                                                "deal_id" => $deal_id,
                                                "video_id" => $videosModel->id
                                            )
                                        ),
                                        "delete_type" => "POST"
                                    )
                                )
                            );

                        }
                    }
                    else{
                        echo json_encode(
                            array(
                                array(
                                    "error" => "Неподдерживаемый тип файла - ".$fileType."(".$model->mime_type.")"
                                )
                            )
                        );
                        Yii::app()->end();
                    }
                }


                //Now we need to tell our widget that the upload was successfull
                //We do so, using the json structure defined in
                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup

            }
            else{
                //If the upload failed for some reason we log some data and let the widget know
                echo json_encode(
                    array(
                        array(
                            "error" => $model->getErrors('file'),
                    )
                    )
                );
                Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                    CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
                );
                Yii::app()->end();
            }
        }
        else{
            throw new CHttpException( 500, "Could not upload file" );
        }
    }

    public function actionUploadImage($deal_id){
        if(Yii::app()->user->getId() != $this->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        $largeThumbWidth = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_WIDTH");
        $largeThumbHeight = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_HEIGHT");
        $mediumThumbWidth = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_WIDTH");
        $mediumThumbHeight = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_HEIGHT");
        $smallThumbWidth = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_WIDTH");
        $smallThumbHeight = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_HEIGHT");
        $smallThumbPrefix = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX");
        $mediumThumbPrefix = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX");
        $largeThumbPrefix = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX");

        //This is for IE which doens't handle 'Content-type: application/json' correctly
        header( 'Vary: Accept' );
        if( isset( $_SERVER['HTTP_ACCEPT'] )
            && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
            header( 'Content-type: application/json' );
        } else {
            header( 'Content-type: text/plain' );
        }

        Yii::import("xupload.models.XUploadForm");
        $model = new XUploadForm('uploadImage');
        $model->file = CUploadedFile::getInstance($model,'file');
        //We check that the file was successfully uploaded
        if($model->file!==null){
            //Grab some data
            $model->mime_type = $model->file->getType();
            $fileType = explode("/", $model->mime_type)[0];
            if($fileType == 'image'){
                $fileValidator=CValidator::createValidator(
                    'EPictureValidator',
                    $model,
                    'file',
                    array(
                        'minWidth' => 80,
                        'minHeight' => 80,
                    )
                );
                $model->validatorList->add($fileValidator);
            }
            $model->size = $model->file->getSize();
            $model->name = $model->file->getName();
            //(optional) Generate a random name for our file
            $filename = md5(Yii::app()->user->getId().microtime().$model->name);
            $fileNameWithoutExt = $filename;
            $fileExt = $model->file->getExtensionName();
            $filename .= ".".$fileExt;
            if($model->validate()){

                /**
                 * Получаем текущий товар и создаём директории для медиафайлов если не созданы
                 * @var $currentDeal Deals
                 */
                $currentDeal = Deals::model()->findByPk($deal_id);
                if($currentDeal->createMediaDirs()){
                    //Получаем тип файла (image или video)

                    if($fileType == 'image'){
                        $imagesDir = realpath(Yii::app()->getBasePath()."/../uploads/deals").DIRECTORY_SEPARATOR.$deal_id.DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR;
                        $imagesUrl = Yii::app( )->getBaseUrl( )."/uploads/deals/".$deal_id."/images/";
                        $originalPath = $imagesDir.$filename;
                        $originalUrl = $imagesUrl.$filename;
                        // Сохраняем оригинальный файл
                        $model->file->saveAs($originalPath);
                        chmod($originalPath,0777);

                        $largeThumbPath = $imagesDir.$largeThumbPrefix.$filename;
                        $mediumThumbPath = $imagesDir.$mediumThumbPrefix.$filename;
                        $smallThumbPath = $imagesDir.$smallThumbPrefix.$filename;
                        //$largeThumbUrl = $imagesUrl.$largeThumbPrefix.$filename;
                        //$mediumThumbUrl = $imagesUrl.$mediumThumbPrefix.$filename;
                        $thumbUrl = $imagesUrl.$smallThumbPrefix.$filename;

                        // Делаем тумбы
                        $this->_createThumb($originalPath, $largeThumbPath, $largeThumbWidth, $largeThumbHeight);
                        $this->_createThumb($originalPath, $mediumThumbPath, $mediumThumbWidth, $mediumThumbHeight);
                        $this->_createThumb($originalPath, $smallThumbPath, $smallThumbWidth, $smallThumbHeight);

                        $imageSize = getimagesize($originalPath);
                        $origWidth = $imageSize[0];
                        $origHeight = $imageSize[1];

                        // Сохраняем запись в базе данных
                        $imagesModel = new DealsImages();
                        $imagesModel->file_name = $filename;
                        $imagesModel->path = $originalPath;
                        $imagesModel->dir_path = $imagesDir;
                        $imagesModel->dir_url = $imagesUrl;
                        $imagesModel->ext = $fileExt;
                        $imagesModel->name = $fileNameWithoutExt;
                        $imagesModel->width = $origWidth;
                        $imagesModel->height = $origHeight;
                        $imagesModel->url = $originalUrl;
                        $imagesModel->deal_id = $deal_id;
                        if($imagesModel->validate()){
                            $imagesModel->save();
                        }
                        else{
                            echo json_encode(
                                array(
                                    array(
                                        "error" => $imagesModel->getErrors()
                                    )
                                )
                            );
                            Yii::log("XUploadSaveImagesBehavior: ".CVarDumper::dumpAsString($model->getErrors()),
                                CLogger::LEVEL_ERROR, "XUploadSaveImagesBehavior"
                            );
                        }
                        echo json_encode(
                            array(
                                array(
                                    "name" => $model->name,
                                    "type" => $model->mime_type,
                                    "alias" => $imagesModel->alias,
                                    "file_type" => $fileType,
                                    "size" => $model->size,
                                    "url" => $imagesUrl.$filename,
                                    "thumbnail_url" => $thumbUrl,
                                    "image_id" => $imagesModel->id,
                                    "deal_id" => $deal_id,
                                    "delete_url" => $this->createUrl(
                                        "deleteImage",
                                        array(
                                            "_method" => "delete",
                                            "file" => $filename,
                                            "deal_id" => $deal_id,
                                            "image_id" => $imagesModel->id
                                        )
                                    ),
                                    "delete_type" => "POST"
                                )
                            )
                        );
                    }
                    else{
                        echo json_encode(
                            array(
                                array(
                                    "error" => "Неподдерживаемый тип файла - ".$fileType."(".$model->mime_type.")"
                                )
                            )
                        );
                        Yii::app()->end();
                    }
                }


                //Now we need to tell our widget that the upload was successfull
                //We do so, using the json structure defined in
                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup

            }
            else{
                //If the upload failed for some reason we log some data and let the widget know
                echo json_encode(
                    array(
                        array(
                            "error" => $model->getErrors('file'),
                        )
                    )
                );
                Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                    CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
                );
                Yii::app()->end();
            }
        }
        else{
            throw new CHttpException( 500, "Could not upload file" );
        }
    }


    public function actionUploadVideo($deal_id){
        if(Yii::app()->user->getId() != $this->deal->user_id){
            throw new CHttpException(403,'Access denied!');
        }
        $largeThumbWidth = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_WIDTH");
        $largeThumbHeight = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_HEIGHT");
        $mediumThumbWidth = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_WIDTH");
        $mediumThumbHeight = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_HEIGHT");
        $smallThumbWidth = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_WIDTH");
        $smallThumbHeight = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_HEIGHT");
        $smallThumbPrefix = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX");
        $mediumThumbPrefix = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX");
        $largeThumbPrefix = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX");
        $videoThumbsExt = Yii::app()->config->get("DEALS_MODULE.VIDEO_THUMBS_EXT");

        //This is for IE which doens't handle 'Content-type: application/json' correctly
        header( 'Vary: Accept' );
        if( isset( $_SERVER['HTTP_ACCEPT'] )
            && (strpos( $_SERVER['HTTP_ACCEPT'], 'application/json' ) !== false) ) {
            header( 'Content-type: application/json' );
        } else {
            header( 'Content-type: text/plain' );
        }

        Yii::import("xupload.models.XUploadForm");
        $model = new XUploadForm('uploadVideo');
        $model->file = CUploadedFile::getInstance($model,'file');
        //We check that the file was successfully uploaded
        if($model->file!==null){
            //Grab some data
            $model->mime_type = $model->file->getType();
            $fileType = explode("/", $model->mime_type)[0];
            $model->size = $model->file->getSize();
            $model->name = $model->file->getName();
            //(optional) Generate a random name for our file
            $filename = md5(Yii::app()->user->getId().microtime().$model->name);
            $fileNameWithoutExt = $filename;
            $fileExt = $model->file->getExtensionName();
            $filename .= ".".$fileExt;
            if($model->validate()){

                /**
                 * Получаем текущий товар и создаём директории для медиафайлов если не созданы
                 * @var $currentDeal Deals
                 */
                $currentDeal = Deals::model()->findByPk($deal_id);
                if($currentDeal->createMediaDirs()){
                    //Получаем тип файла (image или video)
                    if($fileType == "video"){
                        Yii::import("vendor.ffprobe.Ffprobe");
                        $ffprobe = new Ffprobe('ffprobe');
                        $videosDir = realpath(Yii::app()->getBasePath()."/../uploads/deals").DIRECTORY_SEPARATOR.$deal_id.DIRECTORY_SEPARATOR."videos".DIRECTORY_SEPARATOR;
                        $thumbsDir = $videosDir."thumbs".DIRECTORY_SEPARATOR;
                        $originalThumb = $thumbsDir.$fileNameWithoutExt.".".$videoThumbsExt;
                        $videosUrl = Yii::app( )->getBaseUrl( )."/uploads/deals/".$deal_id."/videos/";
                        $thumbsUrl = $videosUrl."thumbs/";
                        $originalPath = $videosDir.$filename;
                        $originalUrl = $videosUrl.$filename;
                        // Сохраняем оригинальный файл
                        if($model->file->saveAs($originalPath)){
                            chmod($originalPath,0777);
                            $thumbUrl = "dafault_image.jpg";
                            if($this->createVideoThumb($originalPath, $originalThumb, 1)){
                                $largeThumbPath = $thumbsDir.$largeThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;
                                $mediumThumbPath = $thumbsDir.$mediumThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;
                                $smallThumbPath = $thumbsDir.$smallThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;

                                $this->_createThumb($originalThumb, $largeThumbPath, $largeThumbWidth, $largeThumbHeight);
                                $this->_createThumb($originalThumb, $mediumThumbPath, $mediumThumbWidth, $mediumThumbHeight);
                                $this->_createThumb($originalThumb, $smallThumbPath, $smallThumbWidth, $smallThumbHeight);
                                $thumbUrl = $thumbsUrl.$smallThumbPrefix.$fileNameWithoutExt.".".$videoThumbsExt;

                            };
                            $ffprobe->setIsShowFormat(true);
                            $ffprobe->setPrintFormat('json');
                            $ffprobe->setIsShowStreams(true);
                            $ffprobe->setIsPretty(true);
                            $output = $ffprobe->getInfo($originalPath);
                            $stdErrParams = $this->_parseStdErrParams($output['errors']);
                            $videoInfo = json_decode($output['output']);
                            $videosModel = new DealsVideos();
                            if(isset($videoInfo->streams[0])){
                                $firstStream = $videoInfo->streams[0];
                                $videosModel->width = (int)$firstStream->width;
                                $videosModel->height = (int)$firstStream->height;
                            }

                            $videosModel->duration = ($stdErrParams && !is_null($stdErrParams['duration'])) ? $stdErrParams['duration'] : NULL;
                            $videosModel->file_name = $filename;
                            $videosModel->path = $originalPath;
                            $videosModel->name = $fileNameWithoutExt;
                            $videosModel->ext = $fileExt;
                            $videosModel->dir_path = $videosDir;
                            $videosModel->dir_url = $videosUrl;
                            $videosModel->url = $originalUrl;
                            $videosModel->deal_id = $deal_id;
                            if($videosModel->validate()){
                                $videosModel->save();
                            }
                            else{
                                echo json_encode(
                                    array(
                                        "error" => $videosModel->getErrors()
                                    )
                                );
                                Yii::log("XUpload upload: ".CVarDumper::dumpAsString($model->getErrors()),
                                    CLogger::LEVEL_ERROR, "XUpload upload"
                                );
                                Yii::app()->end();
                            }
                            echo json_encode(
                                array(
                                    array(
                                        "name" => $model->name,
                                        "type" => $model->mime_type,
                                        "alias" => $videosModel->alias,
                                        "file_type" => $fileType,
                                        "size" => $model->size,
                                        "url" => $videosUrl.$filename,
                                        "thumbnail_url" => $thumbUrl,
                                        "video_id" => $videosModel->id,
                                        "deal_id" => $deal_id,
                                        "delete_url" => $this->createUrl(
                                            "deleteVideo",
                                            array(
                                                "_method" => "delete",
                                                "file" => $filename,
                                                "deal_id" => $deal_id,
                                                "video_id" => $videosModel->id
                                            )
                                        ),
                                        "delete_type" => "POST"
                                    )
                                )
                            );

                        }
                    }
                    else{
                        echo json_encode(
                            array(
                                array(
                                    "error" => "Неподдерживаемый тип файла - ".$fileType."(".$model->mime_type.")"
                                )
                            )
                        );
                        Yii::app()->end();
                    }
                }


                //Now we need to tell our widget that the upload was successfull
                //We do so, using the json structure defined in
                // https://github.com/blueimp/jQuery-File-Upload/wiki/Setup

            }
            else{
                //If the upload failed for some reason we log some data and let the widget know
                echo json_encode(
                    array(
                        array(
                            "error" => $model->getErrors('file'),
                        )
                    )
                );
                Yii::log( "XUploadAction: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                    CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction"
                );
                Yii::app()->end();
            }
        }
        else{
            throw new CHttpException( 500, "Could not upload file" );
        }
    }

    /**
     * @throws CDbException
     */
    public function actionDeleteImage(){
        if(isset($_POST["_method"]) && isset($_POST['image_id'])){
            if($_POST["_method"] == "delete"){
                $model = DealsImages::model()->findByPk((int)$_POST['image_id']);
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                $model->delete();
                if(Yii::app()->request->isPostRequest){
                    echo json_encode(true);
                }
            }
            else{
                throw new CHttpException(403,'Incorrect data!');
            }
        }
        else{
            throw new CHttpException(403,'Incorrect data!');
        }
    }

    /**
     * @throws CDbException
     */
    public function actionDeleteVideo(){
        if(isset( $_POST["_method"]) && isset($_POST['video_id'])){
            if($_POST["_method"] == "delete"){
                $model = DealsVideos::model()->findByPk((int)$_POST['video_id']);
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                $model->delete();
                if(Yii::app()->request->isPostRequest){
                    echo json_encode(true);
                }
            }
            else{
                throw new CHttpException(403,'Incorrect data!');
            }
        }
        else{
            throw new CHttpException(403,'Incorrect data!');
        }
    }

    public function actionSetImageDescription(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['image_id']) && isset($_POST['description'])){
                $model = DealsImages::model()->with('deal')->findByPk((int)$_POST['image_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                if(!is_null($model)){
                    //@todo сделать очистку от скриптов и шлака
                    $model->description = CHtml::encode($_POST['description']);
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Image description was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',

                            'message' => $model->getError('description')
                        ));
                    }

                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }

    public function actionSetImageAlias(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['image_id']) && isset($_POST['alias'])){
                $model = DealsImages::model()->with('deal')->findByPk((int)$_POST['image_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                if(!is_null($model)){
                    //@todo сделать очистку от скриптов и шлака
                    $model->alias = CHtml::encode($_POST['alias']);
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Image alias was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $model->getError('alias')
                        ));
                    }

                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }

    public function actionSetImagePreview(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['image_id']) && isset($_POST['value'])){
                $model = DealsImages::model()->with('deal')->findByPk((int)$_POST['image_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                if(!is_null($model)){
                    $model->setScenario("setPreviews");
                    //@todo сделать очистку от скриптов и шлака
                    $model->preview = $_POST['value'];
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Image preview was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $model->getError('preview')
                        ));
                    }

                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }

    public function actionSetVideoDescription(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['video_id']) && isset($_POST['description'])){
                $model = DealsVideos::model()->with('deal')->findByPk((int)$_POST['video_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                //@todo сделать очистку от скриптов и шлака
                if(!is_null($model)){
                    $model->description = CHtml::encode($_POST['description']);
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Video description was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $model->getError('description')
                        ));
                    }
                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }

    public function actionSetVideoAlias(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['video_id']) && isset($_POST['alias'])){
                $model = DealsVideos::model()->with('deal')->findByPk((int)$_POST['video_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }
                if(!is_null($model)){
                    //@todo сделать очистку от скриптов и шлака
                    $model->alias = CHtml::encode($_POST['alias']);
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Video alias was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $model->getError('alias')
                        ));
                    }

                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }


    public function actionSetDealUpdatedDate($deal_id){
        if(Yii::app()->request->isPostRequest){
            $deal = Deals::model()->findByPk($deal_id);
            if(Yii::app()->user->getId() != $this->deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }
            $deal->updated_date = time();
            $save = $deal->save();
            if(Yii::app()->request->isAjaxRequest){
                if($save){
                    echo json_encode(array(
                        'status' => 'success',
                        'message' => Yii::t('dealsModule','Deal {deal_name} was updated successfully!',array('{deal_name}' => $deal->name))
                    ));
                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => $deal->getError('updated_date')
                    ));
                }
            }
        }
    }

    public function actionSetDealStatus(){

        if(Yii::app()->request->isPostRequest && isset($_POST['deal_id']) && isset($_POST['status_id'])){
            $deal_id = (int)$_POST['deal_id'];
            $status_id = (int)$_POST['status_id'];
            $deal = Deals::model()->findByPk($deal_id);
            if(Yii::app()->user->getId() != $deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }
            $status = DealsStatuses::model()->findByPk($status_id);

            if(!is_null($status)){
                $deal->status_id = $status_id;
                $save = $deal->save();
                if(Yii::app()->request->isAjaxRequest){
                    if($save){
                        echo json_encode(array(
                            'status' => 'success',
                            'dealStatus' => array(
                                'id' => $deal->status_id,
                                'name' => $status->name,
                                'label' => $status->label
                            ),
                            'message' => Yii::t('dealsModule','Deal {deal_name} was updated successfully!',array('{deal_name}' => $deal->name))
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $deal->getError('status_id')
                        ));
                    }
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule',"Incorrect status")
                ));

            }
        }
    }

    public function actionSetPaid($id,$paid){
        $deal = Deals::model()->findByPk($id);
        if(!is_null($deal)){
            if(Yii::app()->user->getId() != $deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }
            $deal->paid = $paid;
            $deal->setScenario("writeOffForDealsPriorityPlacement");
            if($deal->save()){
                if($paid == '1'){
                    $paymentAmount = Yii::app()->config->get("DEALS_MODULE.PRIORITY_PLACEMENT_PAYMENT");
                    if($deal->user->ballance>=$paymentAmount){
                        $payment = new Payments();
                        $payment->user_id = (int)$deal->user_id;
                        $payment->type_id = 4;
                        $payment->time = time();
                        $payment->amount = (int)$paymentAmount;
                        $payment->real_amount = (int)$paymentAmount;
                        $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'deals'))->id;
                        $payment->app_item_id = (int)$deal->id;
                        if($payment->save()){
                            $deal->priority = 1;
                            $deal->setScenario("writeOffForDealsPriorityPlacement");
                            if($deal->save()){
                                if(Yii::app()->request->isAjaxRequest){
                                    $message = Yii::t('dealsModule','Paid placement has been successfully enabled for deal "{name}"!', array("{name}" => $deal->name));
                                    echo CJSON::encode(array(
                                        'deal_id' => $id,
                                        'status' => 'success',
                                        'message' => $message,
                                        'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "success"),true),
                                    ));
                                    Yii::app()->end();
                                }
                            }
                            else{
                                if(Yii::app()->request->isAjaxRequest){
                                    $message = Yii::t('dealsModule','When the paid accommodation for the deal "{name}" the error occurred!', array("{name}" => $deal->name));
                                    echo CJSON::encode(array(
                                        'deal_id' => $id,
                                        'status' => 'error',
                                        'message' => $message,
                                        'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "danger"),true),
                                    ));
                                    Yii::app()->end();
                                }

                            };
                        }
                        else{
                            if(Yii::app()->request->isAjaxRequest){
                                $message = Yii::t('dealsModule','When the paid accommodation for the deal "{name}" the error occurred!', array("{name}" => $deal->name));
                                echo CJSON::encode(array(
                                    'deal_id' => $id,
                                    'status' => 'error',
                                    'message' => $message,
                                    'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "danger"),true),
                                ));
                                Yii::app()->end();
                            }
                        }
                    }
                    else{
                        if(Yii::app()->request->isAjaxRequest){
                            $message = Yii::t('dealsModule','When the paid accommodation for the deal "{name}" the error occurred! Insufficient funds.', array("{name}" => $deal->name));
                            echo CJSON::encode(array(
                                'deal_id' => $id,
                                'status' => 'error',
                                'message' => $message,
                                'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "danger"),true),
                            ));
                            Yii::app()->end();
                        }
                    }

                }
                elseif($paid == "0"){
                    if(Yii::app()->request->isAjaxRequest){
                        $message = Yii::t('dealsModule','Paid placement has been successfully disabled for deal "{name}"!', array("{name}" => $deal->name));
                        echo CJSON::encode(array(
                            'deal_id' => $id,
                            'status' => 'success',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }
                }

            };

        }
    }

    public function actionPayForLimit($id,$enable){
        /**
         * @var $deal Deals
         */
        $deal = Deals::model()->findByPk($id);
        if(!is_null($deal)){
            if(Yii::app()->user->getId() != $deal->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }
            if($enable == '1'){
                $paymentAmount = $deal->getPaidAmountForExceedingLimitCategories();
                if($deal->user->ballance>=$paymentAmount){
                    $payment = new Payments();
                    $payment->user_id = (int)$deal->user_id;
                    $payment->type_id = 7;
                    $payment->time = time();
                    $payment->amount = (int)$paymentAmount;
                    $payment->real_amount = (int)$paymentAmount;
                    $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'deals'))->id;
                    $payment->app_item_id = (int)$deal->id;
                    if($payment->save()){
                        $deal->exceeding_category_limit_hidden = 0;
                        $deal->exceeding_limit_paid = 1;
                        $deal->setScenario("writeOffForDealsCategoryExceedingLimitPlacement");
                        if($deal->save()){
                            if(Yii::app()->request->isAjaxRequest){
                                $message = Yii::t('dealsModule','Show has been successfully enabled for deal "{name}"!', array("{name}" => $deal->name));
                                echo CJSON::encode(array(
                                    'deal_id' => $id,
                                    'status' => 'success',
                                    'message' => $message,
                                    'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "success"),true),
                                ));
                                Yii::app()->end();
                            }
                        }
                        else{
                            if(Yii::app()->request->isAjaxRequest){
                                $message = Yii::t('dealsModule','When the paid accommodation for the deal "{name}" the error occurred!', array("{name}" => $deal->name));
                                echo CJSON::encode(array(
                                    'deal_id' => $id,
                                    'status' => 'error',
                                    'message' => $message,
                                    'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "danger"),true),
                                ));
                                Yii::app()->end();
                            }

                        };
                    }
                    else{
                        if(Yii::app()->request->isAjaxRequest){
                            $message = Yii::t('dealsModule','When the paid accommodation for the deal "{name}" the error occurred!', array("{name}" => $deal->name));
                            echo CJSON::encode(array(
                                'deal_id' => $id,
                                'status' => 'error',
                                'message' => $message,
                                'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "danger"),true),
                            ));
                            Yii::app()->end();
                        }
                    }
                }
                else{
                    if(Yii::app()->request->isAjaxRequest){
                        $message = Yii::t('dealsModule','When the paid accommodation for the deal "{name}" the error occurred! Insufficient funds.', array("{name}" => $deal->name));
                        echo CJSON::encode(array(
                            'deal_id' => $id,
                            'status' => 'error',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "danger"),true),
                        ));
                        Yii::app()->end();
                    }
                }

            }
            elseif($enable == "0"){
                if(Yii::app()->request->isAjaxRequest){
                    $deal->exceeding_category_limit_hidden = 1;
                    $deal->exceeding_limit_paid = 0;
                    $deal->setScenario("writeOffForDealsCategoryExceedingLimitPlacement");
                    if($deal->save()){
                        $message = Yii::t('dealsModule','Show has been successfully disabled for deal "{name}"!', array("{name}" => $deal->name));
                        echo CJSON::encode(array(
                            'deal_id' => $id,
                            'status' => 'success',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$deal, "message" => $message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }

                }
            }
        }
    }
    /**
     * @param $id
     * @return Deals
     * @throws CHttpException
     */
    public function loadModel($id){
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
            $model = new DealCategoriesParams('update',$deal->categories, $deal);
        }
        elseif(is_int($deal)){
            $dealObj = Deals::model()->findByPk($deal);
            $model = new DealCategoriesParams('update',$dealObj->categories,$dealObj);
        }
        else{
            $model = NULL;
        }
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
    protected function performAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function paramsModelPerformAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @param $model
     */
    protected function myPerformAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-form'){
            if(isset($_POST['DealCategoriesParams'])){
                $paramsModel=new DealCategoriesParams('update',$model->categories,$model);
                echo CActiveForm::validate(array($model,$paramsModel));
            }
            else{
                echo CActiveForm::validate($model);
            }
            Yii::app()->end();
        }
    }

    /**
     * @param $model
     * @return int
     */
    private function _clearParams($model){
        $criteria = new CDbCriteria;
        $criteria->condition = 'deal_id=:deal_id';
        $criteria->params = array(
            ':deal_id' => $model->id,
        );
        return DealsParamsValues::model()->deleteAll($criteria);
    }

    /**
     * @param $inputFilePath
     * @param $outputFilePath
     * @param $thumbTime
     * @param bool $progressFilePath
     * @return bool
     */
    public function createVideoThumb($inputFilePath, $outputFilePath, $thumbTime, $progressFilePath = false){
        Yii::import("vendor.ffmpeg.Ffmpeg");

        $ffmpeg = new Ffmpeg("ffmpeg");
        $ffmpeg
            ->setInput($inputFilePath)
            ->setOutput($outputFilePath)
            ->setIsDisabledAudioRecord()
            ->setFrames(1)
            ->setFramesStreamSpecifier(':v')
            //->setOutputFrameRate($previewsSettings['outputFrameRate'])
            ->setInputSeekPosition($thumbTime)
            //->setFilterGraph('select="isnan(prev_selected_t)+gte(t-prev_selected_t\,'.$delay.')*eq(pict_type\,I)"')

            ->setIsOverWrite(true) // перезаписывать ли выходной файл, если существует
            ->setTimelimit(60); // временной лимит работы ffmpeg после начала нарезки
        if($progressFilePath){
            $ffmpeg->setProgress($progressFilePath); // файл в который будет записан прогресс конвертации
        }
        $ffmpegResult = $ffmpeg->createVideoPreviews(true);
        if($ffmpegResult['status'] == "0"){
            return true;
        }
        else{
            return false;
        }

    }


    /**
     * @param null|string $stdErr
     * @return array
     */
    private function _parseStdErrParams($stdErr = NULL){
        if($stdErr != NULL && is_string($stdErr)){

            preg_match('/Duration: (.*?),/', $stdErr, $matches);

            $tmpTime = explode('.',$matches[1]);

            $time = $tmpTime[0];

            preg_match('/bitrate: (\d*) kb\/s/', $stdErr, $matches);
            $bitRate = $matches[1];

            $duration_array = explode(':', $time);
            $duration = $duration_array[0] * 3600 + $duration_array[1] * 60 + $duration_array[2]; //время в секундах

            $result = array(
                'time' => $time ? $time : NULL,
                'bitRate' => $bitRate ? $bitRate : NULL,
                'duration' => $duration ? $duration : NULL
            );
            return $result;
        }
        return false;
    }

    /**
     * @param string $filePath
     * @param int $width
     * @param int $height
     * @param string $thumbPath
     * @var $ih CImageHandler
     * @throws CException
     * @var $image Image
     */
    private function _createThumb($filePath, $thumbPath, $width, $height){
        $ih = Yii::app()->ih;
        /**
         * @var $ih CImageHandler
         */
        $ih->load($filePath);
        /*if(file_exists(Yii::app()->config->get("DEALS_MODULE.WATERMARK_PATH"))){
            $ih->watermark(Yii::app()->config->get("DEALS_MODULE.WATERMARK_PATH"),5,5,CImageHandler::CORNER_CENTER, 0.3);
        }*/
        $ih->adaptiveThumb($width, $height);
        $ih->save($thumbPath);
        chmod($thumbPath,0777);
    }
}
