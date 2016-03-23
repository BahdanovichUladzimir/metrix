<?php

/**
 * @var $model Payments
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('paymentModule','Payments')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('paymentModule','Manage payments');?></h1>

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'payments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'app_category_id',
        array(
            'name' => 'app_category_id',
            'header' => 'Application category',
            'type' => 'raw',
            'value' => '$data->appCategory->name',
            'filter' => AppCategories::getListData(),
        ),
		//'app_item_id',
		'user_id',
        array(
            'name' => 'time',
            'header' => 'Date',
            'type' => 'raw',
            'value' => '$data->getFormattedDate()',
        ),
        array(
            'name' => 'type_id',
            'header' => 'Type',
            'type' => 'raw',
            'value' => '$data->type->name',
            'filter' => PaymentsTypes::getListData(),
        ),
        array(
            'name' => 'typeType',
            'header' => 'Type type',
            'type' => 'raw',
            'value' => '$data->type->type',
            'filter' => PaymentsTypes::getTypesListData(),
        ),

		'amount',
		'real_amount',
	array(
		'header' => Yii::t('ses', 'View'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view}',
		'buttons'=>array(
			/*'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Payment.Backend.Payments.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Payment.Backend.Payments.Update')",
				),*/
				'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),
			),
		),
	),
)); ?>
