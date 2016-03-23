<?php

class UserMessagesController extends UserFrontendController
{

    public function actionLoadMessages($page){

    }

    public function actionCreate(){
        $model=new UserMessages();
        $this->performAjaxValidation($model);

        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['receiver_id'])){
                $criteria = new CDbCriteria();
                $criteria->condition = '(receiver_id=:receiver_id AND sender_id=:sender_id) OR (receiver_id=:sender_id AND sender_id=:receiver_id)';
                $criteria->params = array(
                    ':receiver_id' => (int)$_POST['receiver_id'],
                    ':sender_id' => Yii::app()->user->getId()
                );
                $dialog = Dialogues::model()->find($criteria);
                if(is_null($dialog)){
                    $dialog = new Dialogues();
                    $dialog->sender_id = Yii::app()->user->getId();
                    $dialog->receiver_id = (int)$_POST['receiver_id'];
                }
                if($dialog->save()){
                    $message = new UserMessages();
                    $message->created_at = time();
                    $message->body = CHtml::encode($_POST['text']);
                    $message->sender_id = Yii::app()->user->getId();
                    $message->dialog_id = $dialog->id;
                    if($message->save()){
                        $html = $this->renderPartial(
                            '_message',
                            array(
                                'data'=>$message
                            ),
                            true
                        );
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('messagesModule',"Message was sent successfully!"),
                            'message_id' => $message->id,
                            'html' => $html
                        ));
                    }
                    else{
                        $message->addError("body",Yii::t('messagesModule',"When you sent a message undefined error occurred"));
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $message->getError("body")
                        ));
                    }
                }
                else{
                    $dialog->addError("sender_id",Yii::t('messagesModule',"When you sent a message undefined error occurred"));
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => $dialog->getError("sender_id")
                    ));
                }
            }
            else{
                throw new CHttpException(403,"Access denied");
            }
        }
        else{
            throw new CHttpException(403,"Access denied");
        }


    }


    public function actionRead(){
        if(Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest && isset($_POST['message_id'])){

            $message_id = (int)$_POST['message_id'];
            $message = UserMessages::model()->findByPk($message_id);
            if(Yii::app()->user->getId() == $message->receiverId){
                $message->is_read = 1;
                if($message->save()){
                    $message->recountUserNewMessages();
                    echo json_encode(
                        array(
                            'status' => 'success',
                            'message_id' => $message_id,
                            'dialog_id' => (int)$message->dialog_id,
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'status' => 'error',
                            'message_id' => $message_id,
                            'dialog_id' => (int)$message->dialog_id,
                        )
                    );
                }
            }
        }
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['UserMessages'])){
            $model->attributes=$_POST['UserMessages'];
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

    /**
     * @throws CHttpException
     */
    public function actionDelete(){
        if(Yii::app()->request->isPostRequest && isset($_POST['message_id'])){
            $model = $this->loadModel((int)$_POST['message_id']);
            if($model->userDelete()){
                echo CJSON::encode(
                    array(
                        'status' => 'success',
                        'message' => Yii::t("messagesModule","Message was deleted successfully."),
                        'message_id' => $model->id
                    )
                );
            }
            else{
                echo CJSON::encode(
                    array(
                        'status' => 'error',
                        'message' => Yii::t("messagesModule","When deleting message error occurred."),
                        'message_id' => $model->id
                    )
                );
            }
            /*if(is_null($model->deleted_by)){
                if($user_id == $model->sender_id){
                    $model->deleted_by = 'sender';
                }
                elseif($user_id == $model->receiverId){
                    $model->deleted_by = 'receiver';
                }
                if($model->save()){
                    $model->recountDialogMessages();
                    echo json_encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t("messagesModule","Message was deleted successfully."),
                            'message_id' => $model->id
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'status' => 'error',
                            'message' => $model->getErrorsString(),
                            'message_id' => $model->id
                        )
                    );
                }
            }
            else{
                $deletedBy = $model->deleted_by;
                if($deletedBy == "sender"){
                    if($user_id == $model->receiverId){
                        if($model->delete()){
                            $model->recountDialogMessages();
                            echo json_encode(
                                array(
                                    'status' => 'success',
                                    'message' => Yii::t("messagesModule","Message was deleted successfully."),
                                    'message_id' => $model->id
                                )
                            );
                        }
                        else{
                            echo json_encode(
                                array(
                                    'status' => 'error',
                                    'message' => Yii::t("messagesModule","When delete message error occurred."),
                                    'message_id' => $model->id
                                )
                            );
                        }
                    }
                    elseif($user_id == $model->sender_id){
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t("messagesModule","You have removed this post."),
                                'message_id' => $model->id
                            )
                        );
                    }
                    else{
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t("messagesModule","You can't delete this message."),
                                'message_id' => $model->id
                            )
                        );
                    }
                }
                elseif($deletedBy == "receiver"){
                    if($user_id == $model->sender_id){
                        if($model->delete()){
                            $model->recountDialogMessages();
                            echo json_encode(
                                array(
                                    'status' => 'success',
                                    'message' => Yii::t("messagesModule","Message was deleted successfully."),
                                    'message_id' => $model->id
                                )
                            );
                        }
                        else{
                            echo json_encode(
                                array(
                                    'status' => 'error',
                                    'message' => Yii::t("messagesModule","When delete message error occurred."),
                                    'message_id' => $model->id
                                )
                            );
                        }
                    }
                    elseif($user_id == $model->receiverId){
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t("messagesModule","You have removed this post."),
                                'message_id' => $model->id
                            )
                        );
                    }
                    else{
                        echo json_encode(
                            array(
                                'status' => 'error',
                                'message' => Yii::t("messagesModule","You can't delete this message."),
                                'message_id' => $model->id
                            )
                        );
                    }
                }
            }*/
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * @param $id
     * @return UserMessages
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=UserMessages::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-messages-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
