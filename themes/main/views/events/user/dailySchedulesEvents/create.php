<?php

/**
 * @var $model DailySchedulesEvents
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Daily Schedules Events'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('DailySchedulesEvents', 'Create DailySchedulesEvents');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>