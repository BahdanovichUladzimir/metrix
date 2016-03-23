<?php

class DealLinksController extends UserFrontendController
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

    public function getDeal(){
        if(isset($this->actionParams['id'])){
            $deal = DealLinks::model()->findByPk($this->actionParams['id'])->deal;
            return $deal;
        }
        elseif(isset($this->actionParams['link_id'])){
            $deal = DealLinks::model()->findByPk($this->actionParams['link_id'])->deal;
            return $deal;
        }
        else{
            return NULL;
        }
    }


    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        if(isset($_POST['deal_id'])){
            $deal = Deals::model()->findByPk((int)$_POST['deal_id']);
            if(!is_null($deal)){
                if(Yii::app()->user->getId() != $deal->user_id){
                    throw new CHttpException(403,'Access denied!');
                }
            }
        }

        $model=new DealLinks('youtube');

        $this->performAjaxValidation($model);

        if(isset($_POST['DealLinks'])){
            $model->attributes=$_POST['DealLinks'];
            //$model->link_type = "youtube";
            if($model->save()){
                if(Yii::app()->request->isAjaxRequest){
                    $message = Yii::t('dealsModule',"Link <strong>{link}</strong> was added successfully!", array("{link}" => $model->link));
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'message' => $message,
                        'html' => $this->renderPartial('_message',array("model"=>$model, "message" => $message, "status" => "success"),true),
                    ));
                    Yii::app()->end();
                }
            }
            else{
                if(Yii::app()->request->isAjaxRequest){
                    $html = '';
                    $message = "";
                    foreach($model->getErrors() as $attribute => $errors){
                        $errorsString = implode(".", $errors);
                        $html.= $this->renderPartial('_message',array("model"=>$model, "message" => $errorsString, "status" => "danger"),true);
                        $message.= $errorsString;
                    }
                    echo CJSON::encode(array(
                        'status' => 'success',
                        'message' => $message,
                        'html' => $html
                    ));
                    Yii::app()->end();
                }
            }
        }
    }


    /**
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete(){

        if(isset($_POST["_method"]) && isset($_POST['link_id'])){
            if($_POST["_method"] == "delete"){
                $model = DealLinks::model()->findByPk((int)$_POST['link_id']);
                if(Yii::app()->user->getId() != $model->deal->user_id){
                    throw new CHttpException(403,'Access denied!');
                }
                if($model->delete()){

                    if(Yii::app()->request->isAjaxRequest){
                        $message = Yii::t('dealsModule','Link {link} was deleted successfully!', array("{link}" => $model->link));
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => $message,
                            'html'=> $this->renderPartial('_message',array("model"=>$model,"message"=>$message, "status" => "success"),true),
                        ));
                        Yii::app()->end();
                    }

                }else{
                    if(Yii::app()->request->isAjaxRequest){
                        $message = Yii::t('dealsModule','When deleted link {link} error occurred!', array("{link}" => $model->link));
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $message,
                            'html'=> $this->renderPartial('_message',array("model"=>$model,"message"=>$message, "status" => "danger"),true),
                        ));
                        Yii::app()->end();
                    }
                };

            }
            else{
                throw new CHttpException(403,'Incorrect data!');
            }
        }
        else{
            throw new CHttpException(403,'Incorrect data!');
        }





        /*if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }*/
    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new DealLinks('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealLinks'])){
            $model->attributes=$_GET['DealLinks'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    public function actionSetLinkDescription(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['link_id']) && isset($_POST['description'])){
                $model = DealLinks::model()->with('deal')->findByPk((int)$_POST['link_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id){
                    throw new CHttpException(403,'Access denied!');
                }
                if(!is_null($model)){
                    //@todo сделать очистку от скриптов и шлака
                    $model->description = CHtml::encode($_POST['description']);
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Link description was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',

                            'message' => $model->getError('description')
                        ));
                    }

                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }

    public function actionSetLinkAlias(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST) && isset($_POST['link_id']) && isset($_POST['alias'])){
                $model = DealLinks::model()->with('deal')->findByPk((int)$_POST['link_id'],'deal.user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
                if(Yii::app()->user->getId() != $model->deal->user_id){
                    throw new CHttpException(403,'Access denied!');
                }
                if(!is_null($model)){
                    //@todo сделать очистку от скриптов и шлака
                    $model->alias = CHtml::encode($_POST['alias']);
                    $this->performAjaxValidation($model);
                    if($model->save()){
                        echo json_encode(array(
                            'status' => 'success',
                            'message' => Yii::t('dealsModule','Link alias was updated successfully')
                        ));
                    }
                    else{
                        echo json_encode(array(
                            'status' => 'error',
                            'message' => $model->getError('alias')
                        ));
                    }

                }
                else{
                    echo json_encode(array(
                        'status' => 'error',
                        'message' => Yii::t('dealsModule','Model not found')
                    ));
                }
            }
            else{
                echo json_encode(array(
                    'status' => 'error',
                    'message' => Yii::t('dealsModule','Incorrect parameters')
                ));
            }
        }
    }



    /**
     * @param $id
     * @return static
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealLinks::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deal-links-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
