<?php

/**
 * @var $model DealsCategories
 * @var array $statusesList
 * @var array $categoriesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals categories')=>array('index'),
	Yii::t('adminModule','Create'),
);

?>

<h1><?=Yii::t("dealsModule","Create new Category");?></h1>

<?php echo $this->renderPartial(
	'_form',
	array(
		'model'=>$model,
		'categoriesList' => $categoriesList,
		'statusesList' => $statusesList,
	)
); ?>