<?php
/**
 * @var $model Dictionary
 * @var $form TbActiveForm
*/
;?><?php if( Yii::app()->user->hasFlash('cmsBackendDictionarySuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('cmsBackendDictionarySuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('cmsBackendDictionaryError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('cmsBackendDictionaryError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'dictionary-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

<?php echo $form->textFieldGroup($model,'letter',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>1)))); ?>

<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'cmsPage',
    array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6 col-xs-6',
        ),
        'widgetOptions' => array(
            'data' => CHtml::listData(CmsPage::model()->findAll(array('order'=>'Name ASC')),'id','name'),
            'htmlOptions' => array(
                'multiple' => 'multiple',
                'style' => 'height:300px',
            ),
        )
    )
); ?>

<div class="form-actions">
	<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>
    <?php $this->widget('booster.widgets.TbButton', array(
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
