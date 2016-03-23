<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.06.2015
 */

class SearchStringWidget extends CWidget
{
    public static $widgetId = 1;
    public $view = 'default';
    public $query = NULL;



    public function run()
    {
        $model = new Deals('search');
        $dataProvider=new CActiveDataProvider('Deals');

        $this->render($this->view,array(
            'widgetId' => self::$widgetId,
            'model' => $model,
            'dataProvider' => $dataProvider,
            'query' => $this->query
        ));
        self::$widgetId++;
    }
}