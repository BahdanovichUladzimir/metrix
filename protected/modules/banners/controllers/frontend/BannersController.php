<?php

class BannersController extends UserFrontendController
{


    /**
     * @param int $id
     */
    public function actionBanner($id){

        $model = $this->loadModel($id);
        $criteria = new CDbCriteria();
        $criteria->condition = "banner_id=:banner_id AND date=:date";
        $criteria->params = array(
            ':banner_id' => $model->id,
            ":date" => date("Y-m-d",time())
        );
        $clicksModel = BannersClicks::model()->find($criteria);
        if(is_null($clicksModel)){
            $clicksModel = new BannersClicks();
            $clicksModel->banner_id = $model->id;
            $clicksModel->date = date("Y-m-d",time());
        }
        $clicksModel->clicks_count = $clicksModel->clicks_count+1;
        if($clicksModel->save()){
            $this->redirect($model->link);
        };
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
