<?php

/**
 * @var $model Ratings
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('dealsModule', 'Ratings')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('dealsModule', 'Create rating');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>