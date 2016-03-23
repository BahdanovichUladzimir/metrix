<?php
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    (Yii::t('userModule','Users'))=>array('/admin/users'),
	$model->username=>array('view','id'=>$model->id),
	(Yii::t('userModule','Update')),
);
/*$this->menu=array(
    array('label'=>Yii::t('userModule','Create User'), 'url'=>array('create')),
    array('label'=>Yii::t('userModule','View User'), 'url'=>array('view','id'=>$model->id)),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>Yii::t('userModule','List User'), 'url'=>array('/user')),
);*/
?>

<h1><?php echo  Yii::t('userModule','Update User')." ".$model->username; ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>