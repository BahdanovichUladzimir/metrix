<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var int $widgetId
 * @var $model UserLogin
 * @var $form TbActiveForm
 */
;?>
<div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="login-pop-up" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                <span class="title h3"><?=Yii::t('userModule',"Login");?></span>
            </div>
            <div class="modal-body">
                <?php $form = $this->beginWidget(
                    'booster.widgets.TbActiveForm',
                    array(
                        'id' => 'modal_login_form',
                        //'enableAjaxValidation'=>true,
                        'enableClientValidation'=>true,
                        //'type' => 'horizontal',
                        //'htmlOptions' => array('class' => 'well'), // for inset effect
                        'clientOptions'=>array(
                            'successCssClass'=> 'has-success',
                            'errorCssClass'=> 'has-error',
                            //'validateOnSubmit'=>true,
                            //'validationUrl'=>Yii::app()->createUrl('/user/login/validate'),
                        ),
                        'errorMessageCssClass' => 'text-danger small',
                        'action' => Yii::app()->createUrl('/user/login')
                    )
                );?>
                <?php echo $form->textField(
                    $model,
                    'username'
                ); ?>
                <?php echo $form->passwordField(
                    $model,
                    'password'
                ); ?>
                <div class="login-options form-group">
                    <div>
                        <label class="checkbox">
                            <?php echo $form->checkbox(
                                $model,
                                'rememberMe'
                            ); ?>
                            <span class="a-spr"></span>
                            <?=Yii::t('core', "Remember me");?>
                        </label>
                    </div>
                    <div>
                        <?=CHtml::link(Yii::t('userModule',"Lost Password?"),Yii::app()->getModule('user')->recoveryUrl);?>
                    </div>
                </div>

                <?=CHtml::button(
                    Yii::t('userModule',"Login"),
                    array(
                        "type" => "submit",
                        "class" => 'btn btn-primary'
                    )
                );?>
                <?php $this->endWidget();?>
                <?php unset($form);?>

            </div>
            <div class="modal-footer">
                <?php $this->widget('application.modules.user.widgets.vkAuth.VkAuthWidget', array(
                    'appId' => Yii::app()->params['vk']['appId'],
                    'view' => 'link',
                    'redirectUri' => Yii::app()->createAbsoluteUrl('/user/login/VkAuthRedirect')
                )); ?>
                <br/>
                <?=CHtml::link(Yii::t('userModule',"Register"),Yii::app()->getModule('user')->registrationUrl);?>
            </div>
        </div>
    </div>
</div>