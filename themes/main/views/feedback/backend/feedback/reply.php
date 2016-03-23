<?php

/**
 * @var $model Feedback
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('feedbackModule','Feedbacks')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('core','Reply'),
);

	?>

	<h1><small><?=Yii::t('feedbackModule','Reply to message');?></small> <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_reply_form',array('model'=>$model)); ?>