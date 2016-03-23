<?php
/**
 * @var $model Config
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t("adminModule",'Configs')=>array('index'),
	$model->label=>array('update','id'=>$model->id),
	Yii::t("adminModule",'Update'),
);?>

	<h1><?=Yii::t("adminModule","Update config param");?> <?php echo $model->label; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>