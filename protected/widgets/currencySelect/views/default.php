<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 15.03.2015
 * @var array $cities
 * @var int $widgetId
 * @var int $userCurrencyId
 * @var array $currencies
 * @var $currency Currencies
 */
;?>
<script>
    $(function() {
        $('#currency_choice_select').on('change', function(){
            var select = $(this);
            var selected = select.find("option:selected");
            $.cookie('currencyId', selected.val(), { path: '/' });
            window.location.href = window.location.href;
        });
    });
</script>
<div class="value-select pull-right">
    <span><?=Yii::t("core","Currency on site");?>:</span>
    <select id="currency_choice_select">
        <?php foreach($currencies as $currency):?>
            <option <?=($currency->id == $userCurrencyId)?'selected':"";?> value="<?=$currency->id;?>"><?=$currency->name;?></option>
        <?php endforeach;?>
    </select>
</div>