<?php
/**
 * @var $this CatalogController
 * @var $model Deals
 * @var DealsCategories $category
 * @var bool $isShowSeoText
 */
$emptyHtml = $this->renderPartial('_list_empty', array('title' => $category->name, 'message' => Yii::t('dealsModule','Information currently not available')), true, false);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.lazyload.min.js');

?>
<script>
    $(window).load(function(){
        var imgs = $("img.lazy");
        imgs.trigger("categoryPageLoad");
        imgs.lazyload({
            failure_limit: 400
        });
        imgs.lazyload({
            failure_limit: 400,
            event : "categoryPageLoad"
        });

    });
</script>
<?php if($category->for_adults == "1"):?>

    <script>
        $(document).ready(function () {
            if(typeof $.cookie('proof_of_age') === "undefined" || $.cookie('proof_of_age') === "no"){
                $.fancybox({
                    //width: 700,
                    //height: 300,
                    //autoSize: false,
                    autoScale: true,
                    closeBtn: false,
                    //closeClick: false,
                    transitionIn: "fade",
                    transitionOut: "fade",
                    afterClose : function(){
                        if(typeof $.cookie('proof_of_age') === "undefined" || $.cookie('proof_of_age') == "no"){
                            $(location).attr('href', '/');
                        }
                    },
                    type: "ajax",
                    href: '<?=Yii::app()->createUrl("/deals/frontend/catalog/proofOfAge");?>'
                });
                var body = $("body");
                body.on("click","#proof_of_age_confirmation_link_yes", function(){
                    $.cookie('proof_of_age','yes');
                    parent.jQuery.fancybox.close();
                    return false;
                });
                body.on("click","#proof_of_age_confirmation_link_no", function(){
                    $.cookie('proof_of_age','no');
                    parent.jQuery.fancybox.close();
                    return false;
                });
            }
        });
    </script>
<?php endif;?>

<?php $this->widget('modules.deals.widgets.categoryFilters.CategoryFiltersWidget', array(
    'category'=>$category,
    'userCityKey'=>$this->userCityKey,
    'template' => 'mobile',
    'currentFilters' => $model->filter
));?>
<div class="row">
    <section  class="col-lg-9 col-md-9 col-sm-12">
        <div class="cf">
            <?php $this->widget('widgets.currencySelect.CurrencySelectWidget');?>
            <?php if($category->for_adults == "1"):?>
                <h1 class="title section-title h1 for-adults"><?=$this->h1;?></h1>
            <?php else:?>
                <h1 class="title section-title h1"><?=$this->h1;?></h1>
            <?php endif;?>
        </div>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider'=>$model->search($category->page_count),
            'itemView'=>'_deal',   // refers to the partial view named '_post'
            'template' => '{pager}{items}{pager}',
            'summaryText' => '',
            'pagerCssClass' => 'pagerCssClass',
            'emptyText' => $emptyHtml,
            'ajaxUpdate' => false,
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
        ));?>
        <?php if($isShowSeoText && !is_null($this->seoText) && strlen($this->seoText) > 0):?>
            <div class="panel panel-default">
                <div class="panel-body cf">
                    <?=$this->seoText;?>
                </div>
            </div>
        <?php endif;?>
    </section>
    <aside class="col-lg-3 col-md-3 col-sm-3 filter">
        <?php $this->widget('modules.deals.widgets.categoryFilters.CategoryFiltersWidget', array(
            'category'=>$category,
            'userCityKey'=>$this->userCityKey,
            'currentFilters' => $model->filter
        ));?>
        <?php $this->widget('widgets.banners.BannersWidget', array(
            'categoryId'=>$category->id,
            'cityId'=>$this->userCityId,
        ));?>
    </aside>

</div>


