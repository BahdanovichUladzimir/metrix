<?php
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('userModule','Profile Fields')=>array('/admin/users/profilefield'),
	Yii::t('userModule','Create'),
);
$this->menu=array(
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('/user/admin')),
);
?>
<h1><?php echo Yii::t('userModule','Create Profile Field'); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>