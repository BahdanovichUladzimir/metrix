<?php

/**
 * @var $model Dictionary
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Dictionaries'=>array('index'),
	$model->name,
);

?>

<h1>View Dictionary #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'letter',
		'description',
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
