<?php

/**
 * @var $model Feedback
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Feedbacks'=>array('index'),
	Yii::t('Feedback', 'Create'),
);

?>

<h1><?=Yii::t('Feedback', 'Create Feedback');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>