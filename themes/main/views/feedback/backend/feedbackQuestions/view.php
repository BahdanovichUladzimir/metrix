<?php

/**
 * @var $model FeedbackQuestions
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule','Feedback questions')=>array('index'),
	$model->title,
);

?>

<h1><small><?=Yii::t('feedbackModule','View question');?></small> <?php echo $model->title; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'question',
		'reply',
        array(
            'name' => 'created_date',
            'type' => 'raw',
            'value' => $model->formattedCreatedDate
        ),
        array(
            'name' => 'category_id',
            'type' => 'raw',
            'value' => ((int)$model->category_id !== 0) ? CHtml::link($model->category->name, Yii::app()->createUrl("/deals/backend/dealsCategories/view",array("id"=>$model->category_id))) : "None"
        ),
        array(
            'name' => 'status_id',
            'type' => 'raw',
            'value' => $model->status->name,
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
	);?>
</p>
