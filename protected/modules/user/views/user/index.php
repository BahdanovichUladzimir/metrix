<?php
$this->breadcrumbs=array(
	Yii::t('userModule',"Users"),
);
if(UserModule::isAdmin()) {
	//$this->layout='//layouts/column2';
	$this->menu=array(
	    array('label'=>Yii::t("user",'Manage Users'), 'url'=>array('/user/admin')),
	    array('label'=>Yii::t("user",'Manage Profile Field'), 'url'=>array('profileField/admin')),
	);
}
?>

<h1><?php echo Yii::t('userModule',"List User"); ?></h1>

<?php $this->widget('booster.widgets.TbExtendedGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("user/view","id"=>$data->id))',
		),
		'create_at',
		'lastvisit_at',
	),
)); ?>
