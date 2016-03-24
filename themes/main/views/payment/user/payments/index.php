<?php

/**
 * @var Payments $model
 * @var WebMoneyPayments $webmoneyModel
 * @var User $dbUser
 */
$this->breadcrumbs=array(
    Yii::t('paymentModule','Balance')
);

?>
<section>
    <h1 class="title section-title h1"><?=Yii::t('paymentModule','Balance');?></h1>
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

    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <p class="accent"><?=Yii::t('paymentModule','Current balance');?>: <span><?=$dbUser->getBallance();?> <?=Yii::t('paymentModule','rub');?>.</span></p>
                    <?php /**<p class="accent">Денег осталось на: <span>16 дней</span></p>**/?>
                    <?php echo CHtml::beginForm("https://merchant.webmoney.ru/lmi/payment.asp",$method='post',$htmlOptions=array('class' => 'form')); ?>
                    <div class="inputs-wrap">
                        <label class="radio">
                            <input type="radio" checked="checked" name="LMI_ALLOW_SDP" value=""/>
                            <span></span>
                            <img src="/images/money.png" alt="Webmoney" />
                        </label>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="3"/>
                            <span></span>
                            <img src="/images/alfa.png" alt="Альфа-клик" />

                        </label>
                        <?php /*<label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="4"/>
                            <span></span>
                            Карта российского банка
                        </label>
                        <br>*/?>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="5"/>
                            <span></span>
                            <img src="/images/russki-standart.png" alt="Интернет-банкинг Русский стандарт" />
                        </label>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="6"/>
                            <span></span>
                            <img src="/images/vtb24.png" alt="Интернет-банкинг ВТБ24" />
                        </label>
                        <?php /*<label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="10"/>
                            <span></span>
                            Карта Visa\MasterCard\НСМЭП\Приват24 (только для WMU-кошельков)
                        </label>
                        <br>*/?>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="11"/>
                            <span></span>
                            <img src="/images/mts.png" alt="Мобильная коммерция МТС" />
                        </label>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="12"/>
                            <span></span>
                            <img src="/images/beeline.png" alt="Мобильная коммерция Билайн" />
                        </label>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="14"/>
                            <span></span>
                            <img src="/images/sber.png" alt="Сбербанк Онлайн" />
                        </label>
                        <label class="radio">
                            <input type="radio" name="LMI_ALLOW_SDP" value="9"/>
                            <span></span>
                            <img src="/images/prom.png" alt="Промсвязьбанк" />
                        </label>
                    </div>
                    <div class="input-sum">
                        <?php echo CHtml::hiddenField("LMI_PAYMENT_NO",$dbUser->id); ?>
                        <?php echo CHtml::hiddenField("LMI_PAYMENT_DESC_BASE64",base64_encode(Yii::t('paymentModule','Recharge online all4holidays.com for user {userId}', array("{userId}" => $dbUser->id)))); ?>
                        <?php echo CHtml::hiddenField("LMI_PAYEE_PURSE",Yii::app()->config->get("PAYMENT_MODULE.WMB_RUR_PURSE")); ?>
                        <?php echo CHtml::hiddenField("id",$dbUser->id); ?>
                        <?php echo CHtml::textField("LMI_PAYMENT_AMOUNT","", array('size' => 15,'class' => 'form-control', 'placeholder' => Yii::t('paymentModule','Enter amount'))); ?>
                        <?php echo CHtml::submitButton(Yii::t('paymentModule',"Proceed to checkout"),array('class'=> 'btn btn-default','id' => 'recharge_submit')); ?>
                        <?php echo CHtml::endForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cf tt-u">
        <ul class="nav nav-tabs navbar-left">
            <li class="active"><a href="#balance-tab-01" data-toggle="tab"><?=Yii::t('paymentModule','Incoming');?></a></li>
            <li><a href="#balance-tab-02" data-toggle="tab"><?=Yii::t('paymentModule','Outgoing');?></a></li>
            <!--<li><a href="#balance-tab-03" data-toggle="tab">Бонусы</a></li>-->
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane active" id="balance-tab-01">
            <div class="panel">
                <div class="panel-body">
                    <?php $this->widget('booster.widgets.TbGridView',array(
                        'id'=>'payments-grid',
                        'dataProvider'=>$model->incomingSearch(),
                        'enableSorting' => false,
                        //'filter'=>false,
                        'columns'=>array(
                            array(
                                'name' => 'formattedDate',
                                'header' => Yii::t("paymentModule",'Date'),
                                'type' => 'raw',
                                'value' => '$data->getFormattedDate()',
                                'filter' => false,
                            ),
                            array(
                                'name' => 'formattedTime',
                                'header' => Yii::t("paymentModule",'Time'),
                                'type' => 'raw',
                                'value' => '$data->getFormattedTime()',
                                'filter' => false,
                            ),
                            /*array(
                                'name' => 'type_id',
                                'header' => Yii::t("paymentModule",'Type'),
                                'type' => 'raw',
                                'value' => '$data->type->name',
                                //'filter' => 'none',
                            ),*/
                            array(
                                'name' => 'amount',
                                'filter' => false,
                                'type' => 'raw'
                            ),
                            array(
                                'name' => 'description',
                                'header' => Yii::t("paymentModule",'Note'),
                                'type' => 'raw',
                                'value' => '$data->getDescription()',
                                'filter' => false,
                            ),
                        ),
                        'itemsCssClass' => 'table table-striped table-contacts',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="balance-tab-02">
            <div class="panel">
                <div class="panel-body">
                    <?php $this->widget('booster.widgets.TbGridView',array(
                        'id'=>'payments-grid',
                        'dataProvider'=>$model->outgoingSearch(),
                        'enableSorting' => false,
                        //'filter'=>false,
                        'columns'=>array(
                            array(
                                'name' => 'formattedDate',
                                'header' => Yii::t("paymentModule",'Date'),
                                'type' => 'raw',
                                'value' => '$data->getFormattedDate()',
                                'filter' => false,
                            ),
                            array(
                                'name' => 'formattedTime',
                                'header' => Yii::t("paymentModule",'Time'),
                                'type' => 'raw',
                                'value' => '$data->getFormattedTime()',
                                'filter' => false,
                            ),
                            /*array(
                                'name' => 'type_id',
                                'header' => 'Type',
                                'type' => 'raw',
                                'value' => '$data->type->name',
                                //'filter' => 'none',
                            ),*/
                            array(
                                'name' => 'amount',
                                'filter' => false,
                                'type' => 'raw'
                            ),
                            array(
                                'name' => 'description',
                                'header' => Yii::t("paymentModule",'Note'),
                                'type' => 'raw',
                                'value' => '$data->getDescription()',
                                'filter' => false,
                            ),
                        ),
                        'itemsCssClass' => 'table table-striped table-contacts',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</section>

