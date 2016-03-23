<?php
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Categories Statuses'=>array('index'),
	'Manage',
);
?>

<h1>Manage Deals Categories Statuses</h1>
<p>
	<?php echo CHtml::link(
		Yii::t('dealsModule', 'Create new status'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'deals-categories-statuses-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			)
		),
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->name,Yii::app()->createUrl("deals/backend/dealsCategoriesStatuses/view",array("id"=>$data->id)))',
		),
		'label',
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete')
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update')
				),
				'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),
			),
		),
	),
)); ?>
