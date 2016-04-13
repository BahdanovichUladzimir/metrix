<?php

class AdminPagesController extends BackendController
{

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionIndex(){

        $dataProvider = new CActiveDataProvider(
            'CmsPage',
            array(
                'criteria' => array(
                    'condition' => 'type=3 and published=1',
                    'order' => 'created desc',
                ),
                'pagination' => array(
                    'pageSize' => 20,
                ),
            )
        );
        Config::var_dump(Yii::app()->user->checkAccess('Cms.Backend.AdminPages.Index'));

        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
                'type'=>'Статьи',
                'model' => new CmsPage()
            )
        );
    }

}
