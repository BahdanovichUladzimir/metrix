<?php

/**
 * @var $model FeedbackQuestionsStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule', 'Feedback questions statuses')=>array('index'),
	Yii::t('feedbackModule', 'Create'),
);

?>

<h1><?=Yii::t('feedbackModule', 'Create feedback questions status');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>