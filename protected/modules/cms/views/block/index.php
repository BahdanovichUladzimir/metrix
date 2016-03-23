<?php

$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Block'),
);
?>
<h1><?php echo "Блоки"; ?></h1>
<p>
    <?php echo CHtml::link(
        Yii::t('cmsModule', 'Create new Page'),
        Yii::app()->createUrl('cms/block/create'),
        array(
            'class'=>'btn btn-success',
        )
    );?></p>
<?php
$this->widget('booster.widgets.TbExtendedGridView', array(
    'id'=>'block-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'sortableRows'=>true,
    'template' => '{pager}{items}{pager}',
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode(ucfirst($data->name)),array("update","id"=>$data->id))',
        ),
        array(
            'name' => 'published',
            'value' => 'Yii::app()->format->formatBoolean($data->published)',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{update}<br>{delete}',
            'buttons' => array
                (
                'update' => array
                    (
                    'options' => array('class' => 'btn btn-default'),
                ),
                'delete' => array
                    (
                    'options' => array('class' => 'del btn btn-default'),
                ),
            ),
        ),
    ),
))
?>
