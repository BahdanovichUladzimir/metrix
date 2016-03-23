<?php

/**
 * @var $model UserMessages
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'User Messages'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('UserMessages', 'Create UserMessages');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>