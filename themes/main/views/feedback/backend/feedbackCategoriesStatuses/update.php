<?php

/**
 * @var $model FeedbackCategoriesStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('feedbackModule','Feedback categories statuses')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);

	?>

	<h1><small><?=Yii::t('feedbackModule','Update category status');?> </small><?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>