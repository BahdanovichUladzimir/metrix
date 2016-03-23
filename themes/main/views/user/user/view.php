<?php
$this->breadcrumbs=array(
	Yii::t('userModule','Users')=>array('index'),
	$model->username,
);
$this->layout='//layouts/column2';
$this->menu=array(
    array('label'=>Yii::t('userModule','List User'), 'url'=>array('index')),
);
?>
<h1><?php echo Yii::t('userModule','View User').' "'.$model->username.'"'; ?></h1>
<?php 

// For all users
	$attributes = array(
			'username',
	);
	
	$profileFields=ProfileField::model()->forAll()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => Yii::t('userModule',$field->title),
					'name' => $field->varname,
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),

				));
		}
	}
	array_push($attributes,
		'create_at',
		array(
			'name' => 'lastvisit_at',
			'value' => (($model->lastvisit_at!='0000-00-00 00:00:00')?$model->lastvisit_at:Yii::t('userModule','Not visited')),
		)
	);
			
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));

?>
