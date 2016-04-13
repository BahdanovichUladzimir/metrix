<?php

class DealsImagesController extends BackendController
{
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
        $model=new DealsImages('search');
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
        $image = DealsImages::model()->with('deal')->findByPk((int)$id);
        if(!is_null($image)) {
            $image->approve = 1;
            $save = $image->save();
            /*if($save){
                if(!is_null($image->deal->user) && !is_null($image->deal->user->email) && strlen(trim($image->deal->user->email))>0){
                    $name = (!is_null($image->alias) && strlen(trim($image->alias))>0) ? $image->alias : $image->file_name;
                    $message = Yii::t(
                        'dealsModule',
                        "Dear userName! Image \"image\" was approved by the moderator.",
                        array(
                            'userName' => $image->deal->user->username,
                            'image' => $name
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $image->deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $image->deal->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$image->deal->user_id,$message);
                }

            }*/
            if($save){
                echo json_encode($save);
            }
            else{
                echo json_encode($image->getErrors());
            }
        }
        else{
            echo json_encode(false);
        }
    }

    /**
     *
     */
    public function actionApproveSelected(){
        if(isset($_POST) && isset($_POST['value']) && sizeof($_POST['value'])>0){
            foreach($_POST['value'] as $id){
                $image = DealsImages::model()->with('deal')->findByPk((int)$id);
                if(!is_null($image)){
                    $image->approve = 1;
                    $save = $image->save();

                    /*if($save){
                        if(!is_null($image->deal->user) && !is_null($image->deal->user->email) && strlen(trim($image->deal->user->email))>0){
                            $name = (!is_null($image->alias) && strlen(trim($image->alias))>0) ? $image->alias : $image->file_name;
                            $message = Yii::t(
                                'dealsModule',
                                "Dear userName! Image \"image\" was approved by the moderator.",
                                array(
                                    'userName' => $image->deal->user->username,
                                    'image' => $name
                                )
                            );
                            $messagesModel = new EmailMessages();
                            $messagesModel->from = Yii::app()->params['adminEmail'];
                            $messagesModel->to = $image->deal->user->email;
                            $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                            $messagesModel->message = $message;
                            $messagesModel->type_id = 1;
                            $messagesModel->is_sent = 0;
                            $messagesModel->created_date = time();
                            $messagesModel->recipient_id = $image->deal->user->id;
                            $messagesModel->save();
                            UserMessages::sendMessage(1,$image->deal->user_id,$message);

                        }
                    }*/
                }
            }
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    /**
     * @param integer $id Image id
     */
    public function actionUnApprove($id){
        $image = DealsImages::model()->with('deal')->findByPk((int)$id);
        if(!is_null($image)) {
            $image->approve = 0;
            $save = $image->save();
            /*if ($save) {
                if (!is_null($image->deal->user) && !is_null($image->deal->user->email) && strlen(trim($image->deal->user->email)) > 0) {
                    $name = (!is_null($image->alias) && strlen(trim($image->alias)) > 0) ? $image->alias : $image->file_name;
                    $message = Yii::t(
                        'dealsModule',
                        "Dear userName! Image \"image\" was declined by the moderator.",
                        array(
                            'userName' => $image->deal->user->username,
                            'image' => $name
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $image->deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $image->deal->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$image->deal->user_id,$message);

                }

            }*/
            echo json_encode($save);
        }
        else{
            echo json_encode(false);
        }
    }

    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id){
        $model=DealsImages::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-images-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
