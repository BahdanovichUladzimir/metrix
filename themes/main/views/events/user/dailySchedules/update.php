<?php

/**
 * @var $model DailySchedules
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('Daily Schedules','Daily Schedules')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('DailySchedules','Update DailySchedules');?></small> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>