<?php

/**
 * @var $model Doings
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('eventsModule','Doings')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('eventsModule','Manage doings');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new doing'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'doings-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate' => false,
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'type' => 'raw'
        ),

        'name',
		'description',
		array(
            'name' => 'eventsTypes',
            'type' => 'raw',
            'value' => '$data->getTypesString()',
            'filter' => false,
        ),
		array(
            'name' => 'category',
            'type' => 'raw',
            'value' => 'CHtml::link($data->category->name,Yii::app()->createUrl("/events/backend/eventsDoingsCategories/update", array("id" => $data->category->id)))',
            'filter' => false,
        ),
        array(
            'header' => Yii::t('ses', 'Edit'),
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('class' => 'col-lg-3 button-column'),
            'template'=>'{view} {update} {delete}',
            'buttons'=>array(
                'delete' => array(
                        'options' => array('class' => 'btn btn-danger delete'),
                        'visible' => "Yii::app()->user->checkAccess('Events.Backend.EventsDoings.Delete')",
                    ),
                    'update' => array(
                        'options' => array('class' => 'btn btn-success update'),
                        'visible' => "Yii::app()->user->checkAccess('Events.Backend.EventsDoings.Update')",
                    ),
                    'view' => array(
                        'options' => array('class' => 'btn btn-info view')
                    ),
                ),
            ),
	),
)); ?>
