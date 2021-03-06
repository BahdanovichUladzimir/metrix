<?php
/**
 * @var $model Cities
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Cities'),
);?>

<h1><?=Yii::t("adminModule","Manage Cities");?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', "Create new city"),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'cities-grid',
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
			'value' => 'CHtml::link($data->name,$data->getAdminUrl())'
		),
		array(
			'name' => 'country_id',
			'header' => 'Country',
			'type' => 'raw',
			'value' => 'CHtml::link($data->country->name,$data->country->getAdminUrl())',
			'filter' => CHtml::listData(Countries::model()->findAll(), 'id', 'name'),
		),
		'key',
		'priority',
		/*'longitude',
		'latitude',*/
		array(
			'header' => Yii::t('ses', 'Edit'),
			'class'=>'booster.widgets.TbButtonColumn',
			'htmlOptions' => array('class' => 'col-lg-3 button-column'),
			'template'=> Yii::app()->user->checkAccess('Admin.Cities.Delete') ? '{update} {delete}' : '{update}',
			'buttons'=>array
			(
				'delete' => array
				(
					'options' => array('class' => 'btn btn-danger delete')
				),
				'update' => array
				(
					'options' => array('class' => 'btn btn-success update')
				),
				'view' => array
				(
					'options' => array('class' => 'btn btn-info view')
				),
			),
			),
		),
	)
);?>
