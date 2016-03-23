<?php

class FeedbackQuestionsStatusesController extends BackendController
{


    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new FeedbackQuestionsStatuses;

        $this->performAjaxValidation($model);

        if(isset($_POST['FeedbackQuestionsStatuses'])){
            $model->attributes=$_POST['FeedbackQuestionsStatuses'];
            if($model->save()){
                Yii::app()->user->setFlash('feedbackQuestionsStatusesSuccess', Yii::t("feedbackModule", "Questions status <strong>{status}</strong> was created successfully!", array("{status}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('feedbackQuestionsStatusesError', Yii::t("feedbackModule", "When create questions status <strong>{status}</strong> error occurred!", array("{status}" => $model->name)));
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

        if(isset($_POST['FeedbackQuestionsStatuses'])){
            $model->attributes=$_POST['FeedbackQuestionsStatuses'];
            if($model->save()){
                Yii::app()->user->setFlash('feedbackQuestionsStatusesSuccess', Yii::t("feedbackModule", "Questions status <strong>{status}</strong> was updated successfully!", array("{status}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('feedbackQuestionsStatusesError', Yii::t("feedbackModule", "When update questions status <strong>{status}</strong> error occurred!", array("{status}" => $model->name)));
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
        $model=new FeedbackQuestionsStatuses('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['FeedbackQuestionsStatuses'])){
            $model->attributes=$_GET['FeedbackQuestionsStatuses'];
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
     * @return FeedbackQuestionsStatuses
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=FeedbackQuestionsStatuses::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-questions-statuses-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
