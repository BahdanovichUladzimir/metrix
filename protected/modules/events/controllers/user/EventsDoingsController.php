<?php

class EventsDoingsController extends UserFrontendController
{

    public function actionCreate(){
        $model=new EventsDoings;

        $this->performAjaxValidation($model);

        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['EventsDoings'])){
                $model->attributes=$_POST['EventsDoings'];
                $event = Events::model()->findByPk($_POST['EventsDoings']['event_id']);
                if(Yii::app()->user->getId() != $event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                    throw new CHttpException(403,'Access denied!');
                }

                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule', "To-do {name} was added to event {eventName} successfully" , array('{name}' => $model->name, "{eventName}" => $event->name))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('eventsModule', "When add to-do {name} to event {eventName} error occurred" , array('{name}' => $model->name, "{eventName}" => $event->name))
                        )
                    );
                }
            }

        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

    }


    /**
     * @param int $id
     * @throws CHttpException
     */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        if(Yii::app()->user->getId() != $model->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
            throw new CHttpException(403,'Access denied!');
        }

        $this->performAjaxValidation($model);
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['EventsDoings'])){
                $model->attributes=$_POST['EventsDoings'];
                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule', "To-do {name} was updated successfully",array('{name}' => $model->name))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('eventsModule', "When update to-do {name} error occurred" , array('{name}' => $model->name))
                        )
                    );
                }
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }

    }

    /**
     * @param int $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id){
        if(Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest){
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            if(Yii::app()->user->getId() != $model->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                throw new CHttpException(403,'Access denied!');
            }

            if(!is_null($model) && $model->delete()){
                echo CJSON::encode(
                    array(
                        'status' => 'success',
                        'message' => Yii::t('eventsModule', "To-do {name} was deleted successfully." , array('{name}' => $model->name))
                    )
                );
            }else{
                echo CJSON::encode(
                    array(
                        'status' => 'error',
                        'message' => Yii::t('eventsModule', "When delete to-do {name} error occurred." , array('{name}' => $model->name))
                    )
                );
            }

        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * @param int $event_id
     * @throws CException
     * @throws CHttpException
     */
    public function actionIndex($event_id){
        $model = $this->loadEventsModel($event_id);
        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isAdmin()){
            throw new CHttpException(403,'Access denied!');
        }

        $this->layout = '//layouts/guests_list';
        $this->bgImage = '/images/todos_bg.jpg';
        $this->pageTitle = Yii::t('core',"To-do list for the event {name}", array('{name}'=>$model->name));
        $this->title = Yii::t('core',"To-do list for the event {name}", array('{name}'=>$model->name));
        $this->pageDescription = Yii::t(
            'eventsModule',
            "<p>При составлении списка гостей на свадьбу помните о том, что это ваш праздник,
            и вы вправе приглашать только тех людей, которых хотите видеть на своем торжестве.
            Тем не менее, вам следует обязательно согласовать этот список со своей второй половинкой и родителями,
            и если появятся спорные вопросы, обязательно прийти к компромиссу.</p>"
        );
        $criteria = new CDbCriteria();
        $criteria->condition = "event_id=:event_id";
        $criteria->params = array(':event_id'=> $model->id);
        $criteria->order = 'category_id ASC';
        $dataProvider = new CActiveDataProvider('EventsDoings', array(
            'criteria'=>$criteria,
        ));
        $criteria = new CDbCriteria();
        $criteria->condition = 'status=:status AND event_id=:event_id';
        $criteria->params = array(
            ':status' => 2,
            ':event_id' => $event_id
        );
        $sizeOfReady = EventsDoings::model()->count($criteria);
        $scrollToElement = (isset($_GET['scrollToElement'])) ? $_GET['scrollToElement'] : NULL;


        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial(
                '_doings_list',
                array(
                    'model'=>$model,
                    'dataProvider' => $dataProvider,
                    'doingsModel' => new EventsDoings(),
                    'sizeOfReady' => $sizeOfReady,
                    'scrollToElement' => $scrollToElement

                ),
                false,
                true
            );
        }
        else{
            $this->render(
                'doings_list',
                array(
                    'model'=>$model,
                    'dataProvider' => $dataProvider,
                    'doingsModel' => new EventsDoings(),
                    'sizeOfReady' => $sizeOfReady,
                    'scrollToElement' => $scrollToElement

                )
            );
        }
    }

    public function actionSetCategory(){
        if(isset($_POST) && isset($_POST['category_id']) && isset($_POST['doing_id'])){
            $doing = EventsDoings::model()->findByAttributes(array('id' => $_POST['doing_id']));
            if(Yii::app()->user->getId() != $doing->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                throw new CHttpException(403,'Access denied!');
            }

            $doing->category_id = (int)$_POST['category_id'];
            if($doing->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','To-do {name} category was updated successfully', array("{name}" => $doing->name))
                        )
                    );
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','When updated {name} category error occurred', array("{name}" => $doing->name))
                        )
                    );
                }
            }
        }
    }


    public function actionSetStatus(){
        if(isset($_POST) && isset($_POST['status_id']) && isset($_POST['doing_id'])){
            $doing = EventsDoings::model()->findByAttributes(array('id' => $_POST['doing_id']));
            if(Yii::app()->user->getId() != $doing->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                throw new CHttpException(403,'Access denied!');
            }

            $doing->status = (int)$_POST['status_id'];
            if($doing->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','To-do {name} status was updated successfully', array("{name}" => $doing->name))
                        )
                    );
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','When updated {name} status error occurred', array("{name}" => $doing->name))
                        )
                    );
                }
            }
        }
    }

    public function actionSetDoingsStatus(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0 && isset($_POST['status'])){
            foreach($_POST['ids'] as $id){
                $doing = EventsDoings::model()->findByPk((int)$id);
                if(Yii::app()->user->getId() != $doing->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                    throw new CHttpException(403,'Access denied!');
                }

                if(!is_null($doing)){
                    $doing->status = (int)$_POST['status'];
                    $doing->save();
                }
            }
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    public function actionSetDoingsCategory(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0 && isset($_POST['category_id'])){
            foreach($_POST['ids'] as $id){
                $doing = EventsDoings::model()->findByPk((int)$id);
                if(Yii::app()->user->getId() != $doing->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                    throw new CHttpException(403,'Access denied!');
                }

                if(!is_null($doing)){
                    $doing->category_id = (int)$_POST['category_id'];
                    $doing->save();
                }
            }
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    public function actionDeleteSelected(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0){
            $doings = EventsDoings::model()->findAllByPk($_POST['ids']);
            if(sizeof($doings)>0){
                foreach($doings as $doing){
                    if(Yii::app()->user->getId() != $doing->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
                        throw new CHttpException(403,'Access denied!');
                    }
                    $doing->delete();
                }
            }
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }


    /**
     * @param $id
     * @return array|mixed|null EventsDoings
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=EventsDoings::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @param $id
     * @return array|mixed|null Events
     * @throws CHttpException
     */
    public function loadEventsModel($id){
        $model=Events::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && ($_POST['ajax']==='events-doings-form' || $_POST['ajax']==='events-doings-add-form')){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
