
<?php $form=$this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'type' => 'horizontal',
	)
); ?>
<?php echo $form->dropDownListGroup(
	$model,
	'itemname',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => $itemnameSelectOptions,
		)
	)
); ?>
<?php $this->widget('booster.widgets.TbButton',
	array(
		'buttonType' => 'submit',
		'context' => 'success',
		'label' => Rights::t('core', 'Add'))
);?>
<?php $this->endWidget(); ?>

