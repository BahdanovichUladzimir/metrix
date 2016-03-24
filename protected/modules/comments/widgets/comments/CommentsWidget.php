<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 26.03.2015
 */

class CommentsWidget extends CWidget{

    public static $widgetId = 0;
    public $template = 'default';
    public $appCategoryId = NULL;
    public $appCategoryItemId = NULL;
    public $parentId = 0;

    public function init(){
        self::$widgetId++;
    }

    /**
     *
     */
    public function run(){
        if(is_null($this->appCategoryId || is_null($this->appCategoryItemId))){
            return false;
        }

        $criteria = new CDbCriteria;
        $criteria->condition = 'app_category_id=:app_category_id AND app_category_item_id=:app_category_item_id';
        $criteria->params = array(
            ':app_category_id' => $this->appCategoryId,
            ':app_category_item_id' => $this->appCategoryItemId
            //':approve' => 1,
        );
        $comments = Comments::model()->findAll($criteria);

        $this->render($this->template,
            array(
                'widgetId' => self::$widgetId,
                'comments' => $comments,
                'model' => new Comments,
                'appCategoryId' => $this->appCategoryId,
                'appCategoryItemId' => $this->appCategoryItemId,
                'parentId' => $this->parentId,
                'user' => Yii::app()->user,
                'rUser' => User::model()->findByPk(Yii::app()->user->getId())
            )
        );
    }
}