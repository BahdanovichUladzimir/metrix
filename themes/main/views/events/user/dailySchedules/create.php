<?php

/**
 * @var $model DailySchedules
 */
$this->breadcrumbs=array(
	Yii::t('eventsModule','My events')=>array('/user/profile/privateProfile#events'),
	$model->event->name=>Yii::app()->createUrl('/events/user/events/view', array("id" => $model->event_id)),
	Yii::t('eventsModule','Daily schedules')=>Yii::app()->createUrl('/events/user/events/view', array("id" => $model->event_id)),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('DailySchedules', 'Create daily schedule');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>