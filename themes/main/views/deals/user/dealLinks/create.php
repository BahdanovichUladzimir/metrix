<?php

/**
 * @var $model DealLinks
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deal Links'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('DealLinks', 'Create DealLinks');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>