<?php

/**
 * @var $model DealsImages
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Images'=>array('index'),
	Yii::t('DealsImages', 'Create'),
);

?>

<h1><?=Yii::t('DealsImages', 'Create DealsImages');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>