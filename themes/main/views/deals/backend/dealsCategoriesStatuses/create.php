<?php

/**
 * @var $model DealsCategoriesStatuses
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Categories Statuses'=>array('index'),
	'Create',
);

?>

<h1>Create DealsCategoriesStatuses</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>