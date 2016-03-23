<?php

/**
 * @var $model DealsCategories
 * @var array $statusesList
 * @var array $categoriesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals categories')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('adminModule','Update'),
);

	?>

	<h1><?=Yii::t("dealsModule","Update category {category}", array('{category}' => $model->name));?></h1>

<?php echo $this->renderPartial(
	'_form',
	array(
		'model'=>$model,
		'categoriesList' => $categoriesList,
		'statusesList' => $statusesList,
	)
); ?>