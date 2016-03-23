<?php

/**
 * @var $model Underground
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Underground')=>array('index'),
	$model->name=>$model->getAdminUrl(),
	Yii::t('adminModule','Update'),
);

	?>

	<h1><?=Yii::t('adminModule','Update underground {underground}', array("{underground}"=>$model->name));?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>