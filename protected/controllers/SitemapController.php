<?php

class SitemapController extends FrontendController
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionCategoriesSiteMap(){
        header("Content-type: text/xml");

        //if(YII_ENV === 'production'){
            $urls = array();
            $cities = Cities::model()->indexed()->findAll();
            foreach($cities as $city){
                $categories = DealsCategories::model()->published()->findAll();
                foreach($categories as $category){
                    $urls[] = DealsCategories::getPublicUrlByCatId($category->id,$city->key);
                }
            }
            $this->renderPartial('categories', array(
                'host'=>Yii::app()->request->hostInfo,
                'urls'=>$urls,
            ));
        //}

    }

    public function actionDealsSiteMap($cityKey){

        header("Content-type: text/xml");

        $city = Cities::model()->findByAttributes(array('key' => $cityKey));

        if(!is_null($city)){
            $criteria = new CDbCriteria();
            $criteria->condition = ':city_id=city_id';
            $criteria->params = array(':city_id' => $city->id);

            //if(YII_ENV === 'production'){
            $urls = array();
            $deals = Deals::model()->published()->findAll($criteria);
            foreach($deals as $deal){
                $urls[] = $deal->getPublicUrl();
            }
            $this->renderPartial('deals', array(
                'host'=>Yii::app()->request->hostInfo,
                'urls'=>$urls,
            ));

        }

    }

}