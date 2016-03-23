<?php

class MessageSourceController extends BackendController
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
        $model=new MessageSource;

        $this->performAjaxValidation($model);

        if(isset($_POST['MessageSource'])){
            $model->attributes=$_POST['MessageSource'];
            if($model->save()){
                Yii::app()->user->setFlash('messageSourceSuccess', Yii::t("translateModule", "Source <strong>{source}</strong> was created successfully!", array("{source}" => $model->message)));
                if(isset($_POST['Message']) && $_POST['Message']['translations'] && is_array($_POST['Message']['translations']) && (sizeof($_POST['Message']['translations'])>0)){
                    foreach($_POST['Message']['translations'] as $k=>$v){
                        $message = Message::model()->find('id=:id AND language=:lang', array(':id' => $model->id, ':lang'=>$k));
                        if(is_null($message)){
                            $messageModel = new Message();
                        }
                        else{
                            $messageModel = $message;
                        }
                        $messageModel->id = $model->id;
                        $messageModel->language = $k;
                        $messageModel->translation = $v;
                        $messageModel->save();
                    }
                }
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('messageSourceError', Yii::t("translateModule", "When create source <strong>{source}</strong> error occurred!", array("{source}" => $model->message)));
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'messageModel'=>new Message()
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

        if(isset($_POST['MessageSource'])){
            $model->attributes=$_POST['MessageSource'];
            if($model->save()){
                Yii::app()->user->setFlash('messageSourceSuccess', Yii::t("translateModule", "Source <strong>{source}</strong> was updated successfully!", array("{source}" => $model->message)));
                if(isset($_POST['Message']) && $_POST['Message']['translations'] && is_array($_POST['Message']['translations']) && (sizeof($_POST['Message']['translations'])>0)){
                    foreach($_POST['Message']['translations'] as $k=>$v){
                        $message = Message::model()->find('id=:id AND language=:lang', array(':id' => $model->id, ':lang'=>$k));
                        if(is_null($message)){
                            $messageModel = new Message();
                        }
                        else{
                            $messageModel = $message;
                        }
                        $messageModel->id = $model->id;
                        $messageModel->language = $k;
                        $messageModel->translation = $v;
                        $messageModel->save();
                    }
                    $this->redirect(array('index'));
                }

            }
            else{
                Yii::app()->user->setFlash('messageSourceError', Yii::t("translateModule", "When update source <strong>{source}</strong> error occurred!", array("{source}" => $model->message)));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
                'messageModel'=>new Message()
            )
        );
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id){
        //if(Yii::app()->request->isPostRequest){
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
        $model=new MessageSource('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['MessageSource'])){
            $model->attributes=$_GET['MessageSource'];
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
     * @return MessageSource
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=MessageSource::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='message-source-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
