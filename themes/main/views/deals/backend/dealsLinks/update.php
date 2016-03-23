<?php

/**
 * @var $model DealsImages
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('Deals Images','Deals Images')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);

	?>

	<h1><?=Yii::t('DealsImages','Update DealsImages');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>