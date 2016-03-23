<?php

/**
 * @var $model Doings
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('eventsModule', 'Doings')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('eventsModule', 'Create doing');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>