<?php

/**
 * @var $model DealsStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule', 'Deals Statuses')=>array('index'),
	Yii::t('dealsModule', 'Create'),
);

?>

<h1><?=Yii::t('dealsModule', 'Create status');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>