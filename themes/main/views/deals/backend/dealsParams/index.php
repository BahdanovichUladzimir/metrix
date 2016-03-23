<?php

/**
 * @var $model DealsParams
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals params')=>array('index'),
	Yii::t('adminModule','Manage'),
);
?>

<h1><?=Yii::t('dealsModule','Manage deals params');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('dealsModule', Yii::t('DealsParams','Create new param')),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'deals-params-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'sortableRows'=>true,
	'ajaxUpdate' => false,
	'template' => '{pager}{items}{pager}',
	'enablePagination' => true,
	//'ajaxUpdate'=>false,
	'columns'=>array(
		array(
			'name' => 'id',
			'header' => 'ID',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			)
		),
		array(
			'header' => 'Name',
			'name' => 'name',
			'type' => 'raw',
			'value' => 'CHtml::link($data->name,Yii::app()->createUrl("deals/backend/dealsParams/update",array("id"=>$data->id)))',
		),
		array(
			'header' => 'Label',
			'name' => 'label',
			'type' => 'raw',
			'value' => 'CHtml::link($data->label,Yii::app()->createUrl("deals/backend/dealsParams/update",array("id"=>$data->id)))',
		),
		array(
			'name' => 'type_id',
			'header' => 'Type',
			'type' => 'raw',
			'value' => 'CHtml::link($data->type->label,Yii::app()->createUrl("deals/backend/dealsParamsTypes/view",array("id"=>$data->type_id)))',
			'filter' => DealsParamsTypes::getListData(),
		),
		/*'type_id',
		'field_size',
		'field_size_min',
		'required',
		'match',*/
		/*
		'range',
		'error_message',
		'other_validator',
		'default',
		'position',
		'visible',
		'widget',
		'widget_params',
		'name',
		'label',
		*/
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>Yii::app()->user->checkAccess('Deals.Backend.DealsParams.Delete') ? '{update} {delete}' : '{update}',
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
