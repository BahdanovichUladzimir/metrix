<?php

/**
 * @var $model Banners
 */
$this->breadcrumbs=array(
	Yii::t('bannersModule','My banners')=>array(User::model()->findByPk(Yii::app()->user->getId())->getPrivateUrl()."#banners"),
	Yii::t('core', 'Create'),
);

?>

<h1 class="title section-title"><?=Yii::t('bannersModule','Create banner');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>