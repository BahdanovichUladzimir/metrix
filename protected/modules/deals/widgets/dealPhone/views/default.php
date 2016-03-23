<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 21.03.2015
 * @var string $phone
 * @var string $publicPhone
 * @var string $invisiblePhone
 * @var $deal Deals
 */
;?>
<div class="phone b-spr">
    <span><?=Yii::t("dealsModule","Phone");?></span>
    <span class="public-phone" id="public_phone"><?=$invisiblePhone;?></span>
    <a class="gr-btn show-phone fancybox.ajax" id="show_phone" href="<?=Yii::app()->createUrl('/deals/frontend/catalog/getDealContacts', array('deal_id' => $deal->id));?>" data-param_name="phone_1"><?=Yii::t('dealsModule',"Show phone");?></a>
    <span style="color: #a94442" class="text-danger"></span>

</div>