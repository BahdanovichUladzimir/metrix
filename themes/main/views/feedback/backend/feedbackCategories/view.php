<?php

/**
 * @var $model FeedbackCategories
 * @var array $childrenListData
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('feedbackModule','Feedback categories')=>array('index'),
	$model->name,
);

?>

<h1><small><?=Yii::t("feedbackModule","View Category");?></small> <?php echo $model->name; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
    'attributes'=>array(
        'id',
        'name',
        array(
            'name' => 'parent_id',
            'type' => 'raw',
            'value' => ((int)$model->parent_id !== 0) ? CHtml::link($model->getParent()->name, Yii::app()->createUrl("/deals/backend/dealsCategories/view",array("id"=>$model->parent_id))) : "None"
        ),
        'description',
        array(
            'name' => 'status_id',
            'type' => 'raw',
            'value' => $model->status->name,
        ),
        array(
            'name' => 'children',
            'label' => Yii::t('dealsModule','Child categories'),
            'type' => 'raw',
            'value' => (sizeof($childrenListData)>0) ? implode(', ', $childrenListData): Yii::t("dealsModule","There are no child cats"),
        )
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
