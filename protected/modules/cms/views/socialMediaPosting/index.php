<?php

/**
 * @var $model SocialMediaPosting
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('cmsModule','Social media posts')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('cmsModule','Manage social media posts');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('cmsModule','Create new social media post'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'social-media-posting-grid',
	'dataProvider'=>$model->search(),
    'ajaxUpdate' => false,
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            //'value' => 'CHtml::link($data->id,$data->getPublicUrl())',
            'type' => 'raw'
        ),
		'title',
		//'description',
		'post_date_time',
		'posted_date_time',
        array(
            'name' => 'status',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'value' => '$data->getStatusName()',
            'type' => 'raw',
            'filter' => SocialMediaPosting::$statuses
        ),
        array(
            'name' => 'type',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'value' => '$data->getTypeName()',
            'type' => 'raw',
            'filter' => SocialMediaPosting::$types
        ),
        array(
            'name' => 'network',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'value' => '$data->getNetworkName()',
            'type' => 'raw',
            'filter' => SocialMediaPosting::$networks
        ),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Cms.SocialMediaPosting.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Cms.SocialMediaPosting.Update')",
				),
				'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),
			),
		),
	),
)); ?>
