<?php
/**
 * @var $model Currencies
 * @var $form TbActiveForm
*/
;?>
<?php if( Yii::app()->user->hasFlash('adminCurrenciesSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminCurrenciesSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminCurrenciesError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminCurrenciesError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'currencies-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5','maxlength'=>50)),'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'key',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5','maxlength'=>10)),'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',),)); ?>

	<?php echo $form->textFieldGroup($model,'rate',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5')),'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',),)); ?>

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
