<?php
/**
 * @var $model Countries
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Countries'),
);?>

<h1><?=Yii::t("adminModule","Manage Countries");?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', "Create new country"),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'countries-grid',
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
			'value' => 'CHtml::link($data->name,$data->getAdminUrl())',
		),
		'key',
		'default_language',
		'priority',
		array(
			'header' => Yii::t('ses', 'Edit'),
			'class'  => 'bootstrap.widgets.TbButtonColumn',
			'template'=> Yii::app()->user->checkAccess('Admin.Countries.Delete') ? '{update} {delete}' : '{update}',
			'htmlOptions' => array('class' => 'col-lg-3 button-column'),
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
	)
); ?>
