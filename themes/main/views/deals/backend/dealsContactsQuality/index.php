<?php

/**
 * @var $dataProvider CActiveDataProvider
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Deals contacts quality')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('dealsModule','Manage deals contacts quality');?></h1>

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'deals-contacts-quality-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
        ),
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->name,$data->getPublicUrl())',
        ),
        array(
            'header' => Deals::getDealsContactsQualities()[1],
            'type' => 'raw',
            'value' => '$data->getContactsQualities()[1]',
        ),
        array(
            'header' => Deals::getDealsContactsQualities()[2],
            'type' => 'raw',
            'value' => '$data->getContactsQualities()[2]',
        ),
        array(
            'header' => Deals::getDealsContactsQualities()[3],
            'type' => 'raw',
            'value' => '$data->getContactsQualities()[3]',
        ),
        array(
            'header' => Deals::getDealsContactsQualities()[4],
            'type' => 'raw',
            'value' => '$data->getContactsQualities()[4]',
        ),
	),
)); ?>
