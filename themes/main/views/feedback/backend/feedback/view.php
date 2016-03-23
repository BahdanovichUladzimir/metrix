<?php

/**
 * @var $model Feedback
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule','Feedback messages')=>array('index'),
	$model->title,
);

?>

<h1><small><?=Yii::t('feedbackModule','View feedback message');?></small> <?php echo $model->title; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'user_email',
		'user_name',
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => (!is_null($model->user_id)) ? CHtml::link($model->user_id."(".User::model()->findByPk($model->user_id)->username.")",User::model()->findByPk($model->user_id)->getAdminUrl()): 'not set',
        ),
        array(
            'name' => 'status_id',
            'type' => 'raw',
            'value' => $model->status->label
        ),
        array(
            'name' => 'recipient_id',
            'type' => 'raw',
            'value' => (!is_null($model->recipient_id)) ? CHtml::link($model->recipient_id."(".$model->recipient->username.")",$model->recipient->getAdminUrl()): 'not set',
        ),
		'message',
		'reply',
        array(
            'name' => 'created_date',
            'type' => 'raw',
            'value' => $model->formattedCreatedDate
        ),
        array(
            'name' => 'reply_date',
            'type' => 'raw',
            'value' => $model->formattedRepliedDate
        ),
),
)); ?>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', 'Edit'),
		array(
			'update', 'id'=>$model->id
		),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
