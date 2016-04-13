<?php

class EventsGuestsController extends UserFrontendController
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
        $model=new EventsGuests;

        $this->performAjaxValidation($model);

        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['EventsGuests'])){
                $model->attributes=$_POST['EventsGuests'];
                $event = Events::model()->findByPk($_POST['EventsGuests']['event_id']);
                if(Yii::app()->user->getId() != $event->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }

                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule', "Guest {guestName} was added to event {eventName} successfully" , array('{guestName}' => $model->name, "{eventName}" => $event->name))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('eventsModule', "When add guest {guestName} to event {eventName} error occurred" , array('{guestName}' => $model->name, "{eventName}" => $event->name))
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
        if(Yii::app()->user->getId() != $model->event->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }

        $this->performAjaxValidation($model);
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['EventsGuests'])){
                $model->attributes=$_POST['EventsGuests'];
                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule', "Guest {guestName} was updated successfully",array('{guestName}' => $model->name))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('eventsModule', "When update guest {guestName} error occurred" , array('{guestName}' => $model->name))
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
            if(Yii::app()->user->getId() != $model->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }

            if(!is_null($model) && $model->delete()){
                echo CJSON::encode(
                    array(
                        'status' => 'success',
                        'message' => Yii::t('eventsModule', "Guest {guestName} was deleted successfully." , array('{guestName}' => $model->name))
                    )
                );
            }else{
                echo CJSON::encode(
                    array(
                        'status' => 'error',
                        'message' => Yii::t('eventsModule', "When delete guest {guestName} error occurred." , array('{guestName}' => $model->name))
                    )
                );
            }

        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionSetParty(){
        if(isset($_POST) && isset($_POST['party_id']) && isset($_POST['guest_id'])){
            $guest = EventsGuests::model()->findByAttributes(array('id' => $_POST['guest_id']));
            if(Yii::app()->user->getId() != $guest->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }

            $guest->party_id = (int)$_POST['party_id'];
            if($guest->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','Guest {guest} party was updated successfully', array("{guest}" => $guest->name))
                        )
                    );
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','When updated {guest} party error occurred', array("{guest}" => $guest->name))
                        )
                    );
                }
            }
        }
    }


    public function actionSetStatus(){
        if(isset($_POST) && isset($_POST['status_id']) && isset($_POST['guest_id'])){
            $guest = EventsGuests::model()->findByAttributes(array('id' => $_POST['guest_id']));
            if(Yii::app()->user->getId() != $guest->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }

            $guest->status_id = (int)$_POST['status_id'];
            if($guest->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','Guest {guest} status was updated successfully', array("{guest}" => $guest->name))
                        )
                    );
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule','When updated {guest} status error occurred', array("{guest}" => $guest->name))
                        )
                    );
                }
            }
        }
    }

    public function actionSetGuestsStatus(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0 && isset($_POST['status'])){
            foreach($_POST['ids'] as $id){
                $guest = EventsGuests::model()->findByPk((int)$id);
                if(Yii::app()->user->getId() != $guest->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }

                if(!is_null($guest)){
                    $guest->status_id = (int)$_POST['status'];
                    $guest->save();
                }
            }
            echo json_encode(true);
        }
        else{
            echo json_encode(false);
        }
    }

    public function actionSetGuestsParty(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0 && isset($_POST['party'])){
            foreach($_POST['ids'] as $id){
                $guest = EventsGuests::model()->findByPk((int)$id);
                if(Yii::app()->user->getId() != $guest->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                    throw new CHttpException(403,'Access denied!');
                }

                if(!is_null($guest)){
                    $guest->party_id = (int)$_POST['party'];
                    $guest->save();
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
            $guests = EventsGuests::model()->findAllByPk($_POST['ids']);
            if(sizeof($guests)>0){
                foreach($guests as $guest){
                    if(Yii::app()->user->getId() != $guest->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                        throw new CHttpException(403,'Access denied!');
                    }
                    $guest->delete();
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
     * @return EventsGuests
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=EventsGuests::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && ($_POST['ajax']==='events-guests-form' || $_POST['ajax']==='events-guests-add-form')){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
