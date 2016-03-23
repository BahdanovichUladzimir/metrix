<?php

class CitiesController extends BackendController{

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Cities;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if(isset($_POST['Cities']))
        {
            $model->attributes=$_POST['Cities'];

            if($model->save()){
                Yii::app()->user->setFlash('adminCitiesSuccess', Yii::t("adminModule", "City <strong>{city}</strong> was created successfully!", array("{city}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('adminCitiesError', Yii::t("adminModule", "When create city <strong>{city}</strong> error occurred!", array("{city}" => $model->name)));
            }
        }
        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id){
        $model=$this->loadModel($id);

        /**
         * @var $model Cities
         */
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Cities'])){
            $model->attributes=$_POST['Cities'];
            if($model->save()){
                Yii::app()->user->setFlash('adminCitiesSuccess', Yii::t("adminModule", "City <strong>{city}</strong> was updated successfully!", array("{city}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('adminCitiesError', Yii::t("adminModule", "When update city <strong>{city}</strong> error occurred!", array("{city}" => $model->name)));
            }
        }
        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id){
        /*if(Yii::app()->request->isPostRequest){*/
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        /*}
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }*/
    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new Cities('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Cities'])){
            $model->attributes=$_GET['Cities'];
        }

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    /*public function actionSetUserCity($cityId){
        $this->userCityId = (int)$cityId;
        $this->userCityKey = Cities::model()->findByPk((int)$this->userCityId)->key;
        Yii::app()->request->cookies['cityId'] = new CHttpCookie('cityId', $this->userCityId);
        Yii::app()->request->cookies['cityKey'] = new CHttpCookie("cityKey", $this->userCityKey);
        echo json_encode(
            array(
                'message' => 'success',
                'cityId' => $this->userCityId,
                'cityKey' => $this->userCityKey,
            )
        );
    }*/

    /**
     * @param $id
     * @return static
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Cities::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='cities-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
