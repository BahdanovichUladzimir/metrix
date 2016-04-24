<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 13.06.14
 * @var $dataProvider CActiveDataProvider
 * @var $categoriesDataProvider CActiveDataProvider
 * @var $model Deals
 * @var string $messageStatus
 * @var string $message
 */
/*Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.highlight.js');
if(isset($query) && !is_null($query))
{
    Yii::app()->clientScript->registerScript('search_highlight', "
    $(document).ready(function(){
        $('.deal-name, .ellipsis, .search-result-categories-list-item').highlight(\"".trim(CHtml::encode($query))."\");
    });
");
}
*/
;?>

<div class="row">
    <section class="col-lg-9">
        <div class="cf">
            <?php /*$this->widget('widgets.currencySelect.CurrencySelectWidget');*/?>
            <h1 class="title section-title h1"><?=$this->h1;?></h1>
        </div>
        <div class="alert alert-<?=$messageStatus;?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?=$message;?>
        </div>
        <?php /*if(is_null($categoriesDataProvider) && is_null($dataProvider)):*/?><!--
            <h3></h3>
        <?php /*else:*/?>
            <?php /*if(!is_null($categoriesDataProvider)):*/?>
                <?php /*$this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$categoriesDataProvider,
                    'itemView'=>'_category',   // refers to the partial view named '_item'
                    'ajaxUpdate'=>false,
                    'emptyText' => '',
                    'template'=>'<ul class="categories-search-result-list">{items}</ul>',
                ));*/?>
            <?php /*endif;*/?>

            <?php /*if(!is_null($dataProvider)):*/?>
                <?php /*$this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_item',   // refers to the partial view named '_item'
                    'ajaxUpdate'=>false,
                    'pagerCssClass' => 'pagerCssClass',
                    'template'=>'<div class="row search-list-info"><div class="col-xs-6">{summary}</div><div class="col-xs-6">{sorter}</div></div>{items}{pager}',
                    'emptyText' => '',
                    'pager' => array(
                        'maxButtonCount' => 12,
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'footer' => '</nav>',
                        'header' => '<nav>',
                        'selectedPageCssClass' => 'active',
                        'htmlOptions' => array(
                            'class' => 'pagination'
                        )
                    ),
                ));*/?>
            <?php /*endif;*/?>
        --><?php /*endif;*/?>


        <div id="ya-site-results" onclick="return {'tld': 'ru','language': 'ru','encoding': '','htmlcss': '1.x','updatehash': true}"></div><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0];s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Results.init();})})(window,document,'yandex_site_callbacks');</script>
        <style>
            #ya-site-results
            {
                color: #000000;
                background: #FFFFFF;
            }

            #ya-site-results .b-pager__current,
            #ya-site-results .b-serp-item__number
            {
                color: #000000 !important;
            }

            #ya-site-results
            {
                font-family: Arial !important;
            }

            #ya-site-results :visited,
            #ya-site-results .b-pager :visited,
            #ya-site-results .b-foot__link:visited,
            #ya-site-results .b-copyright__link:visited
            {
                color: #800080;
            }

            #ya-site-results a:link,
            #ya-site-results a:active,
            #ya-site-results .b-pseudo-link,
            #ya-site-results .b-head-tabs__link,
            #ya-site-results .b-head-tabs__link:link,
            #ya-site-results .b-head-tabs__link:visited,
            #ya-site-results .b-dropdown__list .b-pseudo-link,
            #ya-site-results .b-dropdowna__switcher .b-pseudo-link,
            .b-popupa .b-popupa__content .b-menu__item,
            #ya-site-results .b-foot__link:link,
            #ya-site-results .b-copyright__link:link,
            #ya-site-results .b-serp-item__mime,
            #ya-site-results .b-pager :link
            {
                color: #0033FF;
            }

            #ya-site-results :link:hover,
            #ya-site-results :visited:hover,
            #ya-site-results .b-pseudo-link:hover
            {
                color: #FF0000 !important;
            }

            #ya-site-results .l-page,
            #ya-site-results .b-bottom-wizard
            {
                font-size: 13px;
            }

            #ya-site-results .b-pager
            {
                font-size: 1.25em;
            }

            #ya-site-results .b-serp-item__text,
            #ya-site-results .ad
            {
                font-style: normal;
                font-weight: normal;
            }

            #ya-site-results .b-serp-item__title-link,
            #ya-site-results .ad .ad-link
            {
                font-style: normal;
                font-weight: normal;
            }

            #ya-site-results .ad .ad-link a
            {
                font-weight: bold;
            }

            #ya-site-results .b-serp-item__title,
            #ya-site-results .ad .ad-link
            {
                font-size: 16px;
            }

            #ya-site-results .b-serp-item__title-link:link,
            #ya-site-results .b-serp-item__title-link
            {
                font-size: 1em;
            }

            #ya-site-results .b-serp-item__number
            {
                font-size: 13px;
            }

            #ya-site-results .ad .ad-link a
            {
                font-size: 0.88em;
            }

            #ya-site-results .b-serp-url,
            #ya-site-results .b-direct .url,
            #ya-site-results .b-direct .url a:link,
            #ya-site-results .b-direct .url a:visited
            {
                font-size: 13px;
                font-style: normal;
                font-weight: normal;
                color: #329932;
            }

            #ya-site-results .b-serp-item__links-link
            {
                font-size: 13px;
                font-style: normal;
                font-weight: normal;
                color: #000000 !important;
            }

            #ya-site-results .b-pager__inactive,
            #ya-site-results .b-serp-item__from,
            #ya-site-results .b-direct__head-link,
            #ya-site-results .b-image__title,
            #ya-site-results .b-video__title
            {
                color: #000000 !important;
            }

            #ya-site-results .b-pager__current,
            #ya-site-results .b-pager__select
            {
                background: #E0E0E0;
            }

            #ya-site-results .b-foot,
            #ya-site-results .b-line
            {
                border-top-color: #E0E0E0;
            }

            #ya-site-results .b-dropdown__popup .b-dropdown__list,
            .b-popupa .b-popupa__content
            {
                background-color: #FFFFFF;
            }

            .b-popupa .b-popupa__tail
            {
                border-color: #E0E0E0 transparent;
            }

            .b-popupa .b-popupa__tail-i
            {
                border-color: #FFFFFF transparent;
            }

            .b-popupa_direction_left.b-popupa_theme_ffffff .b-popupa__tail-i,
            .b-popupa_direction_right.b-popupa_theme_ffffff .b-popupa__tail-i
            {
                border-color: transparent #FFFFFF;
            }

            #ya-site-results .b-dropdowna__popup .b-menu_preset_vmenu .b-menu__separator
            {
                border-color: #E0E0E0;
            }

            .b-specification-list,
            .b-specification-list .b-pseudo-link,
            .b-specification-item__content label,
            .b-specification-item__content .b-link,
            .b-specification-list .b-specification-list__reset .b-link
            {
                color: #000000 !important;
                font-family: Arial;
                font-size: 13px;
                font-style: normal;
                font-weight: normal;
            }

            .b-specification-item__content .b-calendar__title
            {
                font-family: Arial;
                color: #000000;
                font-size: 13px;
                font-style: normal;
                font-weight: normal;
            }

            .b-specification-item__content .b-calendar-month__day_now_yes
            {
                color: #E0E0E0;
            }

            .b-specification-item__content .b-calendar .b-pseudo-link
            {
                color: #000000;
            }

            .b-specification-item__content
            {
                font-family: Arial !important;
                font-size: 13px;
            }

            .b-specification-item__content :visited
            {
                color: #800080;
            }

            .b-specification-item__content .b-pseudo-link:hover,
            .b-specification-item__content :visited:hover
            {
                color: #FF0000 !important;
            }

            #ya-site-results .b-popupa .b-popupa__tail-i
            {
                background: #FFFFFF;
                border-color: #E0E0E0 !important;
            }
        </style>

    </section>
    <section class="col-lg-3">


    </section>


</div>
<div class="row">
    <div class="col-lg-9 col-sm-12 col-xs-12 col-md-9">
        <?=$this->seoText;?>
    </div>
</div>


