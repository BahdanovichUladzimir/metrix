<?php
/**
 * @var $model Countries
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Countries')=>array('index'),
	Yii::t('adminModule','Create'),
);?>

<h1><?=Yii::t('adminModule','Create country');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>