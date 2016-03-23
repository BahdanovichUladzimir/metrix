<?php

class ListsController extends BackendController
{


    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Lists;

        $this->performAjaxValidation($model);

        if(isset($_POST['Lists'])){
            $model->attributes=$_POST['Lists'];
            if($model->save()){
                Yii::app()->user->setFlash('adminModule.Lists.Success', Yii::t("adminModule", "List <strong>{listName}</strong> was created successfully!", array("{listName}" => $model->name)));
                $this->redirect(array('index'));
            }
            else {
                Yii::app()->user->setFlash('adminModule.Lists.Error', Yii::t("adminModule", "When create list <strong>{listName}</strong> error occurred!", array("{listName}" => $model->name)));
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

        if(isset($_POST['Lists'])){
            $model->attributes=$_POST['Lists'];
            if($model->save()){
                Yii::app()->user->setFlash('adminModule.Lists.Success', Yii::t("adminModule", "List <strong>{listName}</strong> was updated successfully!", array("{listName}" => $model->name)));
                $this->redirect(array('index'));
            }
            else{
                Yii::app()->user->setFlash('adminModule.Lists.Error', Yii::t("adminModule", "When update list <strong>{listName}</strong> error occurred!", array("{listName}" => $model->name)));
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
     * @param $id
     * @throws CDbException
     * @throws CHttpException
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
        $model=new Lists('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Lists'])){
            $model->attributes=$_GET['Lists'];
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
     * @return Lists
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Lists::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='lists-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
