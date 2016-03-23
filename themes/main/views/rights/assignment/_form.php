<div class="row">
	<div class="col-xs-6 col-sm-6">
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm'); ?>
			<?php echo $form->dropDownListGroup(
				$model,
				'itemname',
				array(
					'wrapperHtmlOptions' => array(
						'class' => 'col-sm-5 col-xs-5',
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
					'label' => Rights::t('core', 'Assign'))
			);?>
		<?php $this->endWidget(); ?>

	</div>
</div>

