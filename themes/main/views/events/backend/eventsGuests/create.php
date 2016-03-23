<?php

/**
 * @var $model EventsGuests
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	'Events Guests'=>array('index'),
	Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('EventsGuests', 'Create EventsGuests');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>