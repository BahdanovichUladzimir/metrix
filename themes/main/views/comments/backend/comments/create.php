<?php

/**
 * @var $model Comments
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('commentsModule','Comments')=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('Comments', 'Create comment');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>