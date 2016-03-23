<?php

/**
 * @var $model Dialogues
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Dialogues'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('Dialogues', 'Create Dialogues');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>