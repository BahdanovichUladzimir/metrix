<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'config-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal'
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->textFieldGroup(
		$model,
		'param',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5',
					'maxlength'=>128
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

	<?php echo $form->textAreaGroup(
		$model,
		'value',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'rows'=>6,
					'cols'=>50,
					'class'=>'span8'
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

	<?php echo $form->textAreaGroup(
		$model,
		'default',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'rows'=>6,
					'cols'=>50,
					'class'=>'span8'
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'label',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5',
					'maxlength'=>255
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'type',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'span5',
					'maxlength'=>128
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

<div class="form-actions">
	<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>
	<?php $this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'buttonType' => 'reset',
			'context' => 'danger',
			'label' => Yii::t('core','Reset')
		)
	);?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType'=>'submit',
		'context'=>'success',
		'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
	)); ?>
</div>


<?php $this->endWidget(); ?>
