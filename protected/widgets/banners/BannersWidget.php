<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 15.03.2015
 */

class BannersWidget extends CWidget{

    public static $widgetId = 1;
    public $view = 'default';
    public $categoryId = NULL;
    public $cityId = NULL;
    public function init(){
    }

    public function run(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'published=:published AND approve=:approve AND paid_end_date>=:paid_end_date';
        $criteria->with = array(
            'cities' => array(
                'condition' => 'cities.id=:city_id',
                'params' => array(
                    ':city_id' => $this->cityId
                )
            ),
            'categories' => array(
                'condition' => 'categories.id=:category_id',
                'params' => array(
                    ':category_id' => $this->categoryId
                ),
            ),
        );
        $criteria->params = array(
            ':published' => 1,
            ':approve' => 1,
            ':paid_end_date' => date('Y-m-d H:i:s', time())
        );
        $banners = Banners::model()->findAll($criteria);
        $this->render($this->view,
            array(
                'widgetId' => self::$widgetId,
                'banners' => $banners
            )
        );
        self::$widgetId++;
    }
}