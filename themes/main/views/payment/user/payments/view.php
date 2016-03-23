<?php

/**
 * @var $model Payments
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('paymentModule','Payments')=>array('index'),
	$model->id,
);

?>

<h1><?=Yii::t('paymentModule','View payment');?> #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
        array(
            'name' => 'type_id',
            'type' => 'raw',
            'value' => $model->type->name
        ),
        array(
            'name' => 'typeType',
            'type' => 'raw',
            'value' => $model->type->type
        ),
        array(
            'name' => 'app_category_id',
            'type' => 'raw',
            'value' => CHtml::link($model->appCategory->name, Yii::app()->createUrl("/admin/appCategories/update",array('id'=>$model->appCategory->id)))
        ),
		'app_item_id',
        array(
            'name' => 'time',
            'type' => 'raw',
            'value' => $model->getFormattedDate()
        ),
		'amount',
		'real_amount',
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => CHtml::link($model->user_id."(".User::model()->findByPk($model->user_id)->username.")",User::model()->findByPk($model->user_id)->getAdminUrl())
        ),
        'description'
),
)); ?>

