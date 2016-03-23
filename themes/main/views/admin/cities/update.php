<?php
/**
 * @var $model Cities
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Cities')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('adminModule','Update'),
);?>

	<h1><?=Yii::t('adminModule','Update city {city}',array('{city}'=> $model->name ));?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>