<?php

class DailySchedulesController extends UserFrontendController
{

    /**
     * @param int|string $id
     * @throws CHttpException
     */
    public function actionView($id){
        $model = $this->loadModel($id);
        if(Yii::app()->user->getId() != $model->event->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }

        $this->layout = '//layouts/guests_list';
        $this->bgImage = '/images/todos_bg.jpg';
        $this->pageTitle = Yii::t('eventsModule',"Daily schedule for {date}", array('{date}'=>$model->publicDate));
        $this->title = Yii::t('eventsModule',"Daily schedule for {date}", array('{date}'=>$model->publicDate));
        $this->pageDescription = Yii::t(
            'eventsModule',
            "<p>При составлении списка гостей на свадьбу помните о том, что это ваш праздник,
            и вы вправе приглашать только тех людей, которых хотите видеть на своем торжестве.
            Тем не менее, вам следует обязательно согласовать этот список со своей второй половинкой и родителями,
            и если появятся спорные вопросы, обязательно прийти к компромиссу.</p>"
        );

        $scrollToElement = (isset($_GET['scrollToElement'])) ? $_GET['scrollToElement'] : NULL;


        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial(
                '_view',
                array(
                    'model'=>$model,
                    'eventModel' => new DailySchedulesEvents(),
                    'scrollToElement' => $scrollToElement

                ),
                false,
                true
            );
        }
        else{
            $this->render(
                'view',
                array(
                    'model'=>$model,
                    'eventModel' => new DailySchedulesEvents(),
                    'scrollToElement' => $scrollToElement

                )
            );
        }
    }

    /**
     * @param int|string $event_id
     * @throws CHttpException
     */
    public function actionCreate($event_id){
        $event = Events::model()->findByPk($event_id);
        if(Yii::app()->user->getId() != $event->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        $model=new DailySchedules;
        $model->event_id = $event_id;

        $this->performAjaxValidation($model);

        if(isset($_POST['DailySchedules'])){
            $model->attributes=$_POST['DailySchedules'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
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

        if(isset($_POST['DailySchedules'])){
            $model->attributes=$_POST['DailySchedules'];
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
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id){
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * @param $id
     * @return DailySchedules
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DailySchedules::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='daily-schedules-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
