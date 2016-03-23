<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.10.2015
 */
;?>
<?php
/**
 * @var $model AdminMessageForm
 * @var $form TbActiveForm
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('messagesModule','Admin messages')=>array('index'),
    Yii::t('core', 'Create'),
);

?>

<h1><?=Yii::t('messagesModule', 'Create message');?></h1>

<?php if( Yii::app()->user->hasFlash('messagesBackendAdminMessagesSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('messagesBackendAdminMessagesSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('messagesBackendAdminMessagesError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('messagesBackendAdminMessagesError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>'admin-message-form',
    'enableAjaxValidation'=>true,
    'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

<?php echo $form->textFieldGroup($model,'subject',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>300)))); ?>
<?php echo $form->textAreaGroup($model,'message',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>1000)))); ?>

<?php echo $form->dropDownListGroup($model,'group', array('widgetOptions'=>array('data'=>AdminMessageForm::$groups, 'htmlOptions'=>array('class'=>'input-large')))); ?>

<?php echo $form->checkboxGroup($model,'sendToEmail',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>12)))); ?>
<?php echo $form->checkboxGroup($model,'sendToCabinet',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>12)))); ?>

<div class="form-actions">
    <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>	<?php $this->widget('booster.widgets.TbButton', array(
        'buttonType'=>'reset',
        'context'=>'danger',
        'label'=>Yii::t('core','Reset'),
    )); ?>
    <?php $this->widget('booster.widgets.TbButton', array(
        'buttonType'=>'submit',
        'context'=>'success',
        'label'=>Yii::t('core','Send'),
    )); ?>
</div>

<?php $this->endWidget(); ?>
