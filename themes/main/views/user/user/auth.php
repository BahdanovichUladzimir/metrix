<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 08.09.2015
 * @var UserLogin $loginModel
 * @var RegistrationForm $registrationModel
 * @var TbActiveForm $form
 */
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('userModule',"Authorization");
;?>
<?php if( Yii::app()->user->hasFlash('userVkAuthenticate')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('userVkAuthenticate'); ?>
    </div>
<?php endif; ?>
<div class="panel reg-wrap">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="enter">
                    <span class="title"><?=Yii::t('userModule','Login');?></span>
                    <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
                        <div class="success">
                            <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                        </div>
                    <?php endif; ?>
                    <?php $form = $this->beginWidget(
                        'booster.widgets.TbActiveForm',
                        array(
                            'id' => 'login_form',
                            //'action' => array('/user/login'),
                            //'enableAjaxValidation'=>true,
                            'enableClientValidation'=>true,
                            //'type' => 'horizontal',
                            'clientOptions'=>array(
                                'successCssClass'=> 'has-success',
                                'errorCssClass'=> 'has-error',
                                //'validateOnSubmit'=>true,
                                //'validationUrl'=>Yii::app()->createUrl('/user/login/validate'),
                            ),
                            'errorMessageCssClass' => 'text-danger note',
                        )
                    );?>
                    <?php echo $form->textFieldGroup(
                        $loginModel,
                        'username',
                        array(
                            'label' => false,
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => Yii::t('userModule','Username or E-mail')
                                )
                            )
                        )
                    ); ?>
                    <?php echo $form->passwordFieldGroup(
                        $loginModel,
                        'password',
                        array(
                            'label' => false,
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => Yii::t('userModule','Password')
                                )
                            )

                        )
                    ); ?>
                    <div class="login-options form-group">
                        <div class="checkbox">
                            <input type="hidden" name="UserLogin[rememberMe]" value="0" id="ytUserLogin_rememberMe">
                            <label class="checkbox">
                                <input type="checkbox" value="1" id="UserLogin_rememberMe" name="UserLogin[rememberMe]">
                                <span class="a-spr"></span>
                                <?=Yii::t('userModule',"Remember me next time");?>
                            </label>
                        </div>
                        <div style="display:none" id="UserLogin_rememberMe_em_" class="text-danger small"></div>
                        <div>
                            <?=CHtml::link(Yii::t('userModule',"Lost Password?"),Yii::app()->getModule('user')->recoveryUrl);?>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-big  btn-primary" value="<?=Yii::t('userModule',"Login");?>"/>
                    <?php $this->endWidget();?>
                    <?php unset($form);?>
                    <?php $this->widget('application.modules.user.widgets.vkAuth.VkAuthWidget', array(
                        'appId' => Yii::app()->params['vk']['appId'],
                        'view' => 'link',
                        'redirectUri' => Yii::app()->createAbsoluteUrl('/user/login/VkAuthRedirect')
                    )); ?>
                    <?php $this->widget('application.modules.user.widgets.fbAuth.FbAuthWidget', array(
                        'appId' => Yii::app()->params['fb']['appId'],
                        'view' => 'link',
                        'fields' => 'last_name,first_name,email,id,picture,name,link',
                        'authUrl' => Yii::app()->createUrl('/user/login/fbAuthenticate'),
                        'redirectUrl' => Yii::app()->createUrl('/user/profile/editMainSettings')
                    )); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="register">
                    <span class="title"><?=Yii::t('userModule','Create account');?></span>
                    <?php if(Yii::app()->user->hasFlash('registration')): ?>
                        <div class="success">
                            <?php echo Yii::app()->user->getFlash('registration'); ?>
                        </div>
                    <?php else: ?>
                        <?php $form=$this->beginWidget('UActiveForm', array(
                            //'action' => array('/user/registration'),
                            'id'=>'registration-form',
                            'enableAjaxValidation'=>true,
                            'errorMessageCssClass' => 'text-danger small',
                            'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                            'clientOptions'=>array(
                                'validateOnSubmit'=>true,
                                'successCssClass'=> 'has-success',
                                'errorCssClass'=> 'has-error',
                            ),
                            'htmlOptions' => array(
                                'enctype'=>'multipart/form-data',
                            ),
                        )); ?>
                        <div class="form-group<?=(sizeof($registrationModel->getErrors('username'))>0) ? ' has-error' : '';?>">
                            <?php echo $form->textField($registrationModel,'username',array('class' => 'form-control', 'placeholder' => Yii::t('core','Enter').' '.$registrationModel->getAttributeLabel("username"))); ?>
                            <?php echo $form->error($registrationModel,'username', array('class' => 'note text-danger')); ?>
                            <span class="note"><?php echo Yii::t('userModule',"Username must be composed of numbers (0-9) and letters of the Latin alphabet (A-z)."); ?></span>
                        </div>
                        <div class="form-group<?=(sizeof($registrationModel->getErrors('password'))>0) ? ' has-error' : '';?>">
                            <?php echo $form->passwordField($registrationModel,'password',array('class' => 'form-control', 'placeholder' => Yii::t('core','Enter').' '.$registrationModel->getAttributeLabel("password"))); ?>
                            <?php echo $form->error($registrationModel,'password', array('class' => 'note text-danger')); ?>
                            <span class="note"><?php echo Yii::t('userModule',"Minimal password length 4 symbols."); ?></span>
                        </div>

                        <div class="form-group<?=(sizeof($registrationModel->getErrors('verifyPassword'))>0) ? ' has-error' : '';?>">
                            <?php echo $form->passwordField($registrationModel,'verifyPassword',array('class' => 'form-control', 'placeholder' => $registrationModel->getAttributeLabel("verifyPassword"))); ?>
                            <?php echo $form->error($registrationModel,'verifyPassword', array('class' => 'note text-danger')); ?>
                        </div>

                        <div class="form-group<?=(sizeof($registrationModel->getErrors('email'))>0) ? ' has-error' : '';?>">
                            <?php echo $form->textField($registrationModel,'email', array('class' => 'form-control', 'placeholder' => Yii::t('core','Enter').' '.$registrationModel->getAttributeLabel("email"))); ?>
                            <?php echo $form->error($registrationModel,'email', array('class' => 'note text-danger')); ?>
                        </div>

                        <div class="form-group<?=(sizeof($registrationModel->getErrors('invitecode'))>0) ? ' has-error' : '';?>">
                            <?php echo $form->textField($registrationModel,'invitecode', array('class' => 'form-control', 'placeholder' => Yii::t('core','Enter').' '.$registrationModel->getAttributeLabel("invitecode"))); ?>
                            <?php echo $form->error($registrationModel,'invitecode', array('class' => 'note text-danger')); ?>
                            <span class="note">
                                <?php echo Yii::t('userModule',"If you have an invitation code, please enter it in this field. This will be useful for the person who invited you."); ?>
                            </span>
                        </div>


                        <?php if (UserModule::doCaptcha('registration')): ?>
                            <div class="form-group">
                                <?php $this->widget('CCaptcha',array(
                                    'buttonType' => 'button',
                                    //'buttonLabel' => '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>',
                                    'buttonOptions' => array(
                                        'class' => 'btn btn-big btn-primary captcha-recover'
                                    ),
                                    'imageOptions' => array(
                                        'class' => 'img-rounded captcha-image'
                                    )
                                )); ?>
                            </div>

                            <div class="captcha-container form-group<?=(sizeof($registrationModel->getErrors('verifyCode'))>0) ? ' has-error' : '';?>">
                                <?php echo $form->textField($registrationModel,'verifyCode',array('class'=>'form-control', 'placeholder' => Yii::t('core','Enter').' '.$registrationModel->getAttributeLabel("verifyCode"))); ?>
                                <?php echo $form->error($registrationModel,'verifyCode', array('class' => 'note text-danger')); ?>
                                <span class="note">
                                    <?php echo Yii::t('userModule',"Please enter the letters as they are shown in the image above."); ?>
                                    <br/>
                                    <?php echo Yii::t('userModule',"Letters are not case-sensitive."); ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        <div class="registration-agreement form-group">
                            <div class="checkbox">
                                <input type="hidden" name="RegistrationForm[agreement]" value="0" id="ytRegistrationForm_agreement">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" checked="checked" id="RegistrationForm_agreement" name="RegistrationForm[agreement]">
                                    <span class="a-spr"></span>
                                    <?=Yii::t('userModule',"I agree with terms of use");?>
                                </label>
                            </div>
                            <div style="display:none" id="UserLogin_agreement_em_" class="text-danger small"></div>
                        </div>

                        <input type="submit" class="btn btn-big btn-success" value="<?=Yii::t('userModule',"Create account");?>"/>
                        <?php $this->endWidget(); ?>
                        <?php unset($form);?>
                        <?php if(isset($inviteCode)):?>
                            <?php $vkRedierectUrl = '';?>
                        <?php else:?>
                        <?php endif;?>
                        <?php $this->widget('application.modules.user.widgets.vkAuth.VkAuthWidget', array(
                            'appId' => Yii::app()->params['vk']['appId'],
                            'view' => 'registration_link',
                            'redirectUri' => Yii::app()->createAbsoluteUrl('/user/login/VkAuthRedirect')
                        )); ?>
                        <?php $this->widget('application.modules.user.widgets.fbAuth.FbAuthWidget', array(
                            'appId' => Yii::app()->params['fb']['appId'],
                            'view' => 'registration_link',
                            'fields' => 'last_name,first_name,email,id,picture,name,link',
                            'authUrl' => Yii::app()->createUrl('/user/login/fbAuthenticate'),
                            'redirectUrl' => Yii::app()->createUrl('/user/profile/editMainSettings')
                        )); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
