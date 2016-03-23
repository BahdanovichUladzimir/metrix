<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var $deal Deals
 * @var $category DealsCategories
 * @var array $currentRatings
 * @var int|string $currentTotalRating
 */
;?>
<script>
    $(function() {
        $(window).on('deal_rating.update',function(event,deal_id){
            $.ajax({
                url:"<?=Yii::app()->createUrl("/deals/frontend/catalog/getTotalDealRating", array('deal_id'=>$deal->id));?>",
                type: "post",
                data:{
                    deal_id:deal_id
                },
                success:function(response){
                    var container = $("#total_rating_container");
                    var stars = container.find(".rating-form span");
                    stars.removeClass('active');
                    stars.each(function(i){
                        console.log(i);
                        if(i+1 == response){
                            $(this).prevAll().addClass('active');
                            $(this).addClass('active');
                        }
                    });
                    console.log(stars);

                }
            });
        });
        <?php if(Yii::app()->user->getIsCanSetRating()):?>
            $('.rating-form span.general-rating-star').click(function(){
                $.fancybox({
                    href:"#detail_rating_container"
                })
            });
        <?php endif;?>
        $('.rating-form.param-rating span:not(.rating-form.static span)').hover(function(){
                $(this).prevAll().addClass('act');
                $(this).addClass('act');
            },
            function(){
                $(this).prevAll().removeClass('act');
                $(this).removeClass('act');
            });

        $('.rating-form.param-rating span:not(.rating-form.static span)').click( function() {
            if(!$(this).data('fix')) return;
            $(this).addClass('active').nextAll().removeClass('active').end().prevAll().addClass('active');
        });
        $("#send_rating").click(function(){
            var container = $(this).closest(".hidden-rating");
            var rating_forms = container.find('.rating-form');
            var ratings = [];
            rating_forms.each(function(i,item){
                var rating_id = $(this).attr('id').substr(7);
                var stars = $(this).find("span.active");
                if(stars.length>0){
                    var rating = {};
                    rating.id = rating_id;
                    rating.value = stars.last().data('num');
                    ratings.push(rating);
                }
            });
            $.ajax({
                url:"/deals/frontend/catalog/setDealRating",
                type: "post",
                data:{
                    deal_id:<?=$deal->id;?>,
                    ratings:ratings
                },
                success:function(json_response){
                    var response = $.parseJSON(json_response);
                    if(response.status == "success"){
                        $.fancybox.close();
                        $(window).trigger('deal_rating.update',<?=$deal->id;?>);
                    }
                    else{
                        container.find("#rating_error").text(response.message);
                    }
                }
            });
            return false;
        })
    });

</script>
<div>
    <span><?=Yii::t("dealsModule","Rating");?></span>
    <div class="rating total-rating" id="total_rating_container">
        <div class="rating-form">
            <?php for($i=1;$i<=5;$i++):?>
                <?php $currentClass = '';?>
                <?php if($i<=$currentTotalRating):?>
                    <?php $currentClass = 'active';?>
                <?php endif;?>
                <?php if(Yii::app()->user->getIsCanSetRating()):?>
                    <span data-num="<?=$i;?>" data-fix="1" class="general-rating-star <?=$currentClass;?>" title="<?=Yii::t('dealsModule','Evaluate');?>"></span>
                <?php else:?>
                    <span data-num="<?=$i;?>" data-fix="1" class="cursor-def <?=$currentClass;?>"></span>
                <?php endif;?>
            <?php endfor;?>
        </div>
    </div>
</div>
<div class="hidden-rating container" style="display: none; width: 300px;" id="detail_rating_container">
    <?php foreach($currentRatings as $rating):?>
        <div class="rating param-rating row">
            <div class="rating-label-container col-lg-6">
                <span><?=$rating->label;?></span>
            </div>
            <div class="rating-form param-rating stars-container col-lg-6" id="rating_<?=$rating->id;?>">
                <?php for($i=1;$i<=5;$i++):?>
                    <?php $currentClass = '';?>
                    <?php if($i<=$rating->getValue()):?>
                        <?php $currentClass = 'active';?>
                    <?php endif;?>
                    <span data-num="<?=$i;?>" data-fix="1" class="<?=$currentClass;?>"></span>
                <?php endfor;?>
            </div>
        </div>
        <div class="row spacer-10"></div>

    <?php endforeach;?>
    <div class="row">
        <div class="col-xs-12">
            <span class="text-danger" id="rating_error">
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <br/>
            <a href="" id="send_rating" class="btn btn-success pull-right"><?=Yii::t('core','Send');?></a>
        </div>
    </div>
</div>

