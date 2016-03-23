<?php

/**
 * @var $model MessageSource
 * @var $messageModel Message
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('translateModule','Message sources')=>array('index'),
	$model->id=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('translateModule','Update message source');?></small> <?php echo $model->message; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'messageModel' => $messageModel)); ?>