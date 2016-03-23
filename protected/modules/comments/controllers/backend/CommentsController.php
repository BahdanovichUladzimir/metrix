<?php

class CommentsController extends BackendController
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
        $model=new Comments;

        $this->performAjaxValidation($model);

        if(isset($_POST['Comments'])){
            $model->attributes=$_POST['Comments'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * @param integer $id Image id
     */
    public function actionApprove($id){
        $update = Comments::model()->updateByPk((int)$id,array('approve'=>1));
        echo json_encode($update);
    }

    /**
     *
     */
    public function actionApproveSelected(){
        if(isset($_POST) && isset($_POST['value'])){
            $update = Comments::model()->updateByPk($_POST['value'],array('approve'=>1));
            echo json_encode($update);
        }

    }

    /**
     * @param integer $id Image id
     */
    public function actionUnApprove($id){
        $update = Comments::model()->updateByPk((int)$id,array('approve'=>0));
        echo json_encode($update);
    }

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);
        if(isset($_POST['Comments'])){
            $model->attributes=$_POST['Comments'];
            if($model->save()){
                Yii::app()->user->setFlash('commentsBackendCommentsUpdateSuccess', Yii::t("commentsModule", "Comment <strong>{commentId}</strong> was updated successfully!", array("{commentId}" => $model->id)));
            }
            else{
                Yii::app()->user->setFlash('commentsBackendCommentsUpdateError', Yii::t("commentsModule", "When update comment <strong>{commentId}</strong> error occurred!", array("{commentId}" => $model->id)));
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
    * Manages all models.
    */
    public function actionIndex(){
        $model=new Comments('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Comments'])){
            $model->attributes=$_GET['Comments'];
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
     * @return Comments
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Comments::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
