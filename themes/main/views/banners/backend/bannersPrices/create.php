<?php

/**
 * @var $model BannersPrices
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('bannersModule','Banners prices')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('BannersPrices', 'Create banners price');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>