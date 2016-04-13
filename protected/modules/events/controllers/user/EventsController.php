<?php

class EventsController extends UserFrontendController
{


    public function actionGuestsList($id){
        $model = $this->loadModel($id);
        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }

        $this->layout = '//layouts/guests_list';
        $this->bgImage = '/images/guests_bg.jpg';
        $this->pageTitle = Yii::t('core',"Table of guests at the event");
        $this->title = Yii::t('core',"Table of guests at the event");
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
        $dataProvider = new CActiveDataProvider('EventsGuests', array(
            'criteria'=>$criteria,
            'pagination'=>false,

        ));
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 1,
            ':event_id' => $id
        );
        $sizeOfNotSubmitted = EventsGuests::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 2,
            ':event_id' => $id
        );
        $sizeOfSubmitted = EventsGuests::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 3,
            ':event_id' => $id
        );
        $sizeOfConfirmed = EventsGuests::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=:status_id AND event_id=:event_id';
        $criteria->params = array(
            ':status_id' => 4,
            ':event_id' => $id
        );
        $sizeOfRefused = EventsGuests::model()->count($criteria);
        $scrollToElement = (isset($_GET['scrollToElement'])) ? $_GET['scrollToElement'] : NULL;

        if(Yii::app()->request->isAjaxRequest){
            $this->renderPartial(
                '_guests_list',
                array(
                    'model'=>$model,
                    'dataProvider' => $dataProvider,
                    'sizeOfNotSubmitted' => $sizeOfNotSubmitted,
                    'sizeOfSubmitted' => $sizeOfSubmitted,
                    'sizeOfConfirmed' => $sizeOfConfirmed,
                    'sizeOfRefused' => $sizeOfRefused,
                    'guestModel' => new EventsGuests(),
                    'scrollToElement' => $scrollToElement
                ),
                false,
                true
            );
        }
        else{
            $this->render(
                'guests_list',
                array(
                    'model'=>$model,
                    'dataProvider' => $dataProvider,
                    'sizeOfNotSubmitted' => $sizeOfNotSubmitted,
                    'sizeOfSubmitted' => $sizeOfSubmitted,
                    'sizeOfConfirmed' => $sizeOfConfirmed,
                    'sizeOfRefused' => $sizeOfRefused,
                    'guestModel' => new EventsGuests(),
                    'scrollToElement' => $scrollToElement
                )
            );
        }
    }

    /*public function actionDeleteGuestsList($id){
        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $model = $this->loadModel($id);

            if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isAdmin()){
                throw new CHttpException(403,'Access denied!');
            }

            $guests = EventsGuests::model()->findAllByAttributes(array("event_id" =>$id));
            foreach($guests as $guest){
                $guest->delete();
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!Yii::app()->request->isAjaxRequest){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'), array('id' => $model->id));
            }
            else{
                echo CJSON::encode(
                    array(
                        'status' => 'success',
                        'message' => Yii::t("eventsModule", "Guests list was deleted successfully"),
                    )
                );
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }*/

    public function actionLogin($eventId){
        $model = $this->loadModel($eventId);
        if (!is_null(Yii::app()->request->cookies['event_'.$eventId]) && Yii::app()->request->cookies['event_'.$eventId]->value == $model->cookie){
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
        else{
            $loginModel = new EventLogin();
            $loginModel->event = $model;
            if(isset($_POST['EventLogin']))
            {
                $loginModel->attributes=$_POST['EventLogin'];
                // validate user input and redirect to previous page if valid
                if($loginModel->validate()) {
                    $cookie = $model->cookie;
                    $cookie = new CHttpCookie('event_'.$eventId, $cookie);
                    $cookie->expire = time()+60*60*24*14;
                    Yii::app()->request->cookies['event_'.$eventId] = $cookie;

                    if (Yii::app()->user->returnUrl=='/index.php'){
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    }
                    else{
                        $this->redirect(Yii::app()->createUrl('/events/user/events/view', array('id' => $model->id)));
                    }
                }
                else{}
            }
            $this->render(
                'login',
                array(
                    'model'=>$model,
                    'loginModel'=>$loginModel,
                )
            );
        }
    }

    /**
     * @param int $id
     * @throws CHttpException
     */
    public function actionView($id){

        $model = $this->loadModel($id);
        if (
            $model->public_status_id == 1
            ||
            $model->user_id == Yii::app()->user->getId()
            ||
            Yii::app()->getModule('user')->isModerator()
            ||
            (!is_null(Yii::app()->request->cookies['event_'.$model->id]) && Yii::app()->request->cookies['event_'.$model->id]->value == $model->cookie)
        ){
            $this->title = $model->name;
            $alcModel = Alcohol::model()->findByAttributes(array('event_id' => $id));

            $this->render(
                'view',
                array(
                    'model'=>$model,
                    'alcModel'=>$alcModel,
                )
            );
        }
        else{
            $this->redirect(Yii::app()->createUrl('/events/user/events/login', array('eventId' => $model->id)));
        }
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Events;
        $this->title = Yii::t('eventsModule','Create event');

        $this->performAjaxValidation($model);

        if(isset($_POST['Events'])){
            $model->attributes=$_POST['Events'];
            $model->user_id = Yii::app()->user->getId();
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * @param int $id
     * @throws CHttpException
     */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->title = Yii::t('eventsModule','Update event {name}', array("{name}" => $model->name));

        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }

        $this->performAjaxValidation($model);

        if(isset($_POST['Events'])){
            $model->attributes=$_POST['Events'];
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
     * @param int $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id){


        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $model = $this->loadModel($id);

            if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }

            if($model->delete()){
                if(!Yii::app()->request->isAjaxRequest){
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/user/profile/privateProfile'));
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t("eventsModule", "Guests list was deleted successfully"),
                        )
                    );
                }
            }
            else{
                if(!Yii::app()->request->isAjaxRequest){
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/user/profile/privateProfile'));
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t("eventsModule", "When delete guests list error occurred"),
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
    * Manages all models.
    */
    /*public function actionIndex(){
        $model=new Events('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Events'])){
            $model->attributes=$_GET['Events'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }*/

    /**
     * @param $id
     * @return Events
     * @throws CHttpException
     */
    public function loadModel($id){
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='events-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
