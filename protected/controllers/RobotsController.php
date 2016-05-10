<?php

class RobotsController extends FrontendController
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionRobots(){

        header("Content-type: text/plain");
        $newline = "\r\n";

        if(YII_ENV === 'production'){
            echo "User-agent: *".$newline;
            echo "Disallow: /".$newline;
            Yii::app()->end();
            //$newline = "<br>";

            // Yandex
            echo "User-agent: Yandex".$newline;
            $criteria = new CDbCriteria();
            $criteria->condition = 'no_index=:no_index';
            $criteria->params = array(
                ':no_index' => "1"
            );
            $disallowCategories = DealsCategories::model()->findAll($criteria);
            unset($criteria);
            $criteria = new CDbCriteria();
            $criteria->condition = 'noindex=:noindex';
            $criteria->params = array(
                ':noindex' => "1"
            );
            $disallowCities = Cities::model()->findAll($criteria);
            foreach($disallowCategories as $category){
                foreach(Cities::model()->findAll() as $city){
                    echo "Disallow: ".DealsCategories::getPublicUrlByCatId($category->id,$city->key)."".$newline;
                }
            }
            foreach($disallowCities as $city){
                echo "Disallow: /".$city->key."".$newline;
            }
            echo "Disallow: /assets".$newline;
            echo "Disallow: /css".$newline;
            echo "Disallow: /fonts".$newline;
            echo "Disallow: /js".$newline;
            echo "Disallow: /user".$newline;
            echo "Crawl-delay: 5".$newline;
            foreach(Cities::model()->indexed()->findAll() as $city){
                echo "Sitemap: https://".$_SERVER['HTTP_HOST']."/deals_sitemap_".$city->key.".xml".$newline;
            }
            echo "".$newline;


            //Google
            echo "User-agent: Googlebot".$newline;
            $criteria = new CDbCriteria();
            $criteria->condition = 'no_index=:no_index';
            $criteria->params = array(
                ':no_index' => "1"
            );
            $disallowCategories = DealsCategories::model()->findAll($criteria);
            unset($criteria);
            $criteria = new CDbCriteria();
            $criteria->condition = 'noindex=:noindex';
            $criteria->params = array(
                ':noindex' => "1"
            );
            $disallowCities = Cities::model()->findAll($criteria);
            foreach($disallowCategories as $category){
                foreach(Cities::model()->findAll() as $city){
                    echo "Disallow: ".DealsCategories::getPublicUrlByCatId($category->id,$city->key)."".$newline;
                }
            }
            foreach($disallowCities as $city){
                echo "Disallow: /".$city->key."".$newline;
            }
            echo "Disallow: /assets".$newline;
            echo "Disallow: /css".$newline;
            echo "Disallow: /fonts".$newline;
            echo "Disallow: /js".$newline;
            echo "Disallow: /user".$newline;
            echo "Crawl-delay: 5".$newline;
            echo "Sitemap: https://".$_SERVER['HTTP_HOST']."/categories_sitemap.xml".$newline;
            foreach(Cities::model()->indexed()->findAll() as $city){
                echo "Sitemap: https://".$_SERVER['HTTP_HOST']."/deals_sitemap_".$city->key.".xml".$newline;
            }
            echo "".$newline;

            //Default
            echo "User-agent: *".$newline;
            $criteria = new CDbCriteria();
            $criteria->condition = 'no_index=:no_index';
            $criteria->params = array(
                ':no_index' => "1"
            );
            $disallowCategories = DealsCategories::model()->findAll($criteria);
            unset($criteria);
            $criteria = new CDbCriteria();
            $criteria->condition = 'noindex=:noindex';
            $criteria->params = array(
                ':noindex' => "1"
            );
            $disallowCities = Cities::model()->findAll($criteria);
            foreach($disallowCategories as $category){
                foreach(Cities::model()->findAll() as $city){
                    echo "Disallow: ".DealsCategories::getPublicUrlByCatId($category->id,$city->key)."".$newline;
                }
            }
            foreach($disallowCities as $city){
                echo "Disallow: /".$city->key."".$newline;
            }
            echo "Disallow: /assets".$newline;
            echo "Disallow: /css".$newline;
            echo "Disallow: /fonts".$newline;
            echo "Disallow: /js".$newline;
            echo "Disallow: /user".$newline;
            echo "Crawl-delay: 5".$newline;
            foreach(Cities::model()->indexed()->findAll() as $city){
                echo "Sitemap: https://".$_SERVER['HTTP_HOST']."/deals_sitemap_".$city->key.".xml".$newline;
            }
            echo "Host: https://all4holidays.com".$newline;

            //echo "Sitemap: https://all4holidays.com/sitemap.xml".$newline;
        }
        else{
            echo "User-agent: *".$newline;
            echo "Disallow: /".$newline;
            //echo "Crawl-delay: 5".$newline;
            foreach(Cities::model()->indexed()->findAll() as $city){
                echo "Sitemap: https://".$_SERVER['HTTP_HOST']."/deals_sitemap_".$city->key.".xml".$newline;
            }
            echo "Host: http://".$_SERVER['HTTP_HOST'].$newline;
        }

    }
}