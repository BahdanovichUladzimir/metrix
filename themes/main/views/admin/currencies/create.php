<?php

/**
 * @var $model Currencies
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Currencies')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('adminModule', 'Create Currencies');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>