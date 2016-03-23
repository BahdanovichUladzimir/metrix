<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>10)))); ?>

		<?php echo $form->textFieldGroup($model,'link',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

		<?php echo $form->textFieldGroup($model,'link_type',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>50)))); ?>

		<?php echo $form->textFieldGroup($model,'deal_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
