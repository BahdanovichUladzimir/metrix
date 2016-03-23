<?php

class PaymentsController extends BackendController
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
    /*public function actionCreate(){
        $model=new Payments;

        $this->performAjaxValidation($model);

        if(isset($_POST['Payments'])){
            $model->attributes=$_POST['Payments'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }*/

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Payments'])){
            $model->attributes=$_POST['Payments'];
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
    /*public function actionDelete($id){
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
    }*/

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new Payments('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Payments'])){
            $model->attributes=$_GET['Payments'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    public function actionGetUserPayments($user_id){
        $model=new Payments('search');
        $model->unsetAttributes();  // clear any default values
        $model->user_id = $user_id;
        if(isset($_GET['Payments'])){
            $model->attributes=$_GET['Payments'];
        }

        $this->render(
            'user_payments',
            array(
                'model'=>$model,
            )
        );
    }

    public function actionAddBonus(){
        if(Yii::app()->request->isPostRequest && isset($_POST['user_id']) && isset($_POST['count'])){
            $payment = new Payments();
            $payment->user_id = (int)$_POST['user_id'];
            $payment->type_id = 2;
            $payment->time = time();
            $payment->amount = (int)$_POST['count'];
            $payment->real_amount = (int)$_POST['count'];
            $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'users'))->id;
            $payment->app_item_id = (int)$_POST['user_id'];
            if($payment->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'message' => Yii::t('paymentModule', 'Bonus was added successfully!'),
                        'status' => 'success',
                        'user_balance' => User::model()->findByPk($payment->user_id)->ballance
                    ));
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'message' => Yii::t('paymentModule', 'When add bonus error occurred!'),
                        'status' => 'error',
                        'user_balance' => User::model()->findByPk($payment->user_id)->ballance
                    ));
                }
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAddFine(){
        if(Yii::app()->request->isPostRequest && isset($_POST['user_id']) && isset($_POST['count'])){
            $payment = new Payments();
            $payment->user_id = (int)$_POST['user_id'];
            $payment->type_id = 3;
            $payment->time = time();
            $payment->amount = (int)$_POST['count'];
            $payment->real_amount = (int)$_POST['count'];
            $payment->app_category_id = AppCategories::model()->findByAttributes(array('name'=>'users'))->id;
            $payment->app_item_id = (int)$_POST['user_id'];
            if($payment->save()){
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'message' => Yii::t('paymentModule', 'Fine was added successfully!'),
                        'status' => 'success',
                        'user_balance' => User::model()->findByPk($payment->user_id)->ballance
                    ));
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    echo CJSON::encode(array(
                        'message' => Yii::t('paymentModule', 'When add fine error occurred!'),
                        'status' => 'error',
                        'user_balance' => User::model()->findByPk($payment->user_id)->ballance
                    ));
                }
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
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
