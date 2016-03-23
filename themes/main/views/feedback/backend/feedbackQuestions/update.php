<?php

/**
 * @var $model FeedbackQuestions
 * @var array $statusesList
 * @var array $categoriesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('feedbackModule','Feedback questions')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);

	?>

	<h1><small><?=Yii::t('feedbackModule','Update question');?></small> <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'statusesList' => $statusesList,
    )
); ?>