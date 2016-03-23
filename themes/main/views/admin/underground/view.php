<?php

/**
 * @var $model Underground
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Undergrounds'=>array('index'),
	$model->name,
);

?>

<h1>View Underground <?php echo $model->name; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => CHtml::link($model->name,Yii::app()->createUrl("admin/underground/view",array("id"=>$model->id)))
		),
		array(
			'name' => 'city_id',
			'type' => 'raw',
			'value' => CHtml::link($model->city->name,Yii::app()->createUrl("admin/cities/view",array("id"=>$model->city_id)))
		),
		'longitude',
		'latitude',
		'priority',
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
