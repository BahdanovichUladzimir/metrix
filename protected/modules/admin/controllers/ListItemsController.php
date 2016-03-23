<?php

class ListItemsController extends BackendController
{


    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new ListItems;
        if(isset($_GET['list_id'])){
            $model->list_id = $_GET['list_id'];
        }
        $this->performAjaxValidation($model);

        if(isset($_POST['ListItems'])){
            $model->attributes=$_POST['ListItems'];
            if($model->save()){
                Yii::app()->user->setFlash('adminModule.ListItems.Success', Yii::t("adminModule", "List item <strong>{itemName}</strong> was created successfully!", array("{itemName}" => $model->name)));
                $this->redirect(Yii::app()->createUrl('/admin/lists/update', array('id' => $model->list_id)));
            }
            else{
                Yii::app()->user->setFlash('adminModule.ListItems.Error', Yii::t("adminModule", "When create list item <strong>{itemName}</strong> error occurred!", array("{itemName}" => $model->name)));
            }
        }

        $data = array(
            'model'=>$model,
            'listsListData' => Lists::getListData()
        );
        $this->render('create',$data);
    }

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id){

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['ListItems'])){
            $model->attributes=$_POST['ListItems'];
            if($model->save()){
                Yii::app()->user->setFlash('adminModule.ListItems.Success', Yii::t("adminModule", "List item <strong>{itemName}</strong> was updated successfully!", array("{itemName}" => $model->name)));
                $this->redirect(array('index'));
            }
            else{
                Yii::app()->user->setFlash('adminModule.ListItems.Error', Yii::t("adminModule", "When update list item <strong>{itemName}</strong> error occurred!", array("{itemName}" => $model->name)));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
                'listsListData' => Lists::getListData()
            )
        );
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id){

        $model = $this->loadModel($id);
        if($model->delete()){
            Yii::app()->user->setFlash('adminModule.ListItems.Success', Yii::t("adminModule", "List item <strong>{itemName}</strong> was deleted successfully!", array("{itemName}" => $model->name)));
        }
        else{
            Yii::app()->user->setFlash('adminModule.ListItems.Error', Yii::t("adminModule", "When delete list item <strong>{itemName}</strong> error occurred!", array("{itemName}" => $model->name)));
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])){
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->createUrl('/admin/lists/update', array('id' => $model->list_id)));
        }
    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new ListItems('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ListItems'])){
            $model->attributes=$_GET['ListItems'];
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
     * @return ListItems
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=ListItems::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='list-items-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
