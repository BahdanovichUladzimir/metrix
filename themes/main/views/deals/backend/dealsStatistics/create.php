<?php

/**
 * @var $model DealsStatistics
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Statistics'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('DealsStatistics', 'Create DealsStatistics');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>