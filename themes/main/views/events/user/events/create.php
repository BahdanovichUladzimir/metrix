<?php

/**
 * @var $model Events
 */
$this->breadcrumbs=array(
	Yii::t('userModule','My profile')=>$this->user->getPrivateUrl(),
	Yii::t('eventsModule','My events')=>$this->user->getPrivateUrl()."#events",
	Yii::t('core', 'Create'),
);?>
<h1 class="title section-title"><?=Yii::t('eventsModule','Create event');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>