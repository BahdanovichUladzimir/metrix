<?php

class DealsLinksController extends BackendController
{

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
        $model=new DealLinks('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsImages'])){
            $model->attributes=$_GET['DealsImages'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    /**
     * @param integer $id Image id
     */
    public function actionApprove($id){
        $link = DealLinks::model()->with('deal')->findByPk((int)$id);
        if(!is_null($link)) {
            $link->approve = 1;
            $save = $link->save();
            /*if($save){
                if(!is_null($link->deal->user) && !is_null($link->deal->user->email) && strlen(trim($link->deal->user->email))>0){
                    $name = (!is_null($link->alias) && strlen(trim($link->alias))>0) ? $link->alias : $link->link;
                    $message = Yii::t(
                        'dealsModule',
                        "Dear userName! Video \"name\" was approved by the moderator.",
                        array(
                            'userName' => $link->deal->user->username,
                            'name' => $name
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $link->deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $link->deal->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$link->deal->user_id,$message);
                }

            }*/
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
        if(isset($_POST) && isset($_POST['value'])){
            foreach($_POST['value'] as $id){
                $link = DealLinks::model()->with('deal')->findByPk((int)$id);
                if(!is_null($link)){
                    $link->approve = 1;
                    $save = $link->save();
                    /*if($save){
                        if(!is_null($link->deal->user) && !is_null($link->deal->user->email) && strlen(trim($link->deal->user->email))>0){
                            $name = (!is_null($link->alias) && strlen(trim($link->alias))>0) ? $link->alias : $link->link;
                            $message = Yii::t(
                                'dealsModule',
                                "Dear userName! Video \"name\" was approved by the moderator.",
                                array(
                                    'userName' => $link->deal->user->username,
                                    'name' => $name
                                )
                            );
                            $messagesModel = new EmailMessages();
                            $messagesModel->from = Yii::app()->params['adminEmail'];
                            $messagesModel->to = $link->deal->user->email;
                            $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                            $messagesModel->message = $message;
                            $messagesModel->type_id = 1;
                            $messagesModel->is_sent = 0;
                            $messagesModel->created_date = time();
                            $messagesModel->recipient_id = $link->deal->user->id;
                            $messagesModel->save();
                            UserMessages::sendMessage(1,$link->deal->user_id,$message);
                        }
                    }*/
                }
            }
            echo json_encode(true);
        }
        echo json_encode(false);

    }

    /**
     * @param integer $id Link id
     */
    public function actionUnApprove($id){
        $link = DealLinks::model()->with('deal')->findByPk((int)$id);
        if(!is_null($link)) {
            $link->approve = 0;
            $save = $link->save();
            /*if($save){
                if(!is_null($link->deal->user) && !is_null($link->deal->user->email) && strlen(trim($link->deal->user->email))>0){
                    $name = (!is_null($link->alias) && strlen(trim($link->alias))>0) ? $link->alias : $link->link;
                    $message = Yii::t(
                        'dealsModule',
                        "Dear userName! Video \"name\" was declined by the moderator.",
                        array(
                            'userName' => $link->deal->user->username,
                            'name' => $name
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $link->deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $link->deal->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$link->deal->user_id,$message);
                }

            }*/
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }
    }

    /**
     * @param $id
     * @return DealLinks
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealLinks::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-links-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
