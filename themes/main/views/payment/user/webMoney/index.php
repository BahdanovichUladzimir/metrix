<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 16.12.2015
 * @var User $user
 * @var $form TbActiveForm
 * @var $model WebmoneyPayments
 */
;?>
<h1 class="title section-title"><?=Yii::t('paymentModule','Deposit using Webmoney');?></h1>
<!--<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
    <input type="hidden" name="LMI_PAYMENT_NO" value="1">
    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="0.05">
    <input type="hidden" name="LMI_PAYMENT_DESC" value="код пополнения Super Mobile">
    <input type="hidden" name="LMI_PAYEE_PURSE" value="Z155771820786">
    <input type="hidden" name="id" value="345">
    Укажите email для отправки товара: <input type="text" name="email" size="15">
    <input type="submit" value="Перейти к оплате">
</form>-->
<?php if( Yii::app()->user->hasFlash('webMoneyRecharge.success')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('webMoneyRecharge.success'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('webMoneyRecharge.error')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('webMoneyRecharge.error'); ?>
    </div>
<?php endif; ?>
<?php echo CHtml::beginForm("https://merchant.webmoney.ru/lmi/payment.asp",$method='post',$htmlOptions=array('class' => 'form')); ?>
    <?php echo CHtml::hiddenField("LMI_PAYMENT_NO",$model->id); ?>
    <?php echo CHtml::hiddenField("LMI_PAYMENT_DESC",$model->description); ?>
    <?php echo CHtml::hiddenField("LMI_PAYEE_PURSE",$model->purse); ?>
    <?php echo CHtml::hiddenField("id",$user->id); ?>
    <div class="row">
        <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="email" class="control-label required"><?=Yii::t('paymentModule','Enter amount');?>
                    <span class="required">*</span>
                </label>
                <div>
                    <?php echo CHtml::textField("LMI_PAYMENT_AMOUNT","", array('size' => 15,'class' => 'form-control', 'placeholder' => 'Enter amount')); ?>
                    <div style="display:none" id="email_em_" class="help-block error"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-9 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="email" class="control-label required"><?=Yii::t('paymentModule','Enter email');?>
                    <span class="required">*</span>
                </label>
                <div>
                    <?php echo CHtml::emailField("email","", array('size' => 15,'class' => 'form-control', 'placeholder' => 'Enter email')); ?>
                    <div style="display:none" id="email_em_" class="help-block error"></div>
                </div>
            </div>
        </div>
    </div>
    <?php echo CHtml::submitButton(Yii::t('paymentModule',"Proceed to checkout"),array('class'=> 'btn btn-default')); ?>


<?php echo CHtml::endForm(); ?>
