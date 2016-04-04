<?php

/**
 * @var $model DealsCategories
 * @var array $params
 * @var array $ratings
 * @var array $childrenListData
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals categories')=>array('index'),
	$model->name,
);

?>

<h1><small><?=Yii::t("dealsModule","View Category");?></small> <?php echo $model->name; ?></h1>
<?php if(!is_null($model->image)):?>
    <?=CHtml::image($model->getMediumThumbUrl(),$model->name);?>
<?php endif;?>
<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'url_segment',
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
			'name' => 'dealsCategories.dealsCategoriesParams',
			'label' => 'Params',
			'type' => 'raw',
			'value' => (sizeof($params)>0) ? implode(', ', $params) : Yii::t("dealsModule","There are no params"),
		),array(
			'name' => 'dealsCategories.dealsCategoriesParams',
			'label' => 'Params',
			'type' => 'raw',
			'value' => (sizeof($ratings)>0) ? implode(', ', $ratings) : Yii::t("dealsModule","There are no ratings"),
		),
		array(
			'name' => 'children',
			'label' => Yii::t('dealsModule','Child categories'),
			'type' => 'raw',
			'value' => (sizeof($childrenListData)>0) ? implode(', ', $childrenListData): Yii::t("dealsModule","There are no child cats"),
		),
		'no_index',
		'for_adults'
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

	<?php echo CHtml::link(
		Yii::t('adminModule', 'Create new category'),
		array(
			'create'
		),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>
