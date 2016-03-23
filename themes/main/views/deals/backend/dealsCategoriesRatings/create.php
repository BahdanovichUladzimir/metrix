<?php

/**
 * @var $model DealsCategoriesRatings
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Deals Categories Ratings'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('DealsCategoriesRatings', 'Create DealsCategoriesRatings');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>