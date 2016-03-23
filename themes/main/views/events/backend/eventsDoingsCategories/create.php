<?php

/**
 * @var $model EventsDoingsCategories
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('eventsModule', 'Events doings categories')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('eventsModule', 'Create Events doings category');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>