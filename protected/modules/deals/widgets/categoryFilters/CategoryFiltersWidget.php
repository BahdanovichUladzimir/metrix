<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.05.2015
 */

class CategoryFiltersWidget extends CWidget{


    /**
     * @var null|DealsCategories
     */
    public $category = NULL;
    /**
     * @var array
     */
    public $currentFilters = array();
    /**
     * @var string
     */
    public $template = 'default';
    /**
     * @var string
     */
    public $userCityKey;
    /**
     * @var int
     */
    public static $widgetId = 0;

    public $isShowSubCategories = true;

    /**
     *
     */
    public function init(){
        self::$widgetId++;
    }

    /**
     * @return bool
     * @throws CException
     */
    public function run(){
        if(is_null($this->category) || !($this->category instanceof DealsCategories)){
            return false;
        }
        if(is_null($this->category->getParent()) && sizeof($this->category->getChildren()) == 0){
            $this->isShowSubCategories = false;
        }

        $this->render(
            $this->template,
            array(
                'category' => $this->category,
                'widgetId' => self::$widgetId,
                'currentFilters' => $this->currentFilters,
                'dealsModel' => new Deals('filter'),
                'isShowSubCategories' => $this->isShowSubCategories
            )
        );
    }
}