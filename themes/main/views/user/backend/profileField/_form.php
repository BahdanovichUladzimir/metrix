<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	"type" => "horizontal",
	'enableAjaxValidation'=>true,
	'errorMessageCssClass' => 'text-danger small',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'successCssClass'=> 'has-success',
		'errorCssClass'=> 'has-error',
	),
	'htmlOptions' => array(
		'enctype'=>'multipart/form-data',
		//'class' => 'well form'
	),
)); ?>
<p class="help-block"><?php echo Yii::t('userModule','Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->textFieldGroup(
	$model,
	'varname',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array('size'=>60,'maxlength'=>50,'readonly' => $model->id),
		),
		'hint' => Yii::t('userModule',"Allowed lowercase letters and digits.")
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'title',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array('size'=>60,'maxlength'=>255,'readonly' => $model->id),
		),
		'hint' => Yii::t('userModule','Field name on the language of "sourceLanguage".')
	)
); ?>
<?php if($model->id):?>
	<?php echo $form->textFieldGroup(
		$model,
		'field_type',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'htmlOptions' => array('size'=>60,'maxlength'=>50,'readonly'=>true,'id'=>'field_type'),
			),
			'hint' => Yii::t('userModule','Field type column in the database.')
		)
	); ?>
<?php else:?>
	<?php echo $form->dropDownListGroup(
		$model,
		'field_type',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'data' => ProfileField::itemAlias('field_type'),
				'htmlOptions' => array('id'=>'field_type'),
			),
			'hint' => Yii::t('userModule','Field type column in the database.')
		)
	); ?>
<?php endif;?>
<?php echo $form->textFieldGroup(
	$model,
	'field_size',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array('readonly'=>$model->id,'id'=>'field_type'),
		),
		'hint' => Yii::t('userModule','Field size column in the database.')
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'field_size_min',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'hint' => Yii::t('userModule','The minimum value of the field (form validator).')
	)
); ?>
<?php echo $form->dropDownListGroup(
	$model,
	'required',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => ProfileField::itemAlias('required'),
		),
		'hint' => Yii::t('userModule','Required field (form validator).')
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'match',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'size'=>60,
				'maxlength'=>255
			),
		),
		'hint' => Yii::t('userModule',"Regular expression (example: '/^[A-Za-z0-9\s,]+$/u').")
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'range',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'size'=>60,
				'maxlength'=>5000
			),
		),
		'hint' => Yii::t('userModule','Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).')
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'error_message',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'size'=>60,
				'maxlength'=>255
			),
		),
		'hint' => Yii::t('userModule','Error message when you validate the form.')
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'other_validator',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'size'=>60,
				'maxlength'=>255
			),
		),
		'hint' => Yii::t('userModule','JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('file'=>array('types'=>'jpg, gif, png')))))
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'default',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'size'=>60,
				'maxlength'=>255,
				'readonly' => $model->id
			),
		),
		'hint' => Yii::t('userModule','The value of the default field (database).')
	)
); ?>
<?php list($widgetsList) = ProfileFieldController::getWidgets($model->field_type);?>
<?php echo $form->dropDownListGroup(
	$model,
	'widget',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => $widgetsList,
			'htmlOptions' => array(
				'id'=>'widgetlist'
			),
		),
		'hint' => Yii::t('userModule','Widget name.')
	)
); ?>
<div class="widgetparams">
	<?php echo $form->textFieldGroup(
		$model,
		'widgetparams',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'htmlOptions' => array(
					'size'=>60,
					'maxlength'=>5000,
					'id'=>'widgetparams'
				),
			),
			'hint' => Yii::t('userModule','JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('param1'=>array('val1','val2'),'param2'=>array('k1'=>'v1','k2'=>'v2')))))
		)
	); ?>
</div>
<?php echo $form->textFieldGroup(
	$model,
	'position',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'hint' => Yii::t('userModule','Display order of fields.')
	)
); ?>
<?php echo $form->dropDownListGroup(
	$model,
	'visible',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => ProfileField::itemAlias('visible'),
		),
	)
); ?>
<?php $this->widget('booster.widgets.TbButton',
	array(
		'buttonType' => 'submit',
		'context' => 'success',
		'label' => $model->isNewRecord ? Yii::t('userModule','Create') : Yii::t('userModule','Save')
	)
);?>
<?php $this->endWidget();?>
<?php unset($form);?>

<div id="dialog-form" title="<?php echo Yii::t('userModule','Widget parametrs'); ?>">
	<form>
	<fieldset>
		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
		<label for="value">Value</label>
		<input type="text" name="value" id="value" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
