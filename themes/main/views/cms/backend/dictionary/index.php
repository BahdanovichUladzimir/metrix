<?php

/**
 * @var $model Dictionary
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('cmsModule','Dictionary')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('Dictionary','Manage dictionary');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new letter'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'dictionary-grid',
	'dataProvider'=>$model->search(),
    'ajaxUpdate' => false,
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
            'value' => 'CHtml::link($data->name,Yii::app()->createUrl("/cms/backend/dictionary/update", array("id" => $data->id)))'
        ),
        'letter',
		'description',
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => "Yii::app()->user->checkAccess('Cms.Backend.Dictionary.Delete')",
				),
				'update' => array(
					'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Cms.Backend.Dictionary.Update')",
				),
				'view' => array(
					'options' => array('class' => 'btn btn-info view')
				),
			),
		),
	),
)); ?>
