<?php

/**
 * @var $model Dictionary
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('cmsModule','Dictionary')=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	Yii::t('core','Update'),
);
	?>

	<h1><small><?=Yii::t('cmsModule','Update letter');?></small> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>