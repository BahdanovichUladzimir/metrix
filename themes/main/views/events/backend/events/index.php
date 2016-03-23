<?php

/**
 * @var $model Events
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('eventsModule','Events')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('eventsModule','Manage events');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new event'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'value' => 'CHtml::link($data->id,Yii::app()->createUrl("/events/user/events/view", array("id" => $data->id)))',
			'type' => 'raw'
		),
		array(
			'name' => 'name',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'value' => 'CHtml::link($data->name,Yii::app()->createUrl("/events//user/events/view", array("id" => $data->id)))',
			'type' => 'raw'
		),
		'description',
		array(
			'name' => 'user_id',
			'header' => 'User ID',
			'type' => 'raw',
			'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
		),
		array(
			'name' => 'status_id',
			'header' => 'Status',
			'type' => 'raw',
			'value' => 'Events::getStatusesListData()[$data->status_id]',
			'filter' => Events::getStatusesListData(),
		),
		array(
			'name' => 'type_id',
			'header' => 'Type',
			'type' => 'raw',
			'value' => '$data->type->label',
			'filter' => EventsTypes::getListData(),
		),
        array(
            'name' => 'public_status_id',
            'header' => 'Public status',
            'type' => 'raw',
            'value' => 'Events::getPublicStatusesListData()[$data->public_status_id]',
            'filter' => Events::getPublicStatusesListData(),
        ),

        /*
        'public_status_id',
        'url',
        'login',
        'password',
        */
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(

            'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => 'Yii::app()->user->checkAccess("Events.Backend.Events.Delete")'
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-success update'),
                'visible' => 'Yii::app()->user->checkAccess("Events.Frontend.Events.Update")',
                'url'=>'Yii::app()->createUrl("/events/user/events/update", array("id" => $data->id))',

            ),
            'view' => array(
                'options' => array('class' => 'btn btn-info view'),
                'url' => 'Yii::app()->createUrl("/events/user/events/view", array("id" => $data->id))',
                'visible' => 'Yii::app()->user->checkAccess("Deals.Backend.Deals.View")'
            ),

        ),
		),
	),
)); ?>
