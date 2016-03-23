<?php

/**
 * @var $model FeedbackStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule', 'Messages statuses')=>array('index'),
    Yii::t('core', 'Manage'),
);
?>

<h1><?=Yii::t('feedbackModule','Manage messages statuses');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('feedbackModule','Create new message status'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'feedback-statuses-grid',
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
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("/feedback/backend/feedbackStatuses/update",array("id"=>$data->id)))',
        ),
        array(
            'name' => 'label',
            'type' => 'raw',
            'value' => 'CHtml::link($data->label, Yii::app()->createUrl("/feedback/backend/feedbackStatuses/update",array("id"=>$data->id)))',
        ),
        array(
            'header' => Yii::t('ses', 'Edit'),
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('class' => 'col-lg-3 button-column'),
            'template'=>'{view} {update} {delete}',
            'buttons'=>array(
                'delete' => array(
                    'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Feedback.Backend.FeedbackStatuses.Delete')",
                ),
                'update' => array(
                    'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Feedback.Backend.FeedbackStatuses.Update')",
                ),
                'view' => array(
                    'options' => array('class' => 'btn btn-info view')
                ),
            ),
        ),
    )
)); ?>
