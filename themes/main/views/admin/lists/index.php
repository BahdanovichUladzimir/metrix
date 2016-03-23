<?php

/**
 * @var $model Lists
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Lists')=>array('index'),
	Yii::t('core','Manage'),
);
?>
<?php if( Yii::app()->user->hasFlash('adminModule.ListItems.Success')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminModule.ListItems.Success'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminModule.ListItems.Error')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminModule.ListItems.Error'); ?>
    </div>
<?php endif; ?>
<h1><?=Yii::t('adminModule','Manage lists');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new list'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'lists-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate' => false,
	'filter'=>$model,
    'template' => "{summary}{pager}{items}{pager}",
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1'
            )
        ),
		'name',
        array(
            'name' => 'type',
            'type' => 'raw',
            'header' => 'Type',
            'filter' => Lists::getListsTypes(),
        ),
		array(
            'name' => 'listItems',
            'type' => 'raw',
            'header' => 'List items',
            'value' => 'implode(", ",CHtml::listData(ListItems::model()->findAll("list_id=:list_id",array("list_id" => $data->id)), "id", "name"))',
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
                'visible' => "Yii::app()->user->checkAccess('Admin.Lists.Delete')",
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-success update'),
                'visible' => "Yii::app()->user->checkAccess('Admin.Lists.Update')"
            )
			),
		),
	),
)); ?>
