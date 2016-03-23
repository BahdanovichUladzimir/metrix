<?php

$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Page'),
);
?>
<h1><?php echo 'Страницы'; ?></h1>
<p>
    <?php echo CHtml::link(
        Yii::t('cmsModule', 'Create new Page'),
        Yii::app()->createUrl('cms/page/create'),
        array(
            'class'=>'btn btn-success',
        )
    );?></p>


<?php
$this->widget('booster.widgets.TbExtendedGridView', array(
    'id'=>'page-grid',
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
            'name' => 'parentId',
            'value' => '$data->parent !== null ? $data->parent->name : \'\'',
        ),
        array(
            'name' => 'published',
            'value' => 'Yii::app()->format->formatBoolean($data->published)',
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{view}<br>{update}<br>{delete}',
            'buttons' => array
                (
                'view' => array(
                    'options' => array('class' => 'btn btn-default'),
                    'url'=>'Yii::app()->createUrl("cms/page/view", array("id"=>$data->id))',
                ),
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
