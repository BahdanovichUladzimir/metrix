<?php
$this->breadcrumbs=array(
	Yii::t('userModule','Users')=>array('admin'),
	Yii::t('userModule','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>Yii::t('userModule','List User'), 'url'=>array('/user')),
);
?>
<h1><?php echo Yii::t('userModule',"Create User"); ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>