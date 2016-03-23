<?php

/**
 * @var $model SocialMediaPosting
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('cmsModule','Social media posts')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('cmsModule', 'Create social media post');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>