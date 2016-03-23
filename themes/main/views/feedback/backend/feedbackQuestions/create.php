<?php

/**
 * @var $model FeedbackQuestions
 * @var array $statusesList
 * @var array $categoriesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule', 'Feedback questions')=>array('index'),
	Yii::t('feedbackModule', 'Create'),
);

?>

<h1><?=Yii::t('feedbackModule', 'Create feedback question');?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'statusesList' => $statusesList,
    )
); ?>