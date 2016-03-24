<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 25.11.13
 * @var $model Items
 */

class SearchController extends FrontendController{



    public $query = NULL;
    public $defaultAction = 'yaSearch';

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->breadcrumbs=array(
            Yii::t('dealsModule','Search'),
        );

        if(isset($_GET['query'])&&(trim($_GET['query']) !== ''))
        {
            $model = new SphinxSearch('dealsSearch');

            $purifier = new CHtmlPurifier();
            $query = $purifier->purify($_GET['query']);
            $model->sphinxQuery = $query;

            $dataProvider = $model->dealsSearch();
            $categoriesDataProvider = $model->categoriesSearch();
            $this->query = $query;
            $message = Yii::t('dealsModule',"Search \"{query}\" found {countOfResults} results", array('{countOfResults}' => $dataProvider->getItemCount()+$categoriesDataProvider->getItemCount(), '{query}' => $query));
            $messageStatus = 'success';
        }
        else
        {
            $model = NULL;
            $dataProvider = NULL;
            $categoriesDataProvider = NULL;
            $message = Yii::t('dealsModule',"Set the empty search query!");
            $messageStatus = 'danger';
        }
        $this->render('index',array(
            'dataProvider' => $dataProvider,
            'categoriesDataProvider' => $categoriesDataProvider,
            'model' => $model,
            'query' => $this->query,
            'message' => $message,
            'messageStatus' => $messageStatus
        ));
    }


    public function actionYaSearch(){
        $this->breadcrumbs=array(
            Yii::t('dealsModule','Search'),
        );

        $this->render('yasearch');
    }


    /**
     * @param $id
     * @return Deals
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Deals::model()->findByPk($id);
        if($model===null)
        {
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='items-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
