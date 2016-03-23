<?php

/**
 * @var $model Banners
 */
$this->breadcrumbs=array(
	Yii::t('bannersModule','My banners')=>array($model->user->getPrivateUrl()."#banners"),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1 class="title section-title"><?=Yii::t('bannersModule','Update banner');?> <strong><?php echo $model->name; ?></strong></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>