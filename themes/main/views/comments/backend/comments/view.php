<?php

/**
 * @var $model Comments
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Comments'=>array('index'),
	$model->title,
);

?>

<h1>View Comments #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'parent_id',
		'description',
		'app_category_id',
		'app_category_item_id',
		'user_id',
		'approve',
		'created_date',
		'published_date',
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
