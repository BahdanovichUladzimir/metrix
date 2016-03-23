<?php

/**
 * @var $model DealsCategoriesStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Categories Statuses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	?>

	<h1>Update DealsCategoriesStatuses <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>