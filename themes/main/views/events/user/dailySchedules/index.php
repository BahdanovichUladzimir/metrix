<?php

/**
 * @var $model DailySchedules
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('core','Daily Schedules')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('DailySchedules','Manage Daily Schedules');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new DailySchedules'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'daily-schedules-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'description',
		'date',
		'event_id',
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('.Update')",
				),
				'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),
			),
		),
	),
)); ?>
