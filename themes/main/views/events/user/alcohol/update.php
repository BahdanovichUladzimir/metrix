<?php

/**
 * @var $model Alcohol
 */
$this->breadcrumbs=array(
	Yii::t('eventsModule','My events')=>array('/user/profile/privateProfile#events'),
	$model->event->name=>Yii::app()->createUrl('/events/user/events/view', array("id" => $model->event_id)),
	Yii::t('eventsModule','Alcohol calculator'),
);?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>