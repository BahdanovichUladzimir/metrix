<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>10)))); ?>

		<?php echo $form->textFieldGroup($model,'city_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>10)))); ?>

		<?php echo $form->textFieldGroup($model,'category_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>10)))); ?>

		<?php echo $form->textFieldGroup($model,'price',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
