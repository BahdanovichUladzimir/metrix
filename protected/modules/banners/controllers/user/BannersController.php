<?php

class BannersController extends UserFrontendController
{


    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new Banners("userCreate");

        $this->performAjaxValidation($model);

        if(isset($_POST['Banners'])){
            $model->attributes=$_POST['Banners'];
            if(isset($_POST['Banners']['categories'])){
                $model->categories = DealsCategories::model()->findAllByPk($_POST['Banners']['categories']);
            }
            if(isset($_POST['Banners']['cities'])){
                $model->cities = Cities::model()->findAllByPk($_POST['Banners']['cities']);
            }
            $model->user_id = Yii::app()->user->getId();
            if($model->saveWithRelated(array("categories","cities"))){
                Yii::app()->user->setFlash('bannersUserBannersSuccess', Yii::t("bannersModule", 'Banner "{banner}" was created successfully!', array("{banner}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else{
                Yii::app()->user->setFlash('bannersUserBannersError', Yii::t("bannersModule", 'When create banner "{banner}" error occurred!', array("{banner}" => $model->name)));
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
        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }

        $model->setScenario("userUpdate");
        $this->performAjaxValidation($model);

        if(isset($_POST['Banners'])){

            $model->attributes=$_POST['Banners'];
            if(isset($_POST['Banners']['categories'])){
                $model->categories = $_POST['Banners']['categories'];
            }
            if(isset($_POST['Banners']['cities'])){
                $model->cities = $_POST['Banners']['cities'];
            }

            if($model->saveWithRelated(array("categories","cities"))){
                Yii::app()->user->setFlash('bannersUserBannersSuccess', Yii::t("bannersModule", 'Banner "{banner}" was updated successfully!', array("{banner}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('bannersUserBannersError', Yii::t("bannersModule", 'When update banner "{banner}" error occurred!', array("{banner}" => $model->name)));

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
        $model = Banners::model()->findByPk((int)$id);
        if(!is_null($model)){
            if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }
            if(Yii::app()->request->isPostRequest){
                // we only allow deletion via POST request
                if($model->delete()){
                    $message = Yii::t('bannersModule','Banner "{name}" was deleted successfully!', array("{name}" => $model->name));
                    if(Yii::app()->request->isAjaxRequest){
                        echo CJSON::encode(array(
                            'status' => 'success',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }
                    else{
                        Yii::app()->user->setFlash('deleteDeal',$message);
                        $this->redirect("/user/profile/privateProfile#banners");
                    }
                }
                else{
                    if(Yii::app()->request->isAjaxRequest){
                        $message = Yii::t('dealsModule','When delete banner "{name}" error occurred!', array("{name}" => $model->name));
                        echo CJSON::encode(array(
                            'status' => 'error',
                            'message' => $message,
                            'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }
                }
            }
            else{
                throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionPay($id, $days = 30){
        $model = $this->loadModel($id);
        if($model->approve != '1'){
            echo CJSON::encode(array(
                'message' => Yii::t('bannersModule','Banner is not approved by the moderator'),
                'status' => 'error'
            ));
            Yii::app()->end();
        }
        $paymentAmount = 0;
        foreach($model->cities as $city){
            foreach($model->categories as $category){
                $tmpPrice = BannersPrices::model()->findByAttributes(array('city_id' => $city->id, 'category_id' => $category->id));
                $price = is_null($tmpPrice) ? 20 : $tmpPrice;
                $paymentAmount+=($price->price*$days);
            }
        }
        $user = $this->user;
        if($user->ballance<$paymentAmount){
            $message = Yii::t('bannersModule','Insufficient Funds.');
            echo CJSON::encode(array(
                'message' => $message,
                'status' => 'error',
                'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "danger"),true),
                'ballance' => (int)$user->ballance,
                'paymentAmount' => $paymentAmount
            ));
            Yii::app()->end();
        }
        else{
            $transaction = Yii::app()->db->beginTransaction();
            $payment = new Payments();
            $payment->user_id = (int)$user->id;
            $payment->type_id = 6;
            $payment->time = time();
            $payment->amount = (int)$paymentAmount;
            $payment->real_amount = (int)$paymentAmount;
            $payment->app_category_id = (int)AppCategories::model()->findByAttributes(array('name'=>'banners'))->id;
            $payment->app_item_id = (int)$model->id;
            if($payment->save()){
                $model->published = 1;
                $periodStart = $model->unixPaidDate>time() ? $model->unixPaidDate : time();
                $model->paid_end_date = date("Y-m-d H:i:s", $periodStart+60*60*24*$days);
                if($model->save()){
                    $transaction->commit();
                    $message = Yii::t('bannersModule','Showing a banner "{name}" successfully extended by {days} days.', array('{days}' => $days, "{name}" => $model->name));
                    echo CJSON::encode(array(
                        'message' => $message,
                        'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                        'status' => 'success',
                        'public_date' => Yii::t('bannersModule',"End date").": ".$model->publicDate,
                        'published' => Banners::$publishes[$model->published]
                    ));
                    Yii::app()->end();
                }
                else{
                    $transaction->rollback();
                    $message = Yii::t('bannersModule','When extending banner error occurred.');
                    echo CJSON::encode(array(
                        'message' => $message,
                        'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "danger"),true),
                        'status' => 'error'
                    ));
                    Yii::app()->end();
                }
            }
            else{
                $transaction->rollback();
                $message = Yii::t('bannersModule','When extending banner error occurred.');
                echo CJSON::encode(array(
                    'message' => $message,
                    'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "danger"),true),
                    'status' => 'error'
                ));
                Yii::app()->end();
            }
        }
    }

    public function actionPublish($id){

        $model = $this->loadModel($id);
        if(Yii::app()->user->getId() != $model->user_id && !Yii::app()->getModule('user')->isModerator()){
            throw new CHttpException(403,'Access denied!');
        }
        $model->published = ($model->published == '0') ? '1' : '0';
        if($model->save()){
            $message = Yii::t('bannersModule','Banner "{name}" public status has been changed to "{status}" successfully.', array("{name}" => $model->name, "{status}" => Banners::$publishes[$model->published]));
            echo CJSON::encode(array(
                'message' => $message,
                'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                'status' => 'success',
                'published' => Banners::$publishes[$model->published]
            ));
        }
        else{
            $message = Yii::t('bannersModule','When set publish status to banner "{name}" error occurred.', array("{name}" => $model->name));
            echo CJSON::encode(array(
                'message' => $message,
                'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "danger"),true),
                'status' => 'error'
            ));
        }
    }


    /**
     * @param $id
     * @return Banners
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Banners::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='banners-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
