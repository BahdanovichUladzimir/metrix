<?php
$this->breadcrumbs=array(
	Yii::t('userModule','Users')=>array('admin'),
	$model->username,
);


$this->menu=array(
    array('label'=>Yii::t('userModule','Create User'), 'url'=>array('create')),
    array('label'=>Yii::t('userModule','Update User'), 'url'=>array('update','id'=>$model->id)),
    array('label'=>Yii::t('userModule','Delete User'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('userModule','Are you sure to delete this item?'))),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>Yii::t('userModule','List User'), 'url'=>array('/user')),
);
?>
<h1><?php echo Yii::t('userModule','View User').' "'.$model->username.'"'; ?></h1>

<?php
 
	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => Yii::t('userModule',$field->title),
					'name' => $field->varname,
					'type'=>'raw',
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
				));
		}
	}
	
	array_push($attributes,
		'password',
		'email',
		'activkey',
		'create_at',
		'lastvisit_at',
		array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>
