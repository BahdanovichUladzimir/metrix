<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 10.02.2016
 * @var DealsCategories[] $citiesCategories
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('yiiseoModule','Deals categories SEO rules')=>array('index'),
    Yii::t('yiiseoModule','Unfilled categories'),
);
?>

<h1><?=Yii::t('yiiseoModule','Unfilled categories');?></h1>

<?php foreach ($citiesCategories as $k => $cityCategory):?>
    <h3><?=$k;?></h3>
    <?php foreach($cityCategory as $category):?>
        <p><?=CHtml::link($category['category']->name,Yii::app()->createUrl("/yiiseo/dealsCategoriesSeo/create", array('category_id' => $category['category']->id, 'city_id' => $category['city']->id)));?></p>
    <?php endforeach;?>
<?php endforeach;?>
