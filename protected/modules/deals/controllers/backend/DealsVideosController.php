<?php

class DealsVideosController extends BackendController
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
    /*public function actionCreate(){
        $model=new DealsVideos;

        $this->performAjaxValidation($model);

        if(isset($_POST['DealsVideos'])){
            $model->attributes=$_POST['DealsVideos'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }*/

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    /*public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['DealsVideos'])){
            $model->attributes=$_POST['DealsVideos'];
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
    }*/

    /**
     * @param integer $id Image id
     */
    public function actionApprove($id){
        $video = DealsVideos::model()->with('deal')->findByPk((int)$id);
        if(!is_null($video)) {
            $video->approve = 1;
            $save = $video->save();
            /*if($save){
                if(!is_null($video->deal->user) && !is_null($video->deal->user->email) && strlen(trim($video->deal->user->email))>0){
                    $name = (!is_null($video->alias) && strlen(trim($video->alias))>0) ? $video->alias : $video->file_name;
                    $message = Yii::t(
                        'dealsModule',
                        "Dear userName! Video \"name\" was approved by the moderator.",
                        array(
                            'userName' => $video->deal->user->username,
                            'name' => $name
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $video->deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $video->deal->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$video->deal->user_id,$message);

                }

            }*/
            echo json_encode($save);
        }
    }

    /**
     *
     */
    public function actionApproveSelected(){
        if(isset($_POST) && isset($_POST['value'])){
            foreach($_POST['value'] as $id){
                $video = DealsVideos::model()->with('deal')->findByPk((int)$id);
                if(!is_null($video)){
                    $video->approve = 1;
                    $save = $video->save();
                    /*if($save){
                        if(!is_null($video->deal->user) && !is_null($video->deal->user->email) && strlen(trim($video->deal->user->email))>0){
                            $name = (!is_null($video->alias) && strlen(trim($video->alias))>0) ? $video->alias : $video->file_name;
                            $message = Yii::t(
                                'dealsModule',
                                "Dear userName! Video \"name\" was approved by the moderator.",
                                array(
                                    'userName' => $video->deal->user->username,
                                    'name' => $name
                                )
                            );
                            $messagesModel = new EmailMessages();
                            $messagesModel->from = Yii::app()->params['adminEmail'];
                            $messagesModel->to = $video->deal->user->email;
                            $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                            $messagesModel->message = $message;
                            $messagesModel->type_id = 1;
                            $messagesModel->is_sent = 0;
                            $messagesModel->created_date = time();
                            $messagesModel->recipient_id = $video->deal->user->id;
                            $messagesModel->save();
                            UserMessages::sendMessage(1,$video->deal->user_id,$message);
                        }
                    }*/
                }
            }
            echo json_encode(true);
        }
        echo json_encode(false);
    }

    /**
     * @param integer $id Image id
     */
    public function actionUnApprove($id){
        $video = DealsVideos::model()->with('deal')->findByPk((int)$id);
        if(!is_null($video)) {
            $video->approve = 0;
            $save = $video->save();
            /*if($save){
                if(!is_null($video->deal->user) && !is_null($video->deal->user->email) && strlen(trim($video->deal->user->email))>0){
                    $name = (!is_null($video->alias) && strlen(trim($video->alias))>0) ? $video->alias : $video->file_name;
                    $message = Yii::t(
                        'dealsModule',
                        "Dear userName! Video \"name\" was declined by the moderator.",
                        array(
                            'userName' => $video->deal->user->username,
                            'name' => $name
                        )
                    );
                    $messagesModel = new EmailMessages();
                    $messagesModel->from = Yii::app()->params['adminEmail'];
                    $messagesModel->to = $video->deal->user->email;
                    $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
                    $messagesModel->message = $message;
                    $messagesModel->type_id = 1;
                    $messagesModel->is_sent = 0;
                    $messagesModel->created_date = time();
                    $messagesModel->recipient_id = $video->deal->user->id;
                    $messagesModel->save();
                    UserMessages::sendMessage(1,$video->deal->user_id,$message);
                }

            }*/
            echo json_encode($save);
        }
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
        $model=new DealsVideos('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsVideos'])){
            $model->attributes=$_GET['DealsVideos'];
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
        $model=DealsVideos::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-videos-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
