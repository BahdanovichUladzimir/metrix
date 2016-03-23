<?php
$this->breadcrumbs=array(
	Yii::t('userModule','Profile Fields')=>array('admin'),
	Yii::t('userModule',$model->title),
);
$this->menu=array(
    array('label'=>Yii::t('userModule','Create Profile Field'), 'url'=>array('create')),
    array('label'=>Yii::t('userModule','Update Profile Field'), 'url'=>array('update','id'=>$model->id)),
    array('label'=>Yii::t('userModule','Delete Profile Field'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('userModule','Are you sure to delete this item?'))),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('/user/admin')),
);
?>
<h1><?php echo Yii::t('userModule','View Profile Field #').$model->varname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'varname',
		'title',
		'field_type',
		'field_size',
		'field_size_min',
		'required',
		'match',
		'range',
		'error_message',
		'other_validator',
		'widget',
		'widgetparams',
		'default',
		'position',
		'visible',
	),
)); ?>
