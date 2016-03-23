<?php
/**
 * @var $model MessageSource
 * @var $messageModel Message
 * @var $form TbActiveForm
*/
;?>
<?php if( Yii::app()->user->hasFlash('messageSourceSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('messageSourceSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('messageSourceError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('messageSourceError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'message-source-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'category',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>32)))); ?>

	<?php echo $form->textAreaGroup($model,'message', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

    <?php foreach(Yii::app()->getModule('translate')->languages as $langKey=>$langName):?>
        <?php echo $form->textFieldGroup(
            $messageModel,
            'translations['.$langKey.']',
            array(
                'label' => $langName,
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'value' => $model->getTranslationByLang($langKey),
                        'placeholder' => Yii::t('translateModule', 'Enter translation')
                    ),
                ),
            )
        ); ?>
    <?php endforeach;?>

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




