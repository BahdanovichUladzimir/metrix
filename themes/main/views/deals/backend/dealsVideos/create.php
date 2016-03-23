<?php

/**
 * @var $model DealsVideos
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Videoses'=>array('index'),
	Yii::t('DealsVideos', 'Create'),
);

?>

<h1><?=Yii::t('DealsVideos', 'Create DealsVideos');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>