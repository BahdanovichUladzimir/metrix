<?php

/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 10.08.2015
 */
class CategorySelectWidget extends CWidget{

    /**
     * @property $category DealsCategories
     */
    public $model = NULL;
    public $template = 'default';
    public static $widgetId = 0;

    public function init(){
        self::$widgetId++;
    }

    public function run(){
        if(is_null($this->model) || !($this->model instanceof Deals)){
            return false;
        }
        $currentCategory = (sizeof($this->model->categories)>0) ? $this->model->categories[0] : NULL;
        $currentCategoryChildrenHtml = "";
        if(!is_null($currentCategory) && sizeof($currentCategory->getChildren())>0){
            $currentCategoryChildrenHtml = $this->render(
                'select',
                array(
                    'categoriesList'=>$currentCategory->getChildrenListData(),
                    'category' => NULL,
                    'childrenSelect' => false
                ),
                true
            );
        }
        $this->render(
            $this->template,
            array(
                'model' => $this->model,
                'widgetId' => self::$widgetId,
                'selects' => $this->generateSelect($currentCategory, $currentCategoryChildrenHtml)
            )
        );
    }

    public function generateSelect(DealsCategories $category = NULL, $children = false){
        /**
         * @var DealsCategories
         */
        if(!is_null($category) && $category->hasParent()){
            $categoriesList = $category->getParent()->getChildrenDropdownListData(false, false);
        }
        else{
            $categoriesList = CHtml::listData(DealsCategories::getRootCategories(false),'id','name');
        }

        $currentCategorySelectHtml = $this->render(
            'select',
            array(
                'categoriesList'=>$categoriesList,
                'category' => $category,
                'childrenSelect' => $children
            ),
            true
        );
        if(!is_null($category) && $category->hasParent()){
            return $this->generateSelect($category->getParent(), $currentCategorySelectHtml);
        }
        else{
            return $currentCategorySelectHtml;
        }
    }
}