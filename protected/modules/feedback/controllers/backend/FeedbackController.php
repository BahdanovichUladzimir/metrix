<?php

class FeedbackController extends BackendController
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
        $model=new Feedback;

        $this->performAjaxValidation($model);

        if(isset($_POST['Feedback'])){
            $model->attributes=$_POST['Feedback'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
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

        if(isset($_POST['Feedback'])){
            $model->attributes=$_POST['Feedback'];
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
    }

    public function actionReply($id){

        $model=$this->loadModel($id);
        if($model->status_id == 1){
            throw new CHttpException(403, Yii::t('feedbackModule','Access denied. Message was replied earlier.'));
        }
        $model->setScenario("adminReply");
        $this->performAjaxValidation($model);

        if(isset($_POST['Feedback'])){
            $model->attributes=$_POST['Feedback'];
            $model->recipient_id = Yii::app()->user->getId();
            $model->status_id = 1;
            $model->reply_date = time();

            if($model->save()){
                //@todo Сделать нормальное сообщение
                /*UserModule::sendSmtpMail(
                    $model->user_email,
                    "From ".Yii::app()->name,
                    Yii::t('feedbackModule', $model->title),
                    $model->reply
                );*/
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render(
            'reply',
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
        $model=new Feedback('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Feedback'])){
            $model->attributes=$_GET['Feedback'];
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
     * @return Feedback
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Feedback::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
