<?php

/**
 * @var $model DealsParamsTypes
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Params Types'=>array('index'),
	'Create',
);

?>

<h1><?=Yii::t('dealsModule','Create new Type');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>