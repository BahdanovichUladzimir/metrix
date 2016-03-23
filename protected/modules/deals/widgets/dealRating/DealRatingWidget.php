<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 11.04.2015
 * @var $category DealsCategories
 * @var $rating Ratings
 * @var $currentRatingsTotal UsersRatingsValues

 */

class DealRatingWidget extends CWidget{
    /**
     * @var Deals
     */
    public $deal = NULL;
    public $template = 'default';
    public static $widgetId = 0;

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        //Заглушка
        return false;
        if(is_null($this->deal) || !($this->deal instanceof Deals)){
            return false;
        }
        $currentRatingsIds = array();
        $currentRatings = array();
        foreach($this->deal->categories as $category){
            foreach($category->ratings as $rating){
                if(!in_array((int)$rating->id,$currentRatingsIds)){
                    $currentRatings[] = $rating;
                    $currentRatingsIds[] = $rating->id;
                }
            }
        }
        if(sizeof($currentRatings)==0){
            return false;
        }

        // Получаем общий рейтинг товара
        $criteria = new CDbCriteria();
        $criteria->select='SUM(value) AS ratingsTotal, COUNT(*) as ratingsCount, rating_id, value';
        $criteria->condition = ':deal_id=deal_id';
        $criteria->params = array(':deal_id'=>$this->deal->id);
        $criteria->addInCondition('rating_id',$currentRatingsIds);
        $currentRatingsTotal = UsersRatingsValues::model()->find($criteria);
        $criteria->select='rating_id, value';
        $currentRatingsValues = UsersRatingsValues::model()->findAll($criteria);


        foreach($currentRatings as $currentRating){
            foreach($currentRatingsValues as $currentRatingsValue){
                if($currentRatingsValue->rating_id == $currentRating->id){
                    $currentRating->setValue($currentRatingsValue->value);
                }
            }

        }

        $currentTotalRating = (is_null($currentRatingsTotal->ratingsTotal)) ? 0 : $currentRatingsTotal->ratingsTotal/$currentRatingsTotal->ratingsCount;
        $this->render(
            $this->template,
            array(
                'deal' => $this->deal,
                'currentRatings' => $currentRatings,
                'currentTotalRating' => round($currentTotalRating),
                'widgetId' => self::$widgetId
            )
        );
    }
}