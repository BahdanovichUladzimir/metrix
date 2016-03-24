<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var $deal Deals
 */
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
                            var data = $.parseJSON(json);
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
            body.on('click','#addToFavoritesBtn_<?=$deal->id;?>',function(){
                var link = $("#addToFavoritesBtn_<?=$deal->id;?>");
                $.ajax(
                    {
                        'data':{'id':<?=$deal->id;?>},
                        'beforeSend':function(){
                            link.addClass("loading");
                        },
                        'success':function(json){
                            var data = $.parseJSON(json);
                            if(data.status == "success"){
                                link.removeClass("loading").addClass("act").attr("id","deleteFromFavoritesBtn_<?=$deal->id;?>");
                                $(window).trigger('dealsModule.addToFavorites');
                            }
                        },
                        'url':"<?=Yii::app()->createUrl("/deals/user/userDeals/addToFavorites");?>",
                        'cache':false
                    });
                return false;
            });
        });
    });
</script>
<?php if($deal->isInFavorites()):?>
    <a href="" id="deleteFromFavoritesBtn_<?=$deal->id;?>" class="btn add-to-fav a-spr act"></a>
<?php else:?>
    <a href="" id="addToFavoritesBtn_<?=$deal->id;?>" class="btn add-to-fav a-spr"></a>
<?php endif;?>
