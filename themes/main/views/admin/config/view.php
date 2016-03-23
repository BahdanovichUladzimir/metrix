<?php
/**
 * @var $model Config
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Configs')=>array('index'),
	$model->label,
);?>

<h3><small><?=Yii::t('adminModule',"View config param");?></small> <?php echo $model->param; ?></h3>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'param',
		'value',
		'default',
		'label',
		'type',
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
