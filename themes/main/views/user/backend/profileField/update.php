<?php
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('userModule','Profile Fields')=>array('/admin/users/profilefield'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('userModule','Update'),
);
/*$this->menu=array(
    array('label'=>Yii::t('userModule','Create Profile Field'), 'url'=>array('create')),
    array('label'=>Yii::t('userModule','View Profile Field'), 'url'=>array('view','id'=>$model->id)),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('/user/admin')),
);*/
?>

<h1><?php echo Yii::t('userModule','Update Profile Field ').$model->id; ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>