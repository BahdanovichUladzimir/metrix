<?php
/**
 * @var $model DealsParamsTypes
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('dealsModule','Deals params types')=>array('index'),
    Yii::t('dealsModule','Manage'),
);
?>

<h1><?php echo Yii::t('dealsModule','Manage deals params types');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('dealsModule', Yii::t('dealsModule','Create new Params Type')),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'deals-params-types-grid',
	'dataProvider'=>$model->search(),
    'ajaxUpdate' => false,
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			)
		),
		array(
			'header' => 'Label',
			'name' => 'label',
			'type' => 'raw',
			'value' => 'CHtml::link($data->label,Yii::app()->createUrl("deals/backend/dealsParamsTypes/update",array("id"=>$data->id)))',
		),
		array(
			'header' => 'Name',
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->name,Yii::app()->createUrl("deals/backend/dealsParamsTypes/update",array("id"=>$data->id)))',
		),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
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
