<?php

/**
 * @var $model DealsParamsTypes
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Params Types'=>array('index'),
	$model->name,
);

?>

<h1><?=Yii::t('dealsModule','View Type');?> <?php echo $model->name; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'label',
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
