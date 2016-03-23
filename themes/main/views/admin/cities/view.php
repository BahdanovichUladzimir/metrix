<?php
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Cities'=>array('index'),
	$model->name,
);?>

<h1>View City <?php echo $model->name; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		array(
			'name' => 'country_id',
			'type' => 'raw',
			'value' => CHtml::link($model->country->name,Yii::app()->createUrl("admin/countries/view",array("id"=>$model->country_id)))
		),
		'key',
		'priority',
		'longitude',
		'latitude',
		),
	)
); ?>
<div class="form-actions">
	<?php echo CHtml::link(
		Yii::t('adminModule', "Edit"),
		array(
			'update', 'id'=>$model->id
		),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</div>
