<?php

/**
 * @var $model FeedbackQuestions
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule','Feedback questions')=>array('index'),
    Yii::t('feedbackModule','Manage'),
);
?>

<h1><?=Yii::t('feedbackModule','Manage feedback questions');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('feedbackModule','Create new question'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'feedback-questions-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'value' => 'CHtml::link($data->id,array("/feedback/backend/feedback/view", "id" => $data->id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, Yii::app()->createUrl("/feedback/backend/feedbackQuestions/view",array("id"=>$data->id)))',
        ),
        array(
            'name' => 'status_id',
            'type' => 'raw',
            'value' => '$data->status->label',
            'filter' => CHtml::listData(FeedbackQuestionsStatuses::model()->findAll(), 'id', 'label'),
        ),
        array(
            'name' => 'category_id',
            'header' => 'Parent category',
            'type' => 'raw',
            'value' => '((int)$data->category_id !== 0) ? CHtml::link($data->category->name, Yii::app()->createUrl("/feedback/backend/feedbackCategories/view",array("id"=>$data->category_id))) : "None"',
            'filter' => FeedbackCategories::getListData(),
        ),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
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
