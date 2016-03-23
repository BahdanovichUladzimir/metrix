<?php

/**
 * @var $model Lists
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Lists')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('adminModule', 'Create list');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>