<?php

class DialoguesController extends UserFrontendController
{

    public function actionIndex(){
        $user_id = Yii::app()->user->getId();
        if(is_null($user_id)){
            throw new CHttpException(403, Yii::t("core","Access denied"));
        }
        $criteria = new CDbCriteria();
        $criteria->with = array('userMessages');
        $criteria->together = true;
        $criteria->condition = '(t.sender_id=:sender_id AND sender_messages>:sender_messages) OR (t.receiver_id=:sender_id AND receiver_messages>:sender_messages)';
        $criteria->params = array(
            ':sender_id' => $user_id,
            ':sender_messages' => 0,
        );
        $criteria->order = 'userMessages.created_at DESC';
        $dialogues = Dialogues::model()->findAll($criteria);
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.jscrollpane.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jscrollpane.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.mousewheel.js');
        $this->render(
            'index',
            array(
                'dialogues'=>$dialogues,
            )
        );
    }

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id){
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.jscrollpane.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jscrollpane.min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.mousewheel.js');
        $this->render(
            'view',
            array(
                'model'=>$this->loadModel($id),
            )
        );
    }

    /**
     * @param $receiver_id
     * @throws CHttpException
     */
    /*public function actionCreate($receiver_id){
        $user_id = Yii::app()->user->getId();
        if($user_id == $receiver_id){
            throw new CHttpException(403,'You can\'t create this dialog');
        }
        $criteria = new CDbCriteria();
        $criteria->condition = '(receiver_id=:receiver_id AND sender_id=:sender_id) OR (receiver_id=:sender_id AND sender_id=:receiver_id)';
        $criteria->params = array(
            ':receiver_id' => (int)$receiver_id,
            ':sender_id' => $user_id
        );
        $dialog = Dialogues::model()->find($criteria);

        $criteria = new CDbCriteria();
        $criteria->condition = '(sender_id=:sender_id AND sender_messages>:sender_messages) OR (receiver_id=:sender_id AND receiver_messages>:sender_messages)';
        $criteria->params = array(
            ':sender_id' => $user_id,
            ':sender_messages' => 0,
        );
        $dialogues = Dialogues::model()->findAll($criteria);
        $receiver = User::model()->findByPk($receiver_id);
        $sender_id = Yii::app()->user->getId();
        $sender = User::model()->findByPk($sender_id);

        $criteria = new CDbCriteria;
        $criteria->condition = 'dialog_id=:dialog_id';
        $criteria->params = array(
            ':dialog_id' => $dialog->id
        );
        //$criteria->order = 't.create_datetime DESC';

        $dataProvider = new CActiveDataProvider('UserMessages', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>5,
            ),
        ));
        $this->render('create',array(
            'receiver'=>$receiver,
            'sender'=>$sender,
            'dialogues' => $dialogues,
            'dialog' => $dialog,
            'dataProvider' => $dataProvider
        ));
    }*/

    /**
     * @param $receiver_id
     * @throws CHttpException
     */
    public function actionDialog($receiver_id){
        $userId = Yii::app()->user->getId();
        if($userId == $receiver_id){
            throw new CHttpException(403,'You can\'t create this dialog');
        }
        $criteria = new CDbCriteria();

        $criteria->condition = '(receiver_id=:receiver_id AND sender_id=:sender_id) OR (receiver_id=:sender_id AND sender_id=:receiver_id)';
        $criteria->params = array(
            ':receiver_id' => (int)$receiver_id,
            ':sender_id' => $userId
        );
        $dialog = Dialogues::model()->find($criteria);

        $criteria = new CDbCriteria();
        $criteria->with = array('userMessages');
        $criteria->together = true;

        $criteria->condition = '(t.sender_id=:sender_id AND sender_messages>:sender_messages) OR (t.receiver_id=:sender_id AND receiver_messages>:sender_messages)';
        $criteria->params = array(
            ':sender_id' => $userId,
            ':sender_messages' => 0,
        );
        $criteria->order = 'userMessages.created_at DESC';

        $dialogues = Dialogues::model()->findAll($criteria);
        $receiver = User::model()->findByPk($receiver_id);
        $sender_id = Yii::app()->user->getId();
        $sender = User::model()->findByPk($sender_id);

        $this->processPageRequest('page');

        $criteria = new CDbCriteria;
        $criteria->condition = 'dialog_id=:dialog_id AND ((`t`.`sender_id`=:user_id AND (`t`.`deleted_by`!="sender" OR `t`.`deleted_by` IS NULL)) OR (`t`.`sender_id`!=:user_id AND (`t`.`deleted_by`!="receiver" OR `t`.`deleted_by` IS NULL)))';
        $criteria->params = array(
            ':dialog_id' => isset($dialog) ? $dialog->id : 0,
            ':user_id' => $userId
        );
        $criteria->order = 't.created_at DESC';

        $dataProvider = new CActiveDataProvider('UserMessages', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>5,
                'pageVar' =>'page',
            ),
        ));
        $dataProvider->setData(array_reverse($dataProvider->getData()));
        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$dataProvider,
                'receiver'=>$receiver,
            ));
            Yii::app()->end();
        }
        else{
            Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.jscrollpane.css');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jscrollpane.min.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.mousewheel.js');
            $this->render('dialog',array(
                'receiver'=>$receiver,
                'sender'=>$sender,
                'dialogues' => $dialogues,
                'dialog' => $dialog,
                'dataProvider' => $dataProvider
            ));
        }

    }


    /**
     * @throws CHttpException
     */
    public function actionDelete(){
        if(Yii::app()->request->isPostRequest && isset($_POST['dialog_id'])){
            // we only allow deletion via POST request
            $model = $this->loadModel((int)$_POST['dialog_id']);
            if(Yii::app()->request->isAjaxRequest){
                if($model->userDelete()){
                    echo CJSON::encode(array(
                        'dialog_id' => $model->id,
                        'status' => 'success',
                        'message' => Yii::t('messagesModule',"Dialog was deleted successfully")
                    ));
                }
                else{
                    echo CJSON::encode(array(
                        'dialog_id' => $model->id,
                        'status' => 'success',
                        'message' => Yii::t('messagesModule',"When deleting dialog error occurred")
                    ));
                }
            };
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * @param $id
     * @return Dialogues
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Dialogues::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='dialogues-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
}
