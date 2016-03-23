<?php

/**
 * @var $model DealsCategoriesSeo
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Categories Seos'=>array('index'),
	$model->id,
);

?>

<h1>View DealsCategoriesSeo #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category_id',
		'city_id',
		'h1',
		'description',
		'keywords',
		'seotext',
		'language',
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
	);?>
</p>
