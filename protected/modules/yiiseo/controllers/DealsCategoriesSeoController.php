<?php

class DealsCategoriesSeoController extends BackendController
{
    /**
     * @param null|int $category_id
     * @param null|int $city_id
     */
    public function actionCreate($category_id = NULL, $city_id = NULL){
        $model=new DealsCategoriesSeo;
        if(!is_null($category_id)){
            $model->category_id = $category_id;
        }
        if(!is_null($city_id)){
            $model->city_id = $city_id;
        }

        $this->performAjaxValidation($model);

        if(isset($_POST['DealsCategoriesSeo'])){
            $model->attributes=$_POST['DealsCategoriesSeo'];
            if($model->save()){
                Yii::app()->user->setFlash('yiiseoModule.DealsCategoriesSeo.Success', Yii::t("yiiseoModule", "SEO rule ID<strong>{rule}</strong> was created successfully!", array("{rule}" => $model->id)));
                $this->redirect(array('index'));
            }
            else{
                Yii::app()->user->setFlash('yiiseoModule.DealsCategoriesSeo.Error', Yii::t("yiiseoModule", "When create SEO rule ID<strong>{rule}</strong> error occurred!", array("{rule}" => $model->id)));
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'categoriesList' => DealsCategories::getDropdownItems(0,1,4),
            'citiesList' => Cities::getAllCitiesListData(),
            'languagesList' => Countries::getLanguagesListData()
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

        if(isset($_POST['DealsCategoriesSeo'])){
            $model->attributes=$_POST['DealsCategoriesSeo'];
            if($model->save()){
                Yii::app()->user->setFlash('yiiseoModule.DealsCategoriesSeo.Success', Yii::t("adminModule", "SEO rule ID<strong>{ruleId}</strong> was updated successfully!", array("{ruleId}" => $model->id)));
                $this->redirect(array('index'));
            }
            else{
                Yii::app()->user->setFlash('yiiseoModule.DealsCategoriesSeo.Error', Yii::t("adminModule", "When update SEO rule <strong>{ruleId}</strong> error occurred!", array("{ruleId}" => $model->id)));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
                'categoriesList' => DealsCategories::getDropdownItems(0,1,3),
                'citiesList' => Cities::getAllCitiesListData(),
                'languagesList' => Countries::getLanguagesListData()
            )
        );
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id){

            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }

    }

    /**
    * Manages all models.
    */
    public function actionIndex(){
        $model=new DealsCategoriesSeo('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DealsCategoriesSeo'])){
            $model->attributes=$_GET['DealsCategoriesSeo'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }

    public function actionUnfilledCategories(){
        $categories = DealsCategories::model()->findAll();
        $cities = Cities::model()->findAll();
        $citiesCategories = array();
        foreach($cities as $city){
            /**
             * @var Cities $city
             */
            foreach($categories as $category){
                /**
                 * @var DealsCategories $category
                 */
                if(is_null(DealsCategoriesSeo::model()->findByAttributes(array('city_id' => $city->id, 'category_id' => $category->id)))){
                    $citiesCategories[$city->name][] = array(
                        'city' => $city,
                        'category' => $category
                    );
                };

            }
        }

        $this->render(
            'unfilled_categories',
            array(
                'citiesCategories'=>$citiesCategories,
            )
        );
    }

    /**
     * @param $id
     * @return DealsCategoriesSeo
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=DealsCategoriesSeo::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='deals-categories-seo-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
