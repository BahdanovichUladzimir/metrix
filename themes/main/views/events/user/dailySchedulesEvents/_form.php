<?php
/**
 * @var $model DailySchedulesEvents
 * @var $form TbActiveForm
*/
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'daily-schedules-events-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

	<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

	<?php echo $form->textFieldGroup($model,'start',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

	<?php echo $form->textFieldGroup($model,'end',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

	<?php echo $form->textFieldGroup($model,'schedule_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

<div class="form-actions">
	<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'reset',
			'context'=>'danger',
			'label'=>Yii::t('core','Reset'),
		)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
