<?php

/**
 * @var $model EventsInvitedUsers
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Events Invited Users'=>array('index'),
	$model->id,
);

?>

<h1>View EventsInvitedUsers #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'event_id',
		'user_id',
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
