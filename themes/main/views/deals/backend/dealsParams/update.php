<?php

/**
 * @var $model DealsParams
 * @var array $typesListData
 * @var array $requiredListData
 * @var array $visibleListData
 */

$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals params')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);

	?>

	<h1><?=Yii::t('dealsModule','Update param {param}', array("{param}" => $model->name));?></h1>

<?php echo $this->renderPartial(
	'_form',
	array(
		'model'=>$model,
		'typesListData' => $typesListData,
		'requiredListData' => $requiredListData,
		'visibleListData' => $visibleListData,
	)
); ?>