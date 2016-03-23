<?php

class SocialMediaPostingController extends BackendController
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
     * @param mixed $item_id
     * @param mixed $type
     * @param mixed $network
     * @param string $lang
     */
    public function actionCreate($item_id = NULL, $type = NULL, $lang = 'ru', $network = NULL){
        $model=new SocialMediaPosting;

        if(!is_null($item_id) && !is_null($type)){
            if(array_key_exists($type,SocialMediaPosting::$types)){
                if($type == "1"){
                    $item = CmsPageContent::model()->findByAttributes(array("id"=>(int)$item_id, 'locale' => $lang));
                    if(!is_null($item)){
                        $model->type = 1;
                        $model->title = $item->heading;
                        $model->description = $item->body;
                        $model->lang = $lang;
                        if(!is_null($item_id)){
                            $model->link = Yii::app()->createAbsoluteUrl("/cms/page/view", array("id"=>$item->pageId));
                        }
                        if(!is_null($network)){
                            $model->network = $network;
                        }
                    }
                }
                elseif($type == "2"){
                    $deal = Deals::model()->findByPk((int)$item_id);
                    if(!is_null($deal)){

                        $model->type = 2;
                        $model->title = $deal->name;
                        $model->description = $deal->description;
                        $model->lang = $lang;
                        $model->link = Yii::app()->createAbsoluteUrl($deal->getPublicUrl());
                        if(!is_null($network)){
                            $model->network = $network;
                        }
                    }
                }
                else{}
            }
        }

        $this->performAjaxValidation($model);

        if(isset($_POST['SocialMediaPosting'])){
            $model->attributes=$_POST['SocialMediaPosting'];
            if($model->save()){
                if($type == "2"){
                    if(isset($deal) && !is_null($deal) && sizeof($deal->frontendDealsImages)>0){
                        $images = array_slice($deal->frontendDealsImages, 0, 3);
                        foreach ($images as $image) {
                            $imageModel = new SocialMediaPostingImages();
                            $imageModel->post_id = $model->id;
                            $imageModel->image_id = $image->id;
                            $imageModel->status = 1;
                            $imageModel->save();
                        }
                    }

                }

                Yii::app()->user->setFlash('cmsPostingSuccess', Yii::t("cmsModule", "Post <strong>{name}</strong> was created successfully!", array("{name}" => $model->title)));
                $this->redirect(array('update', 'id' => $model->id));
            }
            else {
                Yii::app()->user->setFlash('cmsPostingError', Yii::t("cmsModule", "When create post <strong>{name}</strong> error occurred!", array("{name}" => $model->title)));
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

        if(isset($_POST['SocialMediaPosting'])){
            $model->attributes=$_POST['SocialMediaPosting'];
            if($model->save()){
                Yii::app()->user->setFlash('cmsPostingSuccess', Yii::t("adminModule", "Post <strong>{name}</strong> was updated successfully!", array("{name}" => $model->title)));
            }
            else{
                Yii::app()->user->setFlash('cmsPostingError', Yii::t("adminModule", "When update post <strong>{name}</strong> error occurred!", array("{name}" => $model->title)));
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
        $model=new SocialMediaPosting('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['SocialMediaPosting'])){
            $model->attributes=$_GET['SocialMediaPosting'];
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
     * @return SocialMediaPosting
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=SocialMediaPosting::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='social-media-posting-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
