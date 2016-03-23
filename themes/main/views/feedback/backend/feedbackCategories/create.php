<?php

/**
 * @var $model FeedbackCategories
 * @var array $statusesList
 * @var array $categoriesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule', 'Feedback categories')=>array('index'),
	Yii::t('feedbackModule', 'Create'),
);

?>

<h1><?=Yii::t('feedbackModule', 'Create feedback category');?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'statusesList' => $statusesList,
    )
); ?>