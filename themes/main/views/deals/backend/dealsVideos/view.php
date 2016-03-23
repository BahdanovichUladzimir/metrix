<?php

/**
 * @var $model DealsVideos
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Videoses'=>array('index'),
	$model->name,
);

?>

<h1>View DealsVideos #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'file_name',
		'ext',
		'path',
		'url',
		'dir_path',
		'dir_url',
		'width',
		'height',
		'duration',
		'deal_id',
		'approve',
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
