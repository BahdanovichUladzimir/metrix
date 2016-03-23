<?php

/**
 * @var $model Banners
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Banners'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('Banners', 'Create Banners');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>