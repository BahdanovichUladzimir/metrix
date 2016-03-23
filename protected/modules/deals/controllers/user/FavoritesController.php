<?php

/**
 * Class DealsController
 */
class FavoritesController extends FrontendController
{

    /**
     * Manages all models.
     */
    public function actionIndex(){
        $user_id = Yii::app()->user->getId();
        $this->title = Yii::t('dealsModule','My favorites');
        $this->description = $this->title;
        $this->h1 = $this->title;
        $this->breadcrumbs=array(
            $this->title
        );
        if(is_null($user_id)){
            $criteria = new CDbCriteria();
            $criteria->condition = 'cookie_id=:cookie_id';
            $criteria->params = array(
                ':cookie_id' => Yii::app()->request->cookies['favoritesId']->value,
            );
            $favorites = CookiesFavorites::model()->findAll($criteria);
        }
        else{
            $criteria = new CDbCriteria();
            $criteria->condition = 'user_id=:user_id';
            $criteria->params = array(
                ':user_id' => $user_id,
            );
            $favorites = UsersFavorites::model()->findAll($criteria);
        }

        $ids = array();
        if(sizeof($favorites)>0){
            foreach($favorites as $favorite){
                $ids[] = $favorite->deal_id;
            }
        }
        $model=new Deals('search');
        $model->unsetAttributes();  // clear any default values
        $model->ids = $ids;
        if(isset($_GET['Favorites'])){
            $model->attributes=$_GET['Favorites'];
        }

        $this->render(
            'index',
            array(
                'model' => $model,
                'userId' => $user_id,
                'user' => $user_id
            )
        );
    }
}
