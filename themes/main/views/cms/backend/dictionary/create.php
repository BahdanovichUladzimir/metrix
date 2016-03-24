<?php

/**
 * @var $model Dictionary
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('cmsModule','Dictionary')=>array('index'),
	Yii::t('cmsModule', 'Create letter'),
);

?>

<h1><?=Yii::t('cmsModule', 'Create letter');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>