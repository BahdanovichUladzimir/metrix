<?php

/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 25.11.2015
 */
class CalendarController extends UserFrontendController{

    public function actionCreate(){
        $model=new Calendar;

        if(isset($_POST['Calendar']['start']) && $_POST['Calendar']['start'] != 0){
            $_POST['Calendar']['start'] = DateTime::createFromFormat('!d.m.Y H:i', trim($_POST['Calendar']['start']))->format('U');
        }
        if(isset($_POST['Calendar']['end']) && $_POST['Calendar']['start'] != 0){
            $_POST['Calendar']['end'] = DateTime::createFromFormat('!d.m.Y H:i', trim($_POST['Calendar']['end']))->format('U');
        }

        $this->performAjaxValidation($model);

        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['Calendar'])){
                $model->attributes=$_POST['Calendar'];
                $deal = Deals::model()->findByPk($_POST['Calendar']['deal_id']);
                $this->_checkingAccess($deal);
                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule', "Event {name} was added to deal {dealName} calendar successfully" , array('{name}' => $model->title, "{dealName}" => $deal->name))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('dealsModule', "When add event {name} to deal {dealName} calendar error occurred" , array('{name}' => $model->title, "{dealName}" => $deal->name)),
                            'errors' => $model->getErrors(),
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
        $this->_checkingAccess($model->deal);

        if(isset($_POST['Calendar']['start']) && $_POST['Calendar']['start'] != 0){
            $_POST['Calendar']['start'] = DateTime::createFromFormat('!d.m.Y H:i', trim($_POST['Calendar']['start']))->format('U');
        }
        if(isset($_POST['Calendar']['end']) && $_POST['Calendar']['start'] != 0){
            $_POST['Calendar']['end'] = DateTime::createFromFormat('!d.m.Y H:i', trim($_POST['Calendar']['end']))->format('U');
        }

        $this->performAjaxValidation($model);
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['Calendar'])){
                $model->attributes=$_POST['Calendar'];
                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule', "Event {name} was updated successfully",array('{name}' => $model->title))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('dealsModule', "When update event {name} error occurred" , array('{name}' => $model->title)),
                            'errors' => $model->getErrors(),
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
            $this->_checkingAccess($model->deal);

            if(!is_null($model) && $model->delete()){
                echo CJSON::encode(
                    array(
                        'status' => 'success',
                        'message' => Yii::t('dealsModule', "Event {name} was deleted successfully." , array('{name}' => $model->title))
                    )
                );
            }else{
                echo CJSON::encode(
                    array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule', "When delete event {name} error occurred." , array('{name}' => $model->title)),
                        'errors' => $model->getErrors(),
                    )
                );
            }

        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * @param int $deal_id
     * @throws CException
     * @throws CHttpException
     */
    public function actionIndex($deal_id){
        $model = $this->loadDealModel($deal_id);
        $this->_checkingAccess($model);

        $this->layout = '//layouts/guests_list';
        $this->bgImage = '/images/todos_bg.jpg';
        $this->pageTitle = Yii::t('core',"Deal calendar");
        $this->pageDescription = Yii::t(
            'dealsModule',
            "<p>При составлении списка гостей на свадьбу помните о том, что это ваш праздник,
            и вы вправе приглашать только тех людей, которых хотите видеть на своем торжестве.
            Тем не менее, вам следует обязательно согласовать этот список со своей второй половинкой и родителями,
            и если появятся спорные вопросы, обязательно прийти к компромиссу.</p>"
        );
        $criteria = new CDbCriteria();
        $criteria->condition = "deal_id=:deal_id";
        $criteria->params = array(':deal_id'=> $model->id);
        $criteria->order = 'start ASC, end ASC';
        $dataProvider = new CActiveDataProvider('Calendar', array(
            'criteria'=>$criteria,
        ));
        /*$criteria = new CDbCriteria();
        $criteria->condition = 'status=:status AND event_id=:event_id';
        $criteria->params = array(
            ':status' => 2,
            ':event_id' => $event_id
        );
        $sizeOfReady = EventsDoings::model()->count($criteria);*/
        $scrollToElement = (isset($_GET['scrollToElement'])) ? $_GET['scrollToElement'] : NULL;


        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial(
                '_list',
                array(
                    'model'=>$model,
                    'dataProvider' => $dataProvider,
                    'calendarModel' => new Calendar(),
                    'scrollToElement' => $scrollToElement,
                    //'sizeOfReady' => $sizeOfReady
                ),
                false,
                true
            );
        }
        else{
            $this->render(
                'list',
                array(
                    'model'=>$model,
                    'dataProvider' => $dataProvider,
                    'calendarModel' => new Calendar(),
                    'scrollToElement' => $scrollToElement,
                    //'sizeOfReady' => $sizeOfReady
                )
            );
        }
    }



    public function actionSetType(){
        if(isset($_POST) && isset($_POST['type_id']) && isset($_POST['event_id'])){
            $event = Calendar::model()->findByAttributes(array('id' => $_POST['event_id']));
            $this->_checkingAccess($event->deal);
            $event->type = (int)$_POST['type_id'];
            if($event->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Event {name} type was updated successfully', array("{name}" => $event->title))
                        )
                    );
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','When updated event {name} type error occurred', array("{name}" => $event->title))
                        )
                    );
                }
            }
        }
    }

    public function actionSetEventsType(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0 && isset($_POST['type'])){
            foreach($_POST['ids'] as $id){
                $event = Calendar::model()->findByPk((int)$id);
                $this->_checkingAccess($event->deal);
                if(!is_null($event)){
                    $event->type = (int)$_POST['type'];
                    $event->save();
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
            $events = Calendar::model()->findAllByPk($_POST['ids']);
            if(sizeof($events)>0){
                foreach($events as $event){
                    $this->_checkingAccess($event->deal);
                    $event->delete();
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
     * @return Calendar
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Calendar::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @param $id
     * @return Deals
     * @throws CHttpException
     */
    public function loadDealModel($id){
        $model=Deals::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * @param Deals $deal
     * @throws CHttpException
     */
    private function _checkingAccess(Deals $deal){
        if(Yii::app()->user->getId() != $deal->user_id && !Yii::app()->getModule('user')->isAdmin()){
            throw new CHttpException(403,'Access denied.');
        }
        if(!$deal->isShowCalendar){
            throw new CHttpException(403,'Access denied.');
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model){
        if(isset($_POST['ajax']) && ($_POST['ajax']==='calendar-event-add-form' || $_POST['ajax']==='calendar-event-form_'.$model->id)){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}