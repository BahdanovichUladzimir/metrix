<?php

/**
 * @var $model FeedbackCategoriesStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule', 'Feedback categories statuses')=>array('index'),
	Yii::t('feedbackModule', 'Create'),
);

?>

<h1><small><?=Yii::t('feedbackModule', 'Create category status');?></small></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>