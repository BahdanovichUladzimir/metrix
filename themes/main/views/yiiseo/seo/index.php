<?php
$this->breadcrumbs=array(
    Yii::t('yiiseoModule','Yiiseo urls')=>array('index'),
    Yii::t('core','Manage'),
);?>

<h1><?=Yii::t('yiiseoModule','Manage yiiseo urls');?></h1>
<p>
    <?php echo CHtml::link(
        Yii::t('yiiseoModule', "Create yiiseo url"),
        array('create'),
        array(
            'class'=>'btn btn-success',
        )
    );?>
</p>
<?php $this->widget('booster.widgets.TbExtendedGridView', array(
	'id'=>'yiiseo-url-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'url',
		'language',
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
)); ?>
