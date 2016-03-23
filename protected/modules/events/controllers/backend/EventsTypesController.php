<?php

class EventsTypesController extends BackendController
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
        $model=new EventsTypes;

        $this->performAjaxValidation($model);

        if(isset($_POST['EventsTypes'])){
            $model->attributes=$_POST['EventsTypes'];
            if($model->save()){
                Yii::app()->user->setFlash('eventsTypesSuccess', Yii::t("eventsModule", "Event type <strong>{event}</strong> was created successfully!", array("{event}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('eventsTypesError', Yii::t("eventsModule", "When create event type <strong>{event}</strong> error occurred!", array("{event}" => $model->name)));
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

        if(isset($_POST['EventsTypes'])){
            $model->attributes=$_POST['EventsTypes'];

            if($model->save()){
                Yii::app()->user->setFlash('eventsTypesSuccess', Yii::t("eventsModule", "Event type <strong>{event}</strong> was updated successfully!", array("{event}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('eventsTypesError', Yii::t("eventsModule", "When update event type <strong>{event}</strong> error occurred!", array("{event}" => $model->name)));
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
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
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
    * Manages all models.
    */
    public function actionIndex(){
        $model=new EventsTypes('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['EventsTypes'])){
            $model->attributes=$_GET['EventsTypes'];
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
     * @return EventsTypes
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=EventsTypes::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='events-types-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
