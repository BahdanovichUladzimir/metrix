<?php

/**
 * @var $model EventsInvitedUsers
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Events Invited Users'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('EventsInvitedUsers', 'Create EventsInvitedUsers');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>