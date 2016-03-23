<?php $this->pageTitle=Yii::app()->name . ' - '.Yii::t('userModule', "Change password");
$this->breadcrumbs=array(
    Yii::t('userModule', "Profile") => array('/user/profile'),
    Yii::t('userModule', "Change password"),
);
?>
<section>
    <h1 class="title section-title h1"><?=Yii::t('userModule','Account settings');?></h1>
    <?php if( Yii::app()->user->hasFlash('profileMessage')):?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
        </div>
    <?php endif; ?>

    <?php if( Yii::app()->user->hasFlash('profileMessageError')):?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('profileMessageError'); ?>
        </div>
    <?php endif; ?>
    <?php $this->renderPartial('partials/_settings_menu');?>
    <div class="panel settings-form">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
                        'id'=>'changepassword-form',
                        'enableAjaxValidation'=>true,
                        'type' => 'horizontal',
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                    )); ?>

                    <p class="note"><?php echo Yii::t('userModule', 'Fields with <span class="required">*</span> are required.'); ?></p>
                    <?php echo $form->errorSummary($model); ?>

                    <div class="input-group">
                        <?php echo $form->labelEx($model,'oldPassword',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->passwordField($model,'oldPassword'); ?>
                        <?php echo $form->error($model,'oldPassword'); ?>
                    </div>

                    <div class="input-group">
                        <?php echo $form->labelEx($model,'password',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->passwordField($model,'password'); ?>
                        <?php echo $form->error($model,'password'); ?>
                        <p class="hint">
                            <?php echo Yii::t('userModule', "Minimal password length 4 symbols."); ?>
                        </p>
                    </div>

                    <div class="input-group">
                        <?php echo $form->labelEx($model,'verifyPassword',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->passwordField($model,'verifyPassword'); ?>
                        <?php echo $form->error($model,'verifyPassword'); ?>
                    </div>

                    <div class="buttons pull-right">
                        <?php echo CHtml::submitButton(Yii::t('userModule', 'Save'), array('class' => 'btn btn-success')); ?>
                    </div>
                    <?php $this->endWidget(); ?>

                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
    </div>
</section>