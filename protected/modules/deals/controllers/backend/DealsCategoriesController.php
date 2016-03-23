<?php

class DealsCategoriesController extends BackendController
{

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id){
        $model = $this->loadModel($id);
        /**
         * @var $model DealsCategories
         */
        $params = array();
        foreach($model->dealsCategoriesParams as $param){
            $params[$param->id] = CHtml::link($param->dealParam->label,Yii::app()->createUrl('/deals/backend/dealsParams/update',array('id'=>$param->dealParam->id)));
        }
        $ratings = array();
        foreach($model->dealsCategoriesRatings as $rating){
            $ratings[$rating->id] = CHtml::link($rating->rating->label,Yii::app()->createUrl('/deals/backend/ratings/update',array('id'=>$rating->rating->id)));
        }

        $this->render(
            'view',
            array(
                'model' => $model,
                'params' => $params,
                'ratings' => $ratings,
                'childrenListData' => $model->getChildrenListData()
            )
        );
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $model=new DealsCategories;

        $this->performAjaxValidation($model);

        if(isset($_POST['DealsCategories'])){
            $model->attributes=$_POST['DealsCategories'];
            $model->params = (isset($_POST['DealsCategories']["params"]))?$_POST['DealsCategories']["params"]:NULL;
            $model->ratings = (isset($_POST['DealsCategories']["ratings"])) ? $_POST['DealsCategories']["ratings"] : NULL;

            if($model->saveWithRelated(array('params','ratings'))){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'statusesList' => DealsCategoriesStatuses::getListData(),
            'categoriesList' => DealsCategories::getListData(true, true, 3),
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

        /**
         * @var $model DealsCategories
         */
        if(isset($_POST['DealsCategories'])){

            $model->attributes=$_POST['DealsCategories'];
            $model->params = (isset($_POST['DealsCategories']["params"])) ? $_POST['DealsCategories']["params"] : NULL;
            $model->ratings = (isset($_POST['DealsCategories']["ratings"])) ? $_POST['DealsCategories']["ratings"] : NULL;

            if($model->saveWithRelated(array('params','ratings'))){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
                'statusesList' => DealsCategoriesStatuses::getListData(),
                'categoriesList' => DealsCategories::getListData(true, true, 3)
            )
        );
    }

    /**
     * @param $id
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
        $model=new DealsCategories('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsCategories'])){
            $model->attributes=$_GET['DealsCategories'];
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
     * @return static
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealsCategories::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-categories-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
