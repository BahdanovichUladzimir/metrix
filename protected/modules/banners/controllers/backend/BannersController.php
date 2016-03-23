<?php

class BannersController extends BackendController
{

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    /*public function actionView($id){
        $this->render(
            'view',
            array(
                'model'=>$this->loadModel($id),
            )
        );
    }*/

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    /*public function actionCreate(){
        $model=new Banners;

        $this->performAjaxValidation($model);

        if(isset($_POST['Banners'])){
            $model->attributes=$_POST['Banners'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }*/

    /**
     * @param integer $id Image id
     */
    public function actionApprove($id){
        $banner = Banners::model()->findByPk((int)$id);
        if(!is_null($banner)) {
            $banner->approve = 1;
            $save = $banner->save();
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }
    }

    /**
     *
     */
    public function actionApproveSelected(){
        if(isset($_POST) && isset($_POST['value']) && sizeof($_POST['value'])>0){
            foreach($_POST['value'] as $id){
                $banner = Banners::model()->findByPk((int)$id);
                if(!is_null($banner)){
                    $banner->approve = 1;
                    $banner->save();
                }
            }
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    /**
     * @param integer $id Image id
     */
    public function actionUnApprove($id){
        $banner = Banners::model()->findByPk((int)$id);
        if(!is_null($banner)) {
            $banner->approve = 0;
            $save = $banner->save();
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }
    }


    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    /*public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Banners'])){
            $model->attributes=$_POST['Banners'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
            )
        );
    }*/

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
        $model=new Banners('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Banners'])){
            $model->attributes=$_GET['Banners'];
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
     * @return Banners
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Banners::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='banners-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
