<?php

/**
 * @var $model Payments
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Payments'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('Payments', 'Create Payments');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>