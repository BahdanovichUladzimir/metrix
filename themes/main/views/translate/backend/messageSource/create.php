<?php

/**
 * @var $model MessageSource
 * @var $messageModel Message
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('translateModule','Message sources')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('translateModule', 'Create message source');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'messageModel' => $messageModel)); ?>