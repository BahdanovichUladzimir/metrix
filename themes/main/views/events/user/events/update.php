<?php

/**
 * @var $model Events
 */
$this->breadcrumbs=array(
	Yii::t('userModule','My profile')=>$this->user->getPrivateUrl(),
	Yii::t('eventsModule','My events')=>$this->user->getPrivateUrl()."#events",
	$model->name=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);?>
<h1 class="title section-title"><small><?=Yii::t('eventsModule','Update event');?></small> <?php echo $model->name; ?></h1>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>