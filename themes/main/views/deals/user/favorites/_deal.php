<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.03.2015
 * @var $data Deals
 */
$deal = $data;
;?>
<script>
    $(function(){
        $(document).ready(function(){
            var body = $('body');
            body.on('click','#deleteFromFavoritesBtn_<?=$deal->id;?>',function(){
                var link = $("#deleteFromFavoritesBtn_<?=$deal->id;?>");
                $.ajax(
                    {
                        'data':{'id':<?=$deal->id;?>},
                        'beforeSend':function(){
                            link.addClass("loading");
                        },
                        'success':function(json){
                            $.fn.yiiListView.update('my_favorites_list',{});
                            var data = $.parseJSON(json)
                            if(data.status == "success"){
                                link.removeClass("loading").removeClass("act").attr("id","addToFavoritesBtn_<?=$deal->id;?>");
                                $(window).trigger('dealsModule.deleteFromFavorites');
                            }
                        },
                        'url':"<?=Yii::app()->createUrl("/deals/user/userDeals/deleteFromFavorites");?>",
                        'cache':false
                    });
                return false;
            });
        });
    });
</script>
<div class="panel panel-default">
    <div class="panel-body service-link cf">
        <div class="service-info">
            <a href="<?=$deal->getPublicUrl();?>"><?=$deal->name;?></a>
            <?=$deal->getDealAuthorLink();?>
            <p class="ellipsis">
                <?php
                $this->widget('ext.XReadMore.XReadMore', array(
                    'showLink'=>false,
                    'model'=>$deal,
                    'attribute'=>'intro',
                    'maxChar'=>200,
                ));
                ?>
            </p>
            <div class="bottom-container">
                <div>
                    <?php /*$this->widget('modules.deals.widgets.addToFavorites.AddToFavoritesWidget', array(
                        'deal'=>$deal,
                    ));*/?>
                    <a href="" id="deleteFromFavoritesBtn_<?=$deal->id;?>" class="btn add-to-fav a-spr act"></a>
                    <a href="<?=$deal->getPublicUrl();?>" class="more btn"><span class="a-spr"><?=Yii::t("dealsModule","More");?></span></a>
                </div>
                <div class="price">
                    <?php $this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
                        'deal'=>$deal,
                    ));?>
                </div>
                <?php $this->widget('modules.deals.widgets.dealRating.DealRatingWidget', array(
                    'deal'=>$deal,
                ));?>
            </div>
        </div>
        <?php if(sizeof($deal->dealsImages)>0):?>
            <div class="gallery">
                <?php $counter=0;?>
                <?php foreach($deal->dealsImages as $image):?>
                    <?php if($counter<3):?>
                        <div>
                            <?php echo CHtml::image($image->getSmallThumbUrl(),$deal->name);?>
                        </div>
                    <?php endif;?>
                    <?php $counter++;?>
                <?php endforeach;?>
            </div>
        <?php else:?>
            <div class="gallery not-available">
                <div>
                    <span><?=Yii::t("dealsModule","No images");?></span>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>