<?php

class CountriesController extends BackendController{

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    /*public function actionView($id){
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }*/

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Countries;

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['Countries'])){
            $model->attributes=$_POST['Countries'];
            if($model->save()){
                Yii::app()->user->setFlash('adminCountriesSuccess', Yii::t("adminModule", "Country <strong>{country}</strong> was created successfully!", array('{country}'=>$model->name)));
                $this->redirect(array('update','id'=>$model->id));
            }
            else{
                Yii::app()->user->setFlash('adminCountriesError', Yii::t("adminModule", "When create country <strong>{country}</strong> error occurred!", array('{country}'=>$model->name)));
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

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        /**
         * @var $model Countries
         */
        if(isset($_POST['Countries'])){
            $model->attributes=$_POST['Countries'];
            if($model->save()){
                Yii::app()->user->setFlash('adminCountriesSuccess', Yii::t("adminModule", "Country <strong>{country}</strong> was updated successfully!", array('{country}'=>$model->name)));
            }
            else{
                Yii::app()->user->setFlash('adminCountriesError', Yii::t("adminModule", "When update country <strong>{country}</strong> error occurred!", array('{country}'=>$model->name)));
            }
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($id){
        $model = $this->loadModel($id);
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new Countries('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Countries'])){
            $model->attributes=$_GET['Countries'];
        }

        $this->render('index',array(
            'model'=>$model,
        ));
    }

    /**
     * @param $id
     * @return Countries
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Countries::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='countries-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
