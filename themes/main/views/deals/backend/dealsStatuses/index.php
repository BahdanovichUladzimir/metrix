<?php
/**
 * @var $model DealsStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Statuses'=>array('index'),
	'Manage',
);
?>

<h1><?=Yii::t('dealsModule','Manage Deals Statuses');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('dealsModule', Yii::t('DealsStatuses','Create new Deals Status')),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'deals-statuses-grid',
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
			'value' => 'CHtml::link($data->name, Yii::app()->createUrl("/deals/backend/dealsStatuses/update",array("id"=>$data->id)))',
		),
		array(
			'name' => 'label',
			'type' => 'raw',
			'value' => 'CHtml::link($data->label, Yii::app()->createUrl("/deals/backend/dealsStatuses/view",array("id"=>$data->id)))',
		),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => "Yii::app()->user->checkAccess('Deals.Backend.DealsStatuses.Delete')",
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-success update'),
                'visible' => "Yii::app()->user->checkAccess('Deals.Backend.DealsStatuses.Update')",

            ),
            'view' => array(
                'options' => array('class' => 'btn btn-info view')
            ),
			),
		),
	),
)); ?>
