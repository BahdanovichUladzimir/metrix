<?php

class DictionaryController extends BackendController
{

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){

        $model=new Dictionary;

        $this->performAjaxValidation($model);

        if(isset($_POST['Dictionary'])){
            $model->attributes=$_POST['Dictionary'];

            if($model->save()){
                if(isset($_POST['Dictionary']['cmsPagesDictionaries'])){
                    foreach($_POST['Dictionary']['cmsPage'] as $pageId){
                        $dictPage = new CmsPagesDictionary();
                        $dictPage->dictionary_id = $model->id;
                        $dictPage->page_id = $pageId;
                        $dictPage->save();
                    }
                }
                Yii::app()->user->setFlash('cmsBackendDictionarySuccess', Yii::t("cmsModule", "Letter <strong>{letter}</strong> was created successfully!", array("{letter}" => $model->name)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('cmsBackendDictionaryError', Yii::t("cmsModule", "When create letter <strong>{letter}</strong> error occurred!", array("{letter}" => $model->name)));
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

        if(isset($_POST['Dictionary'])){
            $model->attributes=$_POST['Dictionary'];
            if($model->save()){
                if(isset($_POST['Dictionary']['cmsPage'])){
                    CmsPagesDictionary::model()->deleteAllByAttributes(array('dictionary_id' => $model->id));
                    foreach($_POST['Dictionary']['cmsPage'] as $pageId){
                        $dictPage = new CmsPagesDictionary();
                        $dictPage->dictionary_id = $model->id;
                        $dictPage->page_id = $pageId;
                        $dictPage->save();
                    }
                }

                Yii::app()->user->setFlash('cmsBackendDictionarySuccess', Yii::t("cmsModule", "Letter <strong>{letter}</strong> was updated successfully!", array("{letter}" => $model->name)));
            }
            else{
                Yii::app()->user->setFlash('cmsBackendDictionaryError', Yii::t("cmsModule", "When update letter <strong>{letter}</strong> error occurred!", array("{letter}" => $model->name)));
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
        $model=new Dictionary('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Dictionary'])){
            $model->attributes=$_GET['Dictionary'];
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
     * @return Dictionary
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Dictionary::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='dictionary-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
