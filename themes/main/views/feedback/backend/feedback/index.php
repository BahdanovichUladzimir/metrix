<?php

/**
 * @var $model Feedback
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule','Feedback messages')=>array('index'),
    Yii::t('feedbackModule','Manage'),
);
?>

<h1><?=Yii::t('feedbackModule','Manage feedback messages');?></h1>

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'feedback-grid',
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
            'name' => 'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, Yii::app()->createUrl("/feedback/backend/feedback/view",array("id"=>$data->id)))',
        ),
        'user_name',
        array(
            'name' => 'user_id',
            'header' => 'User ID',
            'type' => 'raw',
            'value' => '(!is_null($data->user_id)) ? CHtml::link($data->user_id." (".User::model()->findByPk($data->user_id)->username.")",User::model()->findByPk($data->user_id)->getAdminUrl()) : "none"',
        ),
        array(
            'name' => 'status_id',
            'header' => 'Status',
            'type' => 'raw',
            'value' => '$data->status->label',
            'filter' => FeedbackStatuses::getListData(),
        ),
        array(
            'name' => 'recipient_id',
            'header' => 'User ID',
            'type' => 'raw',
            'value' => '(!is_null($data->recipient_id)) ? CHtml::link($data->recipient_id." (".User::model()->findByPk($data->recipient_id)->username.")",User::model()->findByPk($data->recipient_id)->getAdminUrl()) : "none"',
        ),
		/*'message',
		'reply',
		'created_date',
		'reply_date',
		*/
        array(
            'header' => Yii::t('ses', 'Edit'),
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('class' => 'col-lg-3 button-column'),
            'template'=>'{view} {reply} {delete}',
            'buttons'=>array(
                'delete' => array(
                    'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Feedback.Backend.Feedback.Delete')",
                ),
                'reply' => array(
                    'options' => array(
                        'class' => 'btn btn-success update',
                        'rel' => 'tooltip',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('feedbackModule', 'Reply'),
                    ),
                    //'url' => "Yii::app()->createUrl('/feedback/backend/feedback/reply',array('id' => '$data->id'))",
                    'url' => 'Yii::app()->createUrl("/feedback/backend/feedback/reply", array("id"=>$data->id))',
                    'label' => "<i class='glyphicon glyphicon-envelope'></i>",
                    'visible' => 'Yii::app()->user->checkAccess("Feedback.Backend.Feedback.Reply") && $data->status_id == 2',
                ),
                'view' => array(
                    'options' => array('class' => 'btn btn-info view'),
                    'visible' => "Yii::app()->user->checkAccess('Feedback.Backend.Feedback.View')",
                ),
            ),
        ),
	),
)
); ?>
