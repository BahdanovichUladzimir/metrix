<?php

class RatingsController extends BackendController
{

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id){
        $this->render(
            'view',
            array(
                'model'=>$this->loadModel($id),
            )
        );
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Ratings;

        $this->performAjaxValidation($model);

        if(isset($_POST['Ratings'])){
            $model->attributes=$_POST['Ratings'];
            if($model->save()){
                Yii::app()->user->setFlash('dealsmodule.backend.rating.create.success', Yii::t("dealsModule", "Rating <strong>{ratingLabel}</strong> was created successfully!", array("{ratingLabel}" => $model->label)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('dealsmodule.backend.rating.create.error', Yii::t("dealsModule", "When create rating <strong>{ratingLabel}</strong> error occurred!", array("{ratingLabel}" => $model->label)));
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

        if(isset($_POST['Ratings'])){
            $model->attributes=$_POST['Ratings'];
            if($model->save()){
                Yii::app()->user->setFlash('dealsmodule.backend.rating.create.success', Yii::t("dealsModule", "Rating <strong>{ratingLabel}</strong> was updated successfully!", array("{ratingLabel}" => $model->label)));
            }
            else{
                Yii::app()->user->setFlash('dealsmodule.backend.rating.create.error', Yii::t("dealsModule", "When update rating <strong>{ratingLabel}</strong> error occurred!", array("{ratingLabel}" => $model->label)));
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
        $model=new Ratings('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Ratings'])){
            $model->attributes=$_GET['Ratings'];
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
     * @return Ratings
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Ratings::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='ratings-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
