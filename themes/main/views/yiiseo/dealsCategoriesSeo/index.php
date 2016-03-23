<?php

/**
 * @var $model DealsCategoriesSeo
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('yiiseoModule','Deals categories SEO rules')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('yiiseoModule','Manage categories SEO rules');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('yiiseoModule','Create new deals categories SEO rule'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'deals-categories-seo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUpdate' => false,
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1'
            )
        ),
		'category_id'=>array(
			'filter'=>DealsCategories::getListData(true,true,3),
			'name'=>'category_id',
			'value'=>'$data->category->name'
		),
		'city_id'=>array(
			'filter'=>Cities::getAllCitiesListData(),
			'name'=>'city_id',
			'value'=>'$data->city->name',
		),
		'h1',
		'description',
		'keywords',
		/*
		'seotext',*/
		'language',

	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Yiiseo.DealsCategoriesSeo.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Yiiseo.DealsCategoriesSeo.Update')",
				),
				/*'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),*/
			),
		),
	),
)); ?>
