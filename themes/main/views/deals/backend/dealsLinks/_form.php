<?php
/**
 * @var $model DealsImages
 * @var $form TbActiveForm
*/
;?><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'deals-images-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'file_name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'ext',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>5)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'path',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'dir_path',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'dir_url',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'url',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'width',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'height',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'deal_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>11)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'approve',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

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
