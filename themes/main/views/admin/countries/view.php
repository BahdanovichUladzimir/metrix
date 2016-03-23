<?php
/**
 * @var $model Countries
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Countries'=>array('index'),
	$model->name,
);?>

<h1>View Country <?php echo $model->name; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'key',
		'priority',
		),
	)
); ?>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', "Edit"),
		array(
			'update', 'id'=>$model->id
		),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>
