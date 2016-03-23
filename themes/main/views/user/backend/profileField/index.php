<?php
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('userModule','Profile Fields'),
);
/*$this->menu=array(
    array('label'=>Yii::t('userModule','Create Profile Field'), 'url'=>array('create')),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('/user/admin')),
);*/
?>
<h1><?php echo Yii::t('userModule','Manage Profile Fields'); ?></h1>

<p><?php echo Yii::t('userModule',"You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>
<p>
	<?php echo CHtml::link(
		Yii::t('userModule','Create Profile Field'),
		array('create'),
		array(
			'class'=>'btn btn-success',
			)
	);?>
</p>
<?php $this->widget('booster.widgets.TbExtendedGridView', array(
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			'name'=>'varname',
			'type'=>'raw',
			'value'=>'UHtml::markSearch($data,"varname")',
		),
		array(
			'name'=>'title',
			'value'=>'Yii::t("userModule",$data->title)',
		),
		array(
			'name'=>'field_type',
			'value'=>'$data->field_type',
			'filter'=>ProfileField::itemAlias("field_type"),
		),
		'field_size',
		//'field_size_min',
		array(
			'name'=>'required',
			'value'=>'ProfileField::itemAlias("required",$data->required)',
			'filter'=>ProfileField::itemAlias("required"),
		),
		//'match',
		//'range',
		//'error_message',
		//'other_validator',
		//'default',
		'position',
		array(
			'name'=>'visible',
			'value'=>'ProfileField::itemAlias("visible",$data->visible)',
			'filter'=>ProfileField::itemAlias("visible"),
		),
		//*/
		array(
			'class'=>'booster.widgets.TbButtonColumn',
		),
	),
)); ?>
