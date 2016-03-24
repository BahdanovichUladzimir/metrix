<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 12.12.2015
 * @var string $phone
 * @var string $publicPhone
 * @var string $invisiblePhone
 * @var string $dealParamName
 * @var $deal Deals
 */
;?>

<span class="params-public-phone public-phone"><?=$invisiblePhone;?></span>
<a class="gr-btn show-phone params-show-phone fancybox.ajax hidden-xs" href="<?=Yii::app()->createUrl('/deals/frontend/catalog/getDealContacts', array('deal_id' => $deal->id));?>" data-param_name="<?=$dealParamName;?>"><?=Yii::t('dealsModule',"Show phone");?></a>
<a class="gr-btn show-phone params-show-phone fancybox.ajax hidden-sm hidden-md hidden-lg" href="<?=Yii::app()->createUrl('/deals/frontend/catalog/getDealContacts', array('deal_id' => $deal->id));?>" data-param_name="<?=$dealParamName;?>"><?=Yii::t('dealsModule',"Show");?></a>
<span class="text-danger"></span>
<?/*=CHtml::link(DealCategoriesParams::getPublicPhoneNumber($paramValue->value),"tel:".$paramValue->value);*/?>
