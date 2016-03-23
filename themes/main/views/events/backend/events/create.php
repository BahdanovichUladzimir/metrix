<?php

/**
 * @var $model Events
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Events'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('Events', 'Create Events');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>