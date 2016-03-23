<?php

/**
 * @var $model DealsCategoriesSeo
 * @var array $categoriesList
 * @var array $citiesList
 * @var array $languagesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('yiiseoModule', 'Deals categories SEO rules')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('yiiseoModule', 'Create Deals categories SEO rule');?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'citiesList' => $citiesList,
        'languagesList' => $languagesList,
    )
); ?>