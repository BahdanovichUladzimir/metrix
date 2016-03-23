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
	Yii::t('DealsParams', 'Create'),
);

?>

<h1><?=Yii::t('dealsModule', 'Create param');?></h1>

<?php echo $this->renderPartial(
	'_form',
	array(
		'model'=>$model,
		'typesListData' => $typesListData,
		'requiredListData' => $requiredListData,
		'visibleListData' => $visibleListData,
	)
); ?>