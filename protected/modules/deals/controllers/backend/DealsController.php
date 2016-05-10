<?php

/**
 * Class DealsController
 */
class DealsController extends BackendController
{

    /**
     * Manages all models.
     */
    public function actionIndex(){
        $model=new Deals('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Deals'])){
            $model->attributes=$_GET['Deals'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id){
        Yii::import('xupload.models.XUploadForm');
        $imagesModel = new XUploadForm();
        $this->render(
            'view',
            array(
                'model'=>$this->loadModel($id),
                'approveList' => Deals::getApproveListData(),
                'imagesModel' => $imagesModel
            )
        );
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    /*public function actionCreate(){
        Yii::import('xupload.models.XUploadForm');
        $model=new Deals('adminCreate');
        $imagesModel = new XUploadForm();
        $paramsModel = $paramsModel=$this->loadParamsModel($model);

        $this->myPerformAjaxValidation($model);

        if(isset($_POST['Deals'])){
            $model->attributes=$_POST['Deals'];
            $model->user_id = Yii::app()->user->getId();
            $paramsValid = true;
            if(isset($_POST['DealCategoriesParams'])){
                $dealCatsParams = $_POST['DealCategoriesParams'];

                // получаем из виджета longitude И latitude если они пришли, и задаём параметр coordinates
                // удаляем из массива longitude и latitude
                if(isset($dealCatsParams['longitude']) || isset($dealCatsParams['latitude'])){
                    $coordinatesArr = array(
                        'longitude' => (isset($dealCatsParams['longitude'])) ? $dealCatsParams['longitude'] : "0",
                        'latitude' => (isset($dealCatsParams['latitude'])) ? $dealCatsParams['latitude'] : "0",
                    );
                    $coordinates = implode(":",$coordinatesArr);
                    $dealCatsParams['coordinates'] = $coordinates;
                    unset($dealCatsParams['longitude']);
                    unset($dealCatsParams['latitude']);
                }
                $paramsModel=new DealCategoriesParams('update',DealsCategories::model()->findAllByPk($model->categories),$model);
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
                            $dealsParamsValuesModel = new DealsParamsValues;
                            $dealsParamsValuesModel->deal_id = (int)$model->id;
                            $param = DealsParams::model()->find('name=:name',array(':name' => $k));
                            $dealsParamsValuesModel->param_id = (int)$param->id;
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
                                Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When create deal <strong>{name}</strong> error occurred!', array('{name}'=> $model->name)));
                            }
                        }
                        if($isParamSave){
                            $transaction->commit();
                            Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", "Deal <strong>{name}</strong> was created successfully!", array('{name}'=> $model->name)));
                            $this->redirect(array('view','id'=>$model->id));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", "When create deal <strong>{name}</strong> error occurred!", array('{name}'=> $model->name)));
                        }

                    }
                    else{
                        $this->_clearParams($model);
                        $transaction->commit();
                        Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", "Deal <strong>{name}</strong> was created successfully!", array('{name}'=> $model->name)));
                        $this->redirect(array('view','id'=>$model->id));
                    }
                }
                else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", "When create deal <strong>{name}</strong> error occurred!", array('{name}'=> $model->name)));
                }
            }

        }
        $aroundUndergrounds = Underground::model()->coordinates($paramsModel->latitude, $paramsModel->longitude, 1)->findAll();

        $this->render('create',array(
            'model'=>$model,
            'imagesModel' => $imagesModel,
            'paramsModel'=>$paramsModel,
            'categoriesList' => DealsCategories::getListData(true, false, Yii::app()->config->get("DEALS_MODULE.CATEGORIES_NESTED_LEVEL"), false),
            'statusesList' => DealsStatuses::getListData(),
            'approveList' => Deals::getApproveListData(),
            'priorityList' => Deals::getPriorityListData(),
            'archiveList' => Deals::getArchiveListData(),
            'usersList' => User::getAllUsersListData(),
            'citiesList' => Cities::getAllCitiesListData(),
            'currenciesList' => Currencies::getCurrenciesListData(),
            'aroundUndergrounds' => $aroundUndergrounds,
        ));
    }*/

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    /*public function actionUpdate($id){

        $model=$this->loadModel($id);
        Yii::import('xupload.models.XUploadForm');

        $imagesModel = new XUploadForm();
        $model->setScenario('adminUpdate');
        $paramsModel=$this->loadParamsModel($model);

        $this->myPerformAjaxValidation($model);

        if(isset($_POST['Deals'])){
            $model->attributes=$_POST['Deals'];
            $model->user_id = Yii::app()->user->getId();
            $paramsValid = true;
            if(isset($_POST['DealCategoriesParams'])){
                $dealCatsParams = $_POST['DealCategoriesParams'];

                // получаем из виджета longitude И latitude если они пришли, и задаём параметр coordinates
                // удаляем из массива longitude и latitude
                if(isset($dealCatsParams['longitude']) || isset($dealCatsParams['latitude'])){
                    $coordinatesArr = array(
                        'longitude' => (isset($dealCatsParams['longitude'])) ? $dealCatsParams['longitude'] : "0",
                        'latitude' => (isset($dealCatsParams['latitude'])) ? $dealCatsParams['latitude'] : "0",
                    );
                    $coordinates = implode(":",$coordinatesArr);
                    $dealCatsParams['coordinates'] = $coordinates;
                    unset($dealCatsParams['longitude']);
                    unset($dealCatsParams['latitude']);
                }

                $paramsModel=new DealCategoriesParams('update',DealsCategories::model()->findAllByPk($model->categories),$model);
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
                                Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", "When update deal <strong>{name}</strong> error occurred!", array('{name}'=> $model->name)));
                            }
                        }
                        if($isParamSave){
                            $transaction->commit();
                            Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", "Deal <strong>{name}</strong> was updated successfully!", array('{name}'=> $model->name)));
                            $this->redirect(array('view','id'=>$model->id));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", "When update deal <strong>{name}</strong> error occurred!", array('{name}'=> $model->name)));
                        }
                    }
                    else{
                        $this->_clearParams($model);
                        $transaction->commit();
                        Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", "Deal <strong>{name}</strong> was updated successfully!", array('{name}'=> $model->name)));
                        $this->redirect(array('view','id'=>$model->id));
                    }
                }
                else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", "When update deal <strong>{name}</strong> error occurred!", array('{name}'=> $model->name)));
                }
            }

        }
        $aroundUndergrounds = Underground::model()->coordinates($paramsModel->latitude, $paramsModel->longitude, 1)->findAll();

        $this->render(
            'update',
            array(
                'model'=>$model,
                'imagesModel' => $imagesModel,
                'paramsModel' => $paramsModel,
                'categoriesList' => DealsCategories::getListData(true, false, Yii::app()->config->get("DEALS_MODULE.CATEGORIES_NESTED_LEVEL"), false),
                'statusesList' => DealsStatuses::getListData(),
                'approveList' => Deals::getApproveListData(),
                'priorityList' => Deals::getPriorityListData(),
                'archiveList' => Deals::getArchiveListData(),
                'usersList' => User::getAllUsersListData(),
                'citiesList' => Cities::getAllCitiesListData(),
                'currenciesList' => Currencies::getCurrenciesListData(),
                'aroundUndergrounds' => $aroundUndergrounds,
            )
        );
    }*/

    /**
     * @throws CException
     */
    public function actionGetDealCategoriesParams(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['deal_id'])){
                $model= Deals::model()->findByPk($_POST['deal_id']);
            }
            else{
                $model = new Deals('adminCreate');
            }
            $categories = DealsCategories::model()->findAllByPk($_POST['categories']);
            $model->categories = $categories;
            $paramsModel = new DealCategoriesParams('update',$model);
            $output = $this->renderPartial(
                '_dealParams',
                array(
                    'model'=>$model,
                    'paramsModel'=>$paramsModel,
                    'currenciesList' => Currencies::getCurrenciesListData(),
                ),
                true,
                true
            );
            echo $output;
            Yii::app()->end();
        }
    }


    /**
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id){
        /*if(Yii::app()->request->isPostRequest){*/
            // we only allow deletion via POST request
        $model = $this->loadModel($id);
        $delete = $model->delete();
        if($delete){
            if(!isset($_GET['ajax'])){
                Yii::app()->user->setFlash('backendDealsSuccess', Yii::t("dealsModule", 'Deal <strong>{name}</strong> was deleted successfully!', array('{name}'=> $model->name)));
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else{
            //Config::var_dump($model->getErrors());

            if(!isset($_GET['ajax'])){
                Yii::app()->user->setFlash('backendDealsError', Yii::t("dealsModule", 'When delete deal <strong>{name}</strong> error occurred!', array('{name}'=> $model->name)));
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }

        }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        /*}
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }*/
    }


    /**
     * @param $deal_id
     * @throws CException
     * @throws CHttpException
     */
    public function actionUpload($deal_id){

        $largeThumbWidth = (int)Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_WIDTH");
        $largeThumbHeight = (int)Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_HEIGHT");
        $mediumThumbWidth = (int)Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_WIDTH");
        $mediumThumbHeight = (int)Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_HEIGHT");
        $smallThumbWidth = (int)Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_WIDTH");
        $smallThumbHeight = (int)Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_HEIGHT");
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
            $filename = md5(Yii::app()->user->id.microtime().$model->name);
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
                                    "size" => $model->size,
                                    "url" => $imagesUrl.$filename,
                                    "thumbnail_url" => $thumbUrl,
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

                                $image = Yii::app()->image->load($originalThumb);
                                $image->resize($largeThumbWidth, $largeThumbHeight);
                                $image->save($largeThumbPath);
                                chmod($largeThumbPath,0777);
                                $image->resize($mediumThumbWidth, $mediumThumbHeight);
                                $image->save($mediumThumbPath);
                                chmod($mediumThumbPath,0777);
                                $image->resize($smallThumbWidth,$smallThumbHeight);
                                $image->save($smallThumbPath);
                                chmod($smallThumbPath,0777);
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
                                        "size" => $model->size,
                                        "url" => $videosUrl.$filename,
                                        "thumbnail_url" => $thumbUrl,
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


        if(isset( $_GET["_method"]) && isset($_GET['image_id'])){
            if($_GET["_method"] == "delete"){
                $model = DealsImages::model()->findByPk((int)$_GET['image_id']);
                $model->delete();
                echo json_encode(true);
            }
        }
    }

    /**
     *
     */
    /*public function actionApproveImage(){
        if(isset( $_GET["_method"]) && isset($_GET['image_id'])){
            if($_GET["_method"] == "approve"){
                $image = DealsImages::model()->with('deal')->findByPk((int)$_GET['video_id']);
                $image->approve = 1;
                $save = $image->save();
                if(!is_null($image->deal->user) && !is_null($image->deal->user->email) && strlen(trim($image->deal->user->email))>0){
                    $name = (!is_null($image->alias) && strlen(trim($image->alias))>0) ? $image->alias : $image->file_name;
                    $message = "Уважаемый ".$image->deal->user->username." ! Изображение \"".$name."\" одобрено модератором.";
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $image->deal->user->email;
                    $messagesModel->subject = 'Сообщение с сайта all4holidays.com.';
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $image->deal->user->id;
                    $messagesModel->save();
                }
                echo json_encode($save);
            }
        }
    }*/

    /**
     *
     */
    /*public function actionUnApproveImage(){
        if(isset( $_GET["_method"]) && isset($_GET['image_id'])){
            if($_GET["_method"] == "unApprove"){
                $image = DealsImages::model()->with('deal')->findByPk((int)$_GET['video_id']);
                $image->approve = 0;
                $save = $image->save();
                if(!is_null($image->deal->user) && !is_null($image->deal->user->email) && strlen(trim($image->deal->user->email))>0){
                    $name = (!is_null($image->alias) && strlen(trim($image->alias))>0) ? $image->alias : $image->file_name;
                    $message = "Уважаемый ".$image->deal->user->username." ! Изображение \"".$name."\" отклонено модератором.";
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $image->deal->user->email;
                    $messagesModel->subject = 'Сообщение с сайта all4holidays.com.';
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $image->deal->user->id;
                    $messagesModel->save();
                }
                echo json_encode($save);
            }
        }
    }*/

    /**
     *
     */
    /*public function actionApproveVideo(){
        if(isset( $_GET["_method"]) && isset($_GET['video_id'])){
            if($_GET["_method"] == "approve"){
                $video = DealsVideos::model()->with('deal')->findByPk((int)$_GET['video_id']);
                $video->approve = 1;
                $save = $video->save();
                if(!is_null($video->deal->user) && !is_null($video->deal->user->email) && strlen(trim($video->deal->user->email))>0){
                    $name = (!is_null($video->alias) && strlen(trim($video->alias))>0) ? $video->alias : $video->file_name;
                    $message = "Уважаемый ".$video->deal->user->username." ! Видео \"".$name."\" одобрено модератором.";
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $video->deal->user->email;
                    $messagesModel->subject = 'Сообщение с сайта all4holidays.com.';
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $video->deal->user->id;
                    $messagesModel->save();
                }
                echo json_encode($save);
            }
        }
    }*/

    /**
     *
     */
    /*public function actionUnApproveVideo(){
        if(isset( $_GET["_method"]) && isset($_GET['video_id'])){
            if($_GET["_method"] == "unApprove"){
                $video = DealsVideos::model()->with('deal')->findByPk((int)$_GET['video_id']);
                $video->approve = 0;
                $save = $video->save();
                if(!is_null($video->deal->user) && !is_null($video->deal->user->email) && strlen(trim($video->deal->user->email))>0){
                    $name = (!is_null($video->alias) && strlen(trim($video->alias))>0) ? $video->alias : $video->file_name;
                    $message = "Уважаемый ".$video->deal->user->username." ! Видео \"".$name."\" отклонено модератором.";
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $video->deal->user->email;
                    $messagesModel->subject = 'Сообщение с сайта all4holidays.com.';
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $video->deal->user->id;
                    $messagesModel->save();
                }
                echo json_encode($save);
            }
        }
    }*/

    /**
     *
     */
    /*public function actionApproveLink(){
        if(isset( $_GET["_method"]) && isset($_GET['link_id'])){
            if($_GET["_method"] == "approve"){
                $link = DealLinks::model()->with('deal')->findByPk((int)$_GET['link_id']);
                $link->approve = 1;
                $save = $link->save();
                if(!is_null($link->deal->user) && !is_null($link->deal->user->email) && strlen(trim($link->deal->user->email))>0){
                    $name = (!is_null($link->alias) && strlen(trim($link->alias))>0) ? $link->alias : $link->link;
                    $message = "Уважаемый ".$link->deal->user->username." ! Видео \"".$name."\" одобрено модератором.";
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $link->deal->user->email;
                    $messagesModel->subject = 'Сообщение с сайта all4holidays.com.';
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $link->deal->user->id;
                    $messagesModel->save();
                }
                echo json_encode($save);
            }
        }
    }*/

    /**
     *
     */
    /*public function actionUnApproveLink(){
        if(isset( $_GET["_method"]) && isset($_GET['link_id'])){
            if($_GET["_method"] == "unApprove"){
                $link = DealLinks::model()->with('deal')->findByPk((int)$_GET['link_id']);
                $link->approve = 0;
                $save = $link->save();
                if(!is_null($link->deal->user) && !is_null($link->deal->user->email) && strlen(trim($link->deal->user->email))>0){
                    $name = (!is_null($link->alias) && strlen(trim($link->alias))>0) ? $link->alias : $link->link;
                    $message = "Уважаемый ".$link->deal->user->username." ! Видео \"".$name."\" отклонено модератором.";
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $link->deal->user->email;
                    $messagesModel->subject = 'Сообщение с сайта all4holidays.com.';
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $link->deal->user->id;
                    $messagesModel->save();
                }
                echo json_encode($save);
            }
        }
    }*/


    /**
     * @throws CDbException
     */
    public function actionDeleteVideo(){
        if(isset( $_GET["_method"]) && isset($_GET['video_id'])){
            if($_GET["_method"] == "delete"){
                $model = DealsVideos::model()->findByPk((int)$_GET['video_id']);
                $model->delete();
                echo json_encode(true);
            }
        }
    }

    /**
     * @param integer $id Deal id
     */
    public function actionApprove($id){
        $deal = $this->loadModel((int)$id);
        if(!is_null($deal)) {
            $deal->approve = 1;
            $save = $deal->save();
            if($save){
                if(!is_null($deal->user) && !is_null($deal->user->email) && strlen(trim($deal->user->email))>0){
                    $message = Yii::t(
                        'dealsModule',
                        "Dear {userName}! Deal \"{name}\" was approved by the moderator.",
                        array(
                            '{userName}' => CHtml::encode($deal->user->username),
                            '{name}' => CHtml::encode($deal->name)
                        )
                    );
                    /*$messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $deal->user->id;
                    $messagesModel->save();*/
                    UserMessages::sendMessage(1,$deal->user_id,$message);
                }

            }
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }
    }

    /**
     * @param integer $id Deal id
     */
    public function actionUnApprove($id){
        $deal = $this->loadModel((int)$id);
        if(!is_null($deal)) {
            $deal->approve = 0;
            $save = $deal->save();
            if($save){
                if(!is_null($deal->user) && !is_null($deal->user->email) && strlen(trim($deal->user->email))>0){
                    $message = Yii::t(
                        'dealsModule',
                        "Dear {userName}! Deal \"{name}\" was declined by the moderator.",
                        array(
                            '{userName}' => CHtml::encode($deal->user->username),
                            '{name}' => CHtml::encode($deal->name)
                        )
                    );
                    /*$messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $deal->user->id;
                    $messagesModel->save();*/
                    UserMessages::sendMessage(1,$deal->user_id,$message);
                }

            }
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }

    }

    public function actionSentBackForRevision($id){
        $deal = $this->loadModel((int)$id);
        if(!is_null($deal)) {
            $deal->approve = 2;
            $save = $deal->save();
            if(!is_null($deal->user) && !is_null($deal->user->email) && strlen(trim($deal->user->email))>0){
                $message = Yii::t(
                    'dealsModule',
                    "Dear {userName}! Deal \"{name}\" was not passed moderation. Correct classified in accordance with the site rules.",
                    array(
                        '{userName}' => CHtml::encode($deal->user->username),
                        '{name}' => CHtml::encode($deal->name)
                    )
                );
                /*$messagesModel = new EmailMessages();
                $messagesModel->from = Yii::app()->params['adminEmail'];
                $messagesModel->to = $deal->user->email;
                $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                $messagesModel->message = $message;
                $messagesModel->type_id = 1;
                $messagesModel->is_sent = 0;
                $messagesModel->created_date = time();
                $messagesModel->recipient_id = $deal->user->id;
                $messagesModel->save();*/
                UserMessages::sendMessage(1,$deal->user_id,$message);
            }
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }
    }


    /**
     * @param $id
     * @return Deals
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Deals::model()->with('user')->findByPk($id);
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

    /**
     * @param $model
     */
    protected function myPerformAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-form'){
            if(isset($_POST['DealCategoriesParams'])){
                $paramsModel=new DealCategoriesParams('update',$model);
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
     * @throws CException
     * @var $image Image
     */
    private function _createThumb($filePath, $thumbPath, $width, $height){
        Yii::app()->ih
            ->load($filePath)
            ->adaptiveThumb($width, $height)
            ->save($thumbPath);
        chmod($thumbPath,0777);
    }
}
