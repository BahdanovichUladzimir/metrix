<?php

/**
 * @var $model EventsTypes
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('eventsModule','Events types')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('eventsModule', 'Create events type');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>