<?php

/**
 * @var $model Underground
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Underground')=>array('index'),
	Yii::t('adminModule','Create'),
);

?>

<h1><?=Yii::t('adminModule','Create underground');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>