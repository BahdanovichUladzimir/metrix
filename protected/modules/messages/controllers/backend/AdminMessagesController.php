<?php

/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.10.2015
 */
class AdminMessagesController extends BackendController{

    public function actionCreate(){

        $model=new AdminMessageForm();

        $this->performAjaxValidation($model);

        if(isset($_POST['AdminMessageForm'])){
            $model->attributes=$_POST['AdminMessageForm'];
            if($model->send()){
                Yii::app()->user->setFlash('messagesBackendAdminMessagesSuccess', Yii::t("messagesModule", "Message was sent successfully!"));
            }
            else{
                Yii::app()->user->setFlash('messagesBackendAdminMessagesError', Yii::t("messagesModule", "When send message error occurred!"));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='admin-message-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}