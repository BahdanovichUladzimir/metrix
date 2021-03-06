<?php
/**
 * @var $model Payments
 * @var $form TbActiveForm
*/
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'payments-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'type_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>3)))); ?>

	<?php echo $form->textFieldGroup($model,'app_category_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>3)))); ?>

	<?php echo $form->textFieldGroup($model,'app_item_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); ?>

	<?php echo $form->textFieldGroup($model,'user_id',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

	<?php echo $form->textFieldGroup($model,'time',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); ?>

	<?php echo $form->textFieldGroup($model,'amount',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

	<?php echo $form->textFieldGroup($model,'real_amount',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

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
