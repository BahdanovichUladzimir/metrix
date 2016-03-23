<?php

/**
 * @var $model FeedbackCategories
 * @var array $statusesList
 * @var array $categoriesList
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('feedbackModule','Feedback categories')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);?>

	<h1><small><?=Yii::t('feedbackModule','Update category');?></small> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial(
    '_form',
    array(
        'model'=>$model,
        'categoriesList' => $categoriesList,
        'statusesList' => $statusesList,
    )
); ?>