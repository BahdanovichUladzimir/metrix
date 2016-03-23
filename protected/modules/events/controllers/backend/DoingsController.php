<?php

class DoingsController extends BackendController
{

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Doings;

        $this->performAjaxValidation($model);

        if(isset($_POST['Doings'])){
            $model->attributes=$_POST['Doings'];
            $model->eventsTypes = (isset($_POST['Doings']["eventsTypes"]))?$_POST['Doings']["eventsTypes"]:NULL;
            if($model->saveWithRelated(array('eventsTypes'))){
                Yii::app()->user->setFlash('doingsSuccess', Yii::t("eventsModule", "Doing <strong>{name}</strong> was created successfully!", array("{name}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('doingsError', Yii::t("eventsModule", "When create doing <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
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

        if(isset($_POST['Doings'])){
            $model->attributes=$_POST['Doings'];
            $model->eventsTypes = (isset($_POST['Doings']["eventsTypes"]))?$_POST['Doings']["eventsTypes"]:NULL;
            if($model->saveWithRelated(array('eventsTypes'))){
                Yii::app()->user->setFlash('doingsSuccess', Yii::t("eventsModule", "Doing <strong>{name}</strong> was updated successfully!", array("{name}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('doingsError', Yii::t("eventsModule", "When update doing <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
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
        $model=new Doings('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Doings'])){
            $model->attributes=$_GET['Doings'];
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
     * @return array|mixed|null Doings
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Doings::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='doings-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
