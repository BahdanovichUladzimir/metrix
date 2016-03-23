<?php

/**
 * @var $model Feedback
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('Feedbacks','Feedbacks')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);

	?>

	<h1><?=Yii::t('Feedback','Update Feedback');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>