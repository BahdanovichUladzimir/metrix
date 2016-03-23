<?php

class BannersPricesController extends BackendController
{



    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new BannersPrices;

        $this->performAjaxValidation($model);

        if(isset($_POST['BannersPrices'])){
            $model->attributes=$_POST['BannersPrices'];
            if($model->save()){
                Yii::app()->user->setFlash('bannersBackendPricesSuccess', Yii::t("bannersModule", "Price <strong>{id}</strong> was created successfully!", array("{id}" => $model->id)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('bannersBackendPricesError', Yii::t("bannersModule", "When create price <strong>{id}</strong> error occurred!", array("{id}" => $model->id)));
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
        $this->performAjaxValidation($model);

        if(isset($_POST['BannersPrices'])){
            $model->attributes=$_POST['BannersPrices'];
            if($model->save()){
                Yii::app()->user->setFlash('bannersBackendPricesSuccess', Yii::t("bannersModule", "Price <strong>{id}</strong> was updated successfully!", array("{id}" => $model->id)));
            }
            else{
                Yii::app()->user->setFlash('bannersBackendPricesError', Yii::t("bannersModule", "When update price <strong>{id}</strong> error occurred!", array("{id}" => $model->id)));
            }

        }

        $this->render(
            'update',
            array(
                'model'=>$model,
            )
        );
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($id){
        /*if(Yii::app()->request->isPostRequest){*/
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
        $model=new BannersPrices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['BannersPrices'])){
            $model->attributes=$_GET['BannersPrices'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    /**
     * @param $id
     * @return BannersPrices
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=BannersPrices::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='banners-prices-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
