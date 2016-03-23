<?php

class DealsParamsTypesController extends BackendController
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
    public function actionCreate(){
        $model=new DealsParamsTypes;

        $this->performAjaxValidation($model);

        if(isset($_POST['DealsParamsTypes'])){
            $model->attributes=$_POST['DealsParamsTypes'];
            if($model->save()){
                Yii::app()->user->setFlash('dealsParamsTypesSuccess', Yii::t("dealsModule", "Param type <strong>{name}</strong> was created successfully!", array("{name}" => $model->name)));
                $this->redirect(array('update','id'=>$model->id));
            }
            else{
                Yii::app()->user->setFlash('dealsParamsError', Yii::t("dealsModule", "When create param type <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
                $this->redirect(array('create'));
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
     * @var $model DealsParamsTypes
    */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['DealsParamsTypes'])){
            $model->attributes=$_POST['DealsParamsTypes'];
            if($model->save()){
                Yii::app()->user->setFlash('dealsParamsTypesSuccess', Yii::t("dealsModule", "Param type <strong>{name}</strong> was updated successfully!", array("{name}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('dealsParamsTypesError', Yii::t("dealsModule", "When update param type <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
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
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new DealsParamsTypes('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsParamsTypes'])){
            $model->attributes=$_GET['DealsParamsTypes'];
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
        $model=DealsParamsTypes::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-params-types-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
