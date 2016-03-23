<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); ?>

		<?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

		<?php echo $form->textFieldGroup($model,'parent_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); ?>

		<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

		<?php echo $form->textFieldGroup($model,'app_category_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>3)))); ?>

		<?php echo $form->textFieldGroup($model,'app_category_item_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); ?>

		<?php echo $form->textFieldGroup($model,'user_id',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

		<?php echo $form->textFieldGroup($model,'approve',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>1)))); ?>

		<?php echo $form->textFieldGroup($model,'created_date',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>40)))); ?>

		<?php echo $form->textFieldGroup($model,'published_date',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>40)))); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
