<?php

/**
 * @var $model DailySchedulesEvents
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('Daily Schedules Events','Daily Schedules Events')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('DailySchedulesEvents','Update DailySchedulesEvents');?></small> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>