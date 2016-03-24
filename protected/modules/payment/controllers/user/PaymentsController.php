<?php

class PaymentsController extends UserFrontendController
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
    * Manages all models.
    */
    public function actionIndex(){


        $dbUser = $this->user;
        $model=new Payments('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Payments'])){
            $model->attributes=$_GET['Payments'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
                'dbUser' => $dbUser
            )
        );
    }

    /**
     * @param $id
     * @return Payments
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Payments::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='payments-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
