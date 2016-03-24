<?php

class DailySchedulesEventsController extends BackendController
{

    public function actionCreate(){
        $model=new DailySchedulesEvents();

        $this->performAjaxValidation($model);

        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['DailySchedulesEvents'])){
                $model->attributes=$_POST['DailySchedulesEvents'];
                $schedule = DailySchedules::model()->findByPk((int)$_POST['DailySchedulesEvents']['schedule_id']);
                $this->_checkingAccess($schedule);

                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule', "Event {name} was added to schedule {eventName} successfully" , array('{name}' => $model->name, "{eventName}" => $schedule->publicDate))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('eventsModule', "When add event {name} to schedule {eventName} error occurred" , array('{name}' => $model->name, "{eventName}" => $schedule->publicDate))
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
        $this->_checkingAccess($model->schedule);

        $this->performAjaxValidation($model);
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['DailySchedulesEvents'])){
                $model->attributes=$_POST['DailySchedulesEvents'];
                if($model->save()){
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t('eventsModule', "Event {name} was updated successfully",array('{name}' => $model->name))
                        )
                    );
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t('eventsModule', "When update event {name} error occurred" , array('{name}' => $model->name))
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
            $this->_checkingAccess($model->schedule);

            if(!is_null($model) && $model->delete()){
                echo CJSON::encode(
                    array(
                        'status' => 'success',
                        'message' => Yii::t('eventsModule', "Event {name} was deleted successfully." , array('{name}' => $model->name))
                    )
                );
            }else{
                echo CJSON::encode(
                    array(
                        'status' => 'error',
                        'message' => Yii::t('eventsModule', "When delete event {name} error occurred." , array('{name}' => $model->name))
                    )
                );
            }

        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionDeleteSelected(){
        if(isset($_POST) && isset($_POST['ids']) && sizeof($_POST['ids'])>0){
            $events = DailySchedulesEvents::model()->findAllByPk($_POST['ids']);
            if(sizeof($events)>0){
                foreach($events as $event){
                    $this->_checkingAccess($event->schedule);
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
     * @return DailySchedulesEvents
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DailySchedulesEvents::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && ($_POST['ajax']==='daily-schedules-events-form' || $_POST['ajax']==='daily-schedules-events-add-form')){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @param DailySchedules $schedule
     * @throws CHttpException
     */
    private function _checkingAccess(DailySchedules $schedule){
        if(Yii::app()->user->getId() != $schedule->event->user_id && !Yii::app()->getModule('user')->isAdmin()){
            throw new CHttpException(403,'Access denied.');
        }
    }
}
