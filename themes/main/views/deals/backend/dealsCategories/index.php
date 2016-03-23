<?php
/**
 * @var $model DealsCategories
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals categories')=>array('index'),
	Yii::t('adminModule','Manage'),
);
?>

<h1><?=Yii::t("dealsModule","Manage deals categories");?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('dealsModule', 'Create new Category'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'deals-categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'sortableRows'=>true,
	'template' => '{pager}{items}{pager}',
	'enablePagination' => true,
	'ajaxUpdate'=>false,
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
			'value' => 'CHtml::link($data->name, Yii::app()->createUrl("/deals/backend/dealsCategories/view",array("id"=>$data->id)))',
		),

		array(
			'name' => 'parent_id',
			'header' => 'Parent category',
			'type' => 'raw',
			'value' => '((int)$data->parent_id !== 0) ? CHtml::link($data->getParent()->name, Yii::app()->createUrl("/deals/backend/dealsCategories/view",array("id"=>$data->parent_id))) : "None"',
			'filter' => DealsCategories::getListData(),
		),

		array(
			'name' => 'status_id',
			'type' => 'raw',
			'value' => '$data->status->label',
			'filter' => CHtml::listData(DealsCategoriesStatuses::model()->findAll(), 'id', 'label'),

		),
		array(
			'name' => 'params',
			'type' => 'raw',
			'value' => '$data->getParamsString()',
			'filter' => false,

		),
		'priority',
		array(
			'header' => Yii::t('ses', 'Edit'),
			'class'=>'booster.widgets.TbButtonColumn',
			'htmlOptions' => array('class' => 'col-lg-3 button-column'),
			'template'=>'{view} {update} {delete}',
			'buttons'=>array(
				'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Deals.Backend.DealsCategories.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Deals.Backend.DealsCategories.Update')",
                ),
				'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),
			),
		),
	),
)); ?>
