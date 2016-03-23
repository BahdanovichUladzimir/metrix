<?php

class EventsDoingsCategoriesController extends BackendController
{

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new EventsDoingsCategories;

        $this->performAjaxValidation($model);

        if(isset($_POST['EventsDoingsCategories'])){
            $model->attributes=$_POST['EventsDoingsCategories'];
            if($model->save()){
                Yii::app()->user->setFlash('eventsDoingsCategoriesSuccess', Yii::t("eventsModule", "Category <strong>{name}</strong> was created successfully!", array("{name}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('eventsDoingsCategoriesError', Yii::t("eventsModule", "When create category <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
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

        if(isset($_POST['EventsDoingsCategories'])){
            $model->attributes=$_POST['EventsDoingsCategories'];
            if($model->save()){
                Yii::app()->user->setFlash('eventsDoingsCategoriesSuccess', Yii::t("eventsModule", "Category <strong>{name}</strong> was updated successfully!", array("{name}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('eventsDoingsCategoriesError', Yii::t("eventsModule", "When update category <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
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
        $model=new EventsDoingsCategories('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['EventsDoingsCategories'])){
            $model->attributes=$_GET['EventsDoingsCategories'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id){
        $model=EventsDoingsCategories::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='events-doings-categories-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
