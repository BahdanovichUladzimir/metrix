<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 10.07.2015
 * @var $model Deals
 * @var $form TbActiveForm
 * @var string $query
 * @var int $widgetId
 */
;?>
<div id="wgt_search_string_<?=$widgetId;?>">
    <?php /*$form=$this->beginWidget('CActiveForm',array(
        'id'=>'mobile_search_string_form',
        'action'=>Yii::app()->createUrl('/deals/frontend/search/index'),
        'method'=>'get',
        'enableAjaxValidation'=>true,
        'htmlOptions' => array(
            'role' => 'search',
            'class' => ''
        )
    )); */?><!--

    <?php /*echo $form->textField(
        $model,
        'sphinxQuery',
        array(
            //'class'=>'form-control search-string',
            'id' => "search_string_input",
            'maxlength' => 70,//@todo в конфиг повыносить
            'value' => (isset($query) && !is_null($query)) ? $query : NULL,
            'name' => 'query',
            'placeholder' => Yii::t('dealsModule', "Enter query"),
        )
    ); */?>

    <?/*=CHtml::submitButton('',array('name' => 'search', 'value'=>'yes'));*/?>
    --><?php /*$this->endWidget();*/?>

    <div class="ya-site-form ya-site-form_inited_no" onclick="return {
'action':'http://dev.all4holidays.com/search',
'arrow':false,
'bg':'transparent',
'fontsize':12,
'fg':'#000000',
'language':'ru',
'logo':'rb',
'publicname':'dev.all4holidays.com search',
'suggest':true,
'target':'_self',
'tld':'ru',
'type':2,
'usebigdictionary':true,
'searchid':2258701,
'input_fg':'#878787',
'input_bg':'#ffffff',
'input_fontStyle':'normal',
'input_fontWeight':'normal',
'input_placeholder':'Введите поисковой запрос',
'input_placeholderColor':'#878787',
'input_borderColor':'#7f9db9'
}">
        <form action="https://yandex.ru/search/site/" method="get" target="_self">
            <input type="hidden" name="searchid" value="2258701"/>
            <input type="hidden" name="l10n" value="ru"/>
            <input type="hidden" name="reqenc" value=""/>
            <input type="search" name="text" value="" style="width: 390px"/>
            <input type="submit" value="Найти"/>
        </form>
    </div>
    <style type="text/css">
        .ya-page_js_yes .ya-site-form_inited_no{
            display: none;
        }
        .ya-site-form table, .ya-site-form table tr, .ya-site-form table tr td{
            border: none;
        }
    </style>
    <script>
        $('body').on('DOMNodeInserted', 'input', function (e) {
            console.log(e);
        });
        $(document).ready(function(){
            setTimeout(function(){
                $(".ya-site-form__submit").val("").css("color","#ffffff");
            }, 1000);
            setTimeout(function(){
                $(".ya-site-form__submit").val("").css("color","#ffffff");
            }, 10000);

            /*var submit_button = $(".ya-site-form__submit");
             console.log(submit_button);
             console.log(submit_button.val());
             submit_button.on('change', function() {
             $(this).val();
             });*/
        });

    </script>
    <script type="text/javascript">
        (function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');
    </script>

</div>