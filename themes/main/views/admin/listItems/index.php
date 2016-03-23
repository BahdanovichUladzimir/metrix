<?php

/**
 * @var $model ListItems
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Lists items')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('adminModule','Manage lists items');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new list item'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'list-items-grid',
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
            'name' => 'list_id',
            'header' => 'List name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->list->name,Yii::app()->createUrl("/admin/lists/update", array("id" => $data->list->id)))',
            'filter' => CHtml::listData(Lists::model()->findAll(), 'id', 'name'),
        ),
		//'list_id',
		'name',
		'value',
		'sort',
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Admin.ListItems.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Admin.ListItems.Update')",
				),
			),
		),
	),
)); ?>
