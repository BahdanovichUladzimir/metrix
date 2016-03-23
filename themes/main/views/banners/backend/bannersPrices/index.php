<?php

/**
 * @var $model BannersPrices
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('bannersModule','Banners prices')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('bannersModule','Manage banners prices');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('bannersModule','Create new banners price'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'banners-prices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
            'header' => "City",
			'name' => 'city_id',
			'headerHtmlOptions' => array(
				//'class' => 'col-xs-1 col-sm-1 col-md-1'
			),
			'value' => '$data->city->name',
			'type' => 'raw'

		),
		array(
            'header' => "Category",
            'name' => 'category_id',
			'headerHtmlOptions' => array(
				//'class' => 'col-xs-1 col-sm-1 col-md-1'
			),
			'value' => '$data->category->name',
			'type' => 'raw'

		),
		//'category_id',
		'price',
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Banners.Backend.BannersPrices.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Banners.Backend.BannersPrices.Update')",
				),
			),
		),
	),
)); ?>
