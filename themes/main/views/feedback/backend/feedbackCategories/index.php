<?php

/**
 * @var $model FeedbackCategories
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule','Feedback categories')=>array('index'),
    Yii::t('feedbackModule','Manage'),
);
?>

<h1><?=Yii::t('feedbackModule','Manage Feedback Categories');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('feedbackModule', 'Create new category'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'feedback-categories-grid',
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
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("/feedback/backend/feedbackCategories/view",array("id"=>$data->id)))',
        ),
        array(
            'name' => 'parent_id',
            'header' => 'Parent category',
            'type' => 'raw',
            'value' => '((int)$data->parent_id !== 0) ? CHtml::link($data->getParent()->name, Yii::app()->createUrl("/feedback/backend/feedbackCategories/view",array("id"=>$data->parent_id))) : "None"',
            'filter' => FeedbackCategories::getListData(),
        ),
        array(
            'name' => 'status_id',
            'type' => 'raw',
            'value' => '$data->status->label',
            'filter' => CHtml::listData(FeedbackCategoriesStatuses::model()->findAll(), 'id', 'label'),
        ),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => "Yii::app()->user->checkAccess('Feedback.Backend.FeedbackCategories.Delete')",
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-success update'),
                'visible' => "Yii::app()->user->checkAccess('Feedback.Backend.FeedbackCategories.Update')",
            ),
            'view' => array(
                'options' => array('class' => 'btn btn-info view')
            ),
			),
		),
	),
)); ?>
