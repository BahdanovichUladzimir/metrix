<?php

/**
 * @var $model UserMessages
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'User Messages'=>array('index'),
	$model->id,
);

?>

<h1>View UserMessages #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'body',
		'sender_id',
		'receiver_id',
		'is_read',
		'deleted_by',
		'created_at',
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
