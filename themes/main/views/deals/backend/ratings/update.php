<?php

/**
 * @var $model Ratings
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Ratings')=>array('index'),
	$model->label=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('dealsModule','Update rating');?></small> <?php echo $model->label; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>