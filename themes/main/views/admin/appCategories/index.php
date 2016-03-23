<?php

/**
 * @var $model AppCategories
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Application categories')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('adminModule','Manage Application categories');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule','Create new application category'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'app-categories-grid',
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
            'value' => 'CHtml::link($data->name,$data->getAdminUrl())'
        ),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{update} {delete}',
		'buttons'=>array(
			'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => "Yii::app()->user->checkAccess('Admin.AppCategories.Delete')",
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-success update'),
                'visible' => "Yii::app()->user->checkAccess('Admin.AppCategories.Update')",
            ),
			),
		),
	),
)); ?>
