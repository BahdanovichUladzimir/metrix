<?php

class DealsParamsController extends BackendController
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
        $model=new DealsParams;

        $this->performAjaxValidation($model);

        if(isset($_POST['DealsParams'])){
            $model->attributes=$_POST['DealsParams'];
            $model->list_id = ($_POST['DealsParams']['list_id'] == '0') ? NULL : $_POST['DealsParams']['list_id'];
            if($model->save()){
                Yii::app()->user->setFlash('dealsParamsSuccess', Yii::t("dealsModule", "Param <strong>{name}</strong> was created successfully!", array("{name}" => $model->name)));
                $this->redirect(array('update','id'=>$model->id));
            }
            else{
                Yii::app()->user->setFlash('dealsParamsError', Yii::t("dealsModule", "When create param <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
                $this->redirect(array('create'));

            }

        }

        $this->render('create',array(
            'model'=>$model,
            'typesListData' => DealsParams::getTypesListData(),
            'requiredListData' => DealsParams::getRequiredListData(),
            'visibleListData' => DealsParams::getVisibleListData(),
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

        if(isset($_POST['DealsParams'])){
            $model->attributes=$_POST['DealsParams'];
            $model->list_id = ($_POST['DealsParams']['list_id'] == '0') ? NULL : $_POST['DealsParams']['list_id'];
            if($model->save()){
                Yii::app()->user->setFlash('dealsParamsSuccess', Yii::t("dealsModule", "Param <strong>{name}</strong> was updated successfully!", array("{name}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('dealsParamsError', Yii::t("dealsModule", "When update param <strong>{name}</strong> error occurred!", array("{name}" => $model->name)));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
                'typesListData' => DealsParams::getTypesListData(),
                'requiredListData' => DealsParams::getRequiredListData(),
                'visibleListData' => DealsParams::getVisibleListData(),
            )
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionDelete($id){
        /*if(Yii::app()->request->isPostRequest){*/
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        /*}
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }*/
    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new DealsParams('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsParams'])){
            $model->attributes=$_GET['DealsParams'];
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
     * @return DealsParams
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealsParams::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-params-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
