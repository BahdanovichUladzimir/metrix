<?php

/**
 * @var $model EventsInvitedUsers
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('Events Invited Users','Events Invited Users')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('EventsInvitedUsers','Update EventsInvitedUsers');?></small> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>