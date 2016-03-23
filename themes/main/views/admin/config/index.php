<?php
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Configs'),
);
?>

<h1><?=Yii::t("adminModule","Manage Configs");?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', "Create new param"),
		'create',
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>

<?php $this->widget(
	'booster.widgets.TbGridView',
	array(
		'id'=>'config-grid',
		'dataProvider'=>$model->search(),
		'ajaxUpdate' => false,
		'filter'=>$model,
		'columns'=>array(
			'id',
			'param',
			'value',
			'default',
			'label',
			//'type',
			array(
				'header' => Yii::t('ses', 'Edit'),
				'class'  => 'bootstrap.widgets.TbButtonColumn',
				'htmlOptions' => array('class' => 'col-lg-3 button-column'),
				'template'=> Yii::app()->user->checkAccess('Admin.Config.Delete') ? '{update} {delete}' : '{update}',
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
