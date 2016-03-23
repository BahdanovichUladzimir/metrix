<?php
/**
 * @var $model Countries
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Countries')=>array('index'),
	$model->name=>$model->getAdminUrl(),
	Yii::t('adminModule','Update'),
);?>

	<h1><?=Yii::t('adminModule','Update country {country}', array('{country}' => $model->name));?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>