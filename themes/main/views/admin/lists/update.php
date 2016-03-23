<?php

/**
 * @var $model Lists
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Lists')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('Lists','Update list');?></small> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>