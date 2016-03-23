<?php
/**
 * @var $form TbActiveForm
 * @var $model User
 * @var $profile Profile
 */

$this->breadcrumbs=array(
    Yii::t('userModule', "Profile") => array('/user/profile'),
	Yii::t('userModule',"Edit"),
);?>
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
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
        'id'=>'profile-form',
        'enableAjaxValidation'=>true,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype'=>'multipart/form-data'
        )
    )); ?>
    <div class="panel settings-form">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <?php echo $form->labelEx($profile,'email',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->textField($profile,'email',array('maxlength'=>255)); ?>
                        <?php echo $form->error($profile,'email', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($profile,'phone',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->textField($profile,'phone',array('maxlength'=>50)); ?>
                        <?php echo $form->error($profile,'phone', array('class'=> 'text-danger')); ?>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="right-block">
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="skype"></span>
                            </span>
                            <?php echo $form->textField($profile,'skype',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'skype', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="vimeo"></span>
                            </span>
                            <?php echo $form->textField($profile,'vimeo',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'vimeo', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="youtube"></span>
                            </span>
                            <?php echo $form->textField($profile,'youtube',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'youtube', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="ok"></span>
                            </span>
                            <?php echo $form->textField($profile,'ok',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'ok', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="vk"></span>
                            </span>
                            <?php echo $form->textField($profile,'vk',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'vk', array('class'=> 'text-danger')); ?>
                        </div>
                        <!--<div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="instagram"></span>
                            </span>
                            <input type="text" class="form-control">
                        </div>-->
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="twitter"></span>
                            </span>
                            <?php echo $form->textField($profile,'twitter',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'twitter', array('class'=> 'text-danger')); ?>

                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="facebook"></span>
                            </span>
                            <?php echo $form->textField($profile,'facebook',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'facebook', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="linkedin"></span>
                            </span>
                            <?php echo $form->textField($profile,'linkedin',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'linkedin', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon socials">
                                <span class="instagram"></span>
                            </span>
                            <?php echo $form->textField($profile,'instagram',array('maxlength'=>255)); ?>
                            <?php echo $form->error($profile,'instagram', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="buttons pull-right">
                            <?php echo CHtml::submitButton($profile->isNewRecord ? Yii::t('userModule','Create') : Yii::t('userModule','Save'), array('class' => 'btn btn-success')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</section>

