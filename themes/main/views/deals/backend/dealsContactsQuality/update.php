<?php

/**
 * @var $model DealsStatistics
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('Deals Statistics','Deals Statistics')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('DealsStatistics','Update DealsStatistics');?></small> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>