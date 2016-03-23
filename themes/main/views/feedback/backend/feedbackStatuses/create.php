<?php

/**
 * @var $model FeedbackStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule', 'Messages statuses')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('feedbackModule', 'Create messages status');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>