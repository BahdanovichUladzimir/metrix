<?php

/**
 * @var $model DealsParamsTypes
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Params Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	?>

	<h1><?php echo Yii::t('dealsModule','Update Type');?> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>