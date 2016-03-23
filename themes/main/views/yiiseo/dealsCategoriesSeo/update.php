<?php

/**
 * @var $model DealsCategoriesSeo
 * @var array $categoriesList
 * @var array $citiesList
 * @var array $languagesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('yiiseoModule','Deals categories SEO rules')=>array('index'),
	$model->id=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);?>

	<h1><small><?=Yii::t('yiiseoModule','Update deals categories SEO rule');?></small> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'citiesList' => $citiesList,
        'languagesList' => $languagesList,
    )
); ?>