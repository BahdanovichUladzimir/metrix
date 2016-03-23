<?php

/**
 * @var $model AppCategories
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Application categories')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('adminModule', 'Create application category');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>