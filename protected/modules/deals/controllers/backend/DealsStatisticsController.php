<?php

class DealsStatisticsController extends BackendController
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
        $model=new DealsStatistics;

        $this->performAjaxValidation($model);

        if(isset($_POST['DealsStatistics'])){
            $model->attributes=$_POST['DealsStatistics'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
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

        if(isset($_POST['DealsStatistics'])){
            $model->attributes=$_POST['DealsStatistics'];
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
     * @throws CDbException
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
        $model=new DealsStatistics('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsStatistics'])){
            $model->attributes=$_GET['DealsStatistics'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    public function actionBadDeals(){
        $criteria = new CDbCriteria();
        $criteria->with = array('dealsImages');
        $criteria->condition = '(SELECT COUNT(`i`.`deal_id`) FROM `DealsImages` `i` WHERE `i`.`deal_id` = `t`.`id`)<4';
        $insufficientImagesCountDealsDataProvider =  new CActiveDataProvider(
            'Deals',
            array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
            ),
        ));
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->with = array('dealsImages');
        $criteria->condition = '(SELECT COUNT(`i`.`deal_id`) FROM `DealsImages` `i` WHERE `i`.`deal_id` = `t`.`id`)>50';
        $tooManyImagesCountDealsDataProvider =  new CActiveDataProvider(
            'Deals',
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));

        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'LENGTH(`t`.`description`)<150';
        $insufficientDescLengthDealsDataProvider =  new CActiveDataProvider(
            'Deals',
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));

        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'status_id=2 OR status_id=3 OR approve=0 OR archive=1';
        $deactivatedDealsDataProvider =  new CActiveDataProvider(
            'Deals',
            array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));

        $this->render(
            'bad_deals',
            array(
                'insufficientImagesCountDealsDataProvider'=>$insufficientImagesCountDealsDataProvider,
                'tooManyImagesCountDealsDataProvider'=>$tooManyImagesCountDealsDataProvider,
                'insufficientDescLengthDealsDataProvider'=>$insufficientDescLengthDealsDataProvider,
                'deactivatedDealsDataProvider'=>$deactivatedDealsDataProvider,
            )
        );
    }

    /**
     * @param $id
     * @return DealsStatistics
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealsStatistics::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-statistics-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
