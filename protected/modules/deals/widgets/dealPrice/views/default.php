<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var $deal Deals
 * @var $userCurrency Currencies
 */
$dealPrice = $deal->getMinPrice();
if($dealPrice>0){
    $priceInRUR = $dealPrice*$deal->currency->rate;
    $userPrice = $priceInRUR/$userCurrency->rate;
}
;?>
<span><?=Yii::t('dealsModule','Price');?></span>
<span><?=$dealPrice;?> <?=(isset($deal->currency)) ? $deal->currency->key : $userCurrency->key;?></span>
<?php if($dealPrice>0 && $userCurrency->key != $deal->currency->key):?>
    <span><?=ceil($userPrice);?> <?=(isset($deal->currency)) ? $userCurrency->key : $userCurrency->key;?></span>
<?php endif;?>
