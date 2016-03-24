<?php

/**
 * @var $model DailySchedulesEvents
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Daily Schedules Events'=>array('index'),
	$model->name,
);

?>

<h1>View DailySchedulesEvents #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'start',
		'end',
		'schedule_id',
),
)); ?>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', 'Edit'),
		array(
			'update', 'id'=>$model->id
		),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
