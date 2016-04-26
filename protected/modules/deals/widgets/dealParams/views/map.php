<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.03.2015
 * @var $deal Deals
 * @var $userCurrency Currencies
 */
;?>
<div class="map-obj-params-container">
    <?php $listParams = array();?>
    <?php foreach($deal->dealsParamsValues as $paramValue):?>
        <?php if(strlen($paramValue->value)>0):?>
            <?php if($paramValue->param->name == 'address'):?>
                <i class="glyphicon glyphicon-map-marker"></i> <?=$paramValue->value;?><br>
            <?php elseif(in_array($paramValue->param->name, array('phone_1','phone_2','phone_3'))):?>
                <?php $this->widget('modules.deals.widgets.dealPhone.DealPhoneWidget', array(
                    'deal'=>$deal,
                    'phone' => $paramValue->value,
                    'dealParamName' => $paramValue->param->name,
                    'template' => 'map'
                ));?>
            <?php elseif($paramValue->param->name == 'site'):?>
                <i class="glyphicon glyphicon-link"></i> <?=CHtml::link($paramValue->value, DealCategoriesParams::getFormattedUrl($paramValue->value), array('rel' => 'nofollow', 'target' => "_blank"));?>
                <br>
            <?php elseif($paramValue->param->name == 'email'):?>
                <i class="glyphicon glyphicon-envelope"></i> <?=CHtml::link($paramValue->value,"mailto:".$paramValue->value);?>
                <br>
            <?php endif;?>
        <?php endif;?>
    <?php endforeach;?>
</div>



