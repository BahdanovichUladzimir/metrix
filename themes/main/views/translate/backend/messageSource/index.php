<?php

/**
 * @var $model MessageSource
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('translateModule','Message sources')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('translateModule','Manage message sources');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('translateModule','Create new source'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'message-source-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUpdate' => false,
	'template' => "{summary}{pager}{items}{pager}{summary}",
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'value' => 'CHtml::link($data->id,array("/translate/backend/messageSource/update", "id" => $data->id))',
            'type' => 'raw'
        ),
		'category',
		'message',
        array(
            'name' => 'mt',
            'type' => 'raw',
            'value' => '$data->getTranslationsString()',
            'filter' => false,

        ),
        array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Translate.Backend.Translate.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Translate.Backend.Translate.Update')",
				)
			),
		),
	),
)); ?>
