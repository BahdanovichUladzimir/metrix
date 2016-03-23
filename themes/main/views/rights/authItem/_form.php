
<?php if( $model->scenario==='update' ): ?>
	<h3 class="text-warning"><?php echo Rights::getAuthItemTypeName($model->type); ?></h3>
<?php endif; ?>
	
<?php $form=$this->beginWidget(
	'booster.widgets.TbActiveForm',
	array(
		'type' => 'horizontal',
	)
); ?>
	<?php echo $form->textFieldGroup(
		$model,
		'name',
		array(
			'maxlength'=>255,
			'class'=> 'text-field',
			'hint' => Rights::t('core', 'Do not change the name unless you know what you are doing.'),
			'wrapperHtmlOptions' =>
				array(
					'class' => 'col-sm-6 col-xs-6',
				),
		)
	); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'description',
		array(
			'maxlength'=>255,
			'class'=>'text-field',
			'hint' => Rights::t('core', 'A descriptive name for this item.'),
			'wrapperHtmlOptions' =>
				array(
					'class' => 'col-sm-6 col-xs-6',
				),

		)
	); ?>
	<?php if( Rights::module()->enableBizRule===true ): ?>
		<?php echo $form->textFieldGroup(
			$model,
			'bizRule',
			array(
				'maxlength'=>255,
				'class'=>'text-field',
				'hint' => Rights::t('core', 'Code that will be executed when performing access checking.'),
				'wrapperHtmlOptions' =>
					array(
						'class' => 'col-sm-6 col-xs-6',
					),

			)
		); ?>
	<?php endif; ?>
	<?php if( Rights::module()->enableBizRule===true && Rights::module()->enableBizRuleData ): ?>
		<?php echo $form->textFieldGroup(
			$model,
			'data',
			array(
				'maxlength'=>255,
				'class'=>'text-field',
				'hint' => Rights::t('core', 'Additional data available when executing the business rule.'),
				'wrapperHtmlOptions' =>
					array(
						'class' => 'col-sm-6 col-xs-6',
					),

			)
		); ?>
	<?php endif; ?>
	<?php $this->widget('booster.widgets.TbButton',
		array(
			'buttonType' => 'submit',
			'context' => 'success',
			'label' => Rights::t('core', 'Save')
		)
	);?>
	|
	<?php echo CHtml::link(Rights::t('core', 'Cancel'), Yii::app()->user->rightsReturnUrl); ?>


<?php $this->endWidget(); ?>

