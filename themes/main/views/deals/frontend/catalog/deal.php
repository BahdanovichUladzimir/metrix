<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.03.2015
 */

;?>
<?php if($deal->forAdults):?>
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
                            $(location).attr('href', '<?=Yii::app()->getBaseUrl(true);?>');
                        }
                    },
                    type: "ajax",
                    href: '<?=Yii::app()->createUrl("/deals/frontend/catalog/proofOfAge");?>'
                });
                var body = $("body");
                body.on("click","#proof_of_age_confirmation_link_yes", function(){
                    $.cookie('proof_of_age','yes');
                    $.fancybox.close();
                    return false;
                });
                body.on("click","#proof_of_age_confirmation_link_no", function(){
                    $.cookie('proof_of_age','no');
                    $.fancybox().close();
                    return false;
                });
            }
        });
    </script>
<?php endif;?>
<script>
    $(document).ready(function(){
        $("a.show-phone").click(function(){
            var phones_links = $('a.show-phone');
            phones_links.each(function(){
                var link = $(this);
                var param_name = link.data('param_name');
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/deals/frontend/catalog/showPhone', array('deal_id' => $deal->id));?>",
                    dataType: "json",
                    type:"post",
                    data:{'deal_id':<?=$deal->id;?>,'param_name':param_name},
                    success: function(data){
                        if(data.status === "success"){
                            link.prev(".public-phone").text(data.phone);
                            link.remove();
                        }
                        else if(data.status === "error"){
                            link.next(".text-danger").text(data.message);
                            link.remove();
                        }
                        else{
                            link.next(".text-danger").text("Undefined error.");
                            link.remove();
                        }
                    },
                    error:function(){
                        link.next(".text-danger").text("Undefined error.");
                        link.remove();
                    }
                });
            });
            //return false;
        });
        $(".show-phone").fancybox();
    });
</script>
<section>
    <?php if(Yii::app()->user->getId() == $deal->user_id || Yii::app()->getModule("user")->isAdmin()):?>
        <?php if($deal->status_id == "2"):?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=Yii::t("dealsModule","Warning!");?></strong> <?=Yii::t("dealsModule","This ad is not published.");?>
            </div>
        <?php endif;?>
        <?php if($deal->status_id == "3" || $deal->approve == "0"):?>
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=Yii::t("dealsModule","Info!");?></strong> <?=Yii::t("dealsModule","This ad is moderated.");?>
            </div>
        <?php endif;?>
        <?php if(sizeof($deal->frontendDealsImages) <= 3):?>
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=Yii::t("dealsModule","Info!");?></strong>
                <?=CHtml::link(
                    Yii::t("dealsModule","Load more images."),
                    Yii::app()->createUrl('/deals/user/userDeals/photo', array('id'=>$deal->id))
                );?>
                <?=Yii::t("dealsModule","So your customers will be able to learn more about your product/service.");?>
            </div>
        <?php endif;?>
        <?php if((sizeof($deal->frontendDealsVideos) == 0) && (sizeof($deal->frontendDealLinks) == 0)):?>
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=Yii::t("dealsModule","Info!");?></strong>
                <?=CHtml::link(
                    Yii::t("dealsModule","Load videos."),
                    Yii::app()->createUrl('/deals/user/userDeals/video', array('id'=>$deal->id))
                );?>
                <?=Yii::t("dealsModule","So your customers will be able to learn more about your product/service.");?>
            </div>
        <?php endif;?>
    <?php endif;?>


    <div class="panel panel-default">
        <div class="panel-body cf">
            <div class="service-info inner">
                <?php if((!is_null(Yii::app()->user->getId()) && Yii::app()->user->getId() == $deal->user_id) || Yii::app()->getModule('user')->isAdmin()):?>
                    <div class="dropdown pull-right">
                        <a href="#" class="gr-btn dropdown-toggle" data-toggle="dropdown"><?=Yii::t('core','Edit');?></a>
                        <ul class="dropdown-menu edit-func">
                            <li><?=CHtml::link(Yii::t('ses','Edit'),Yii::app()->createUrl('/deals/user/userDeals/update', array('id'=>$deal->id)),array('class' => 'change b-spr'));?></li>
                            <!--<li>
                                <?/*=CHtml::ajaxLink(
                                    Yii::t('ses','Update'),
                                    array(
                                        '/deals/user/userDeals/setDealUpdatedDate',
                                        'deal_id'=>$deal->id,
                                    ),
                                    array(
                                        'type'=>'POST',
                                        'success'=>'js:function(data){
                                                                console.log(data);
                                                            }'
                                    ),
                                    array(
                                        'class' => 'up b-spr'
                                    )
                                );*/?>
                            </li>-->
                            <li id="set_deal_status_hide_item"<?=($deal->status_id == 2) ? ' style="display:none" ' : '';?>>
                                <?=CHtml::ajaxLink(
                                    Yii::t('dealsModule','Hide'),
                                    array(
                                        '/deals/user/userDeals/setDealStatus',
                                    ),
                                    array(
                                        'type'=>'POST',
                                        'data' => array(
                                            'deal_id'=>$deal->id,
                                            'status_id'=>2,
                                        ),
                                        'dataType' => 'json',
                                        'success'=>'js:function(data){
                                                                console.log(data);
                                                                if(data.status === "success" && data.dealStatus.name === "not_published"){
                                                                    $("#set_deal_status_hide_item").hide();
                                                                    $("#set_deal_status_publish_item").show();
                                                                }
                                                            }'
                                    ),
                                    array(
                                        'class' => 'hdn b-spr',
                                        'id' => 'set_deal_status_hide',
                                        'confirm'=>Yii::t('userModule','Are you sure?')
                                    )
                                );?>
                            </li>
                            <li id="set_deal_status_publish_item"<?=($deal->status_id == 1) ? ' style="display:none" ' : '';?>>
                                <?=CHtml::ajaxLink(
                                    Yii::t('dealsModule','Publish'),
                                    array(
                                        '/deals/user/userDeals/setDealStatus',
                                    ),
                                    array(
                                        'type'=>'POST',
                                        'data' => array(
                                            'deal_id'=>$deal->id,
                                            'status_id'=>1,
                                        ),
                                        'dataType' => 'json',
                                        'success'=>'js:function(data){
                                                            console.log(data);
                                                            if(data.status === "success" && data.dealStatus.name === "published"){
                                                                $("#set_deal_status_publish_item").hide();
                                                                $("#set_deal_status_hide_item").show();
                                                            }

                                                        }'
                                    ),
                                    array(
                                        'class' => 'up b-spr',
                                        'id' => 'set_deal_status_publish'
                                    )
                                );?>
                            </li>
                            <li>
                                <?=CHtml::ajaxLink(
                                    Yii::t('ses','Delete'),
                                    array(
                                        '/deals/user/userDeals/delete',
                                        'id'=>$deal->id,
                                    ),
                                    array(
                                        'type'=>'POST',
                                        'dataType'=> 'json',
                                        'success'=>'js:function(data){
                                                                if(data.status == "success"){
                                                                    window.location.href = "'.Yii::app()->createUrl("/user/profile/privateProfile/").'"
                                                                }
                                                            }',
                                    ),
                                    array(
                                        'class' => 'del b-spr',
                                        'confirm'=>Yii::t('userModule','Are you sure?')
                                    )
                                );?>
                            </li>
                        </ul>
                    </div>
                <?php endif;?>
                <?php if($deal->forAdults):?>
                    <h1 class="title section-title h1 for-adults"><?=$deal->name;?></h1>
                <?php else:?>
                    <h1 class="title section-title h1"><?=$deal->name;?></h1>
                <?php endif;?>
                <?=$deal->getDealAuthorLink();?>
                <p><?=$deal->intro;?></p>
                <?php if(strlen($deal->description)>0):?>
                    <div id="readMoreReadLess1"><?=$deal->publicDescription;?></div>
                <?php endif;?>
                <div class="bottom-container">
                    <div>
                        <?php $this->widget('modules.deals.widgets.addToFavorites.AddToFavoritesWidget', array(
                            'deal'=>$deal,
                        ));?>
                        <a href="<?=Yii::app()->createUrl('/messages/user/dialogues/dialog', array("receiver_id" => $deal->user_id, '#' => 'main_menu_container'));?>" class="message btn"><?=Yii::t("dealsModule","Send message");?></a>
                    </div>
                    <div class="price">
                        <?php $this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
                            'deal'=>$deal,
                        ));?>
                    </div>
                    <?php $this->widget('modules.deals.widgets.dealPhone.DealPhoneWidget', array(
                        'deal'=>$deal,
                    ));?>
                    <?php $this->widget('modules.deals.widgets.dealRating.DealRatingWidget', array(
                        'deal'=>$deal,
                    ));?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->widget('modules.deals.widgets.dealGallery.DealGalleryWidget', array(
        'deal'=>$deal,
    ));?>
    <?php $this->widget('modules.deals.widgets.dealParams.DealParamsWidget', array(
        'deal'=>$deal,
    ));?>


    <?php Yii::import('modules.comments.widgets.comments.*');?>
    <?php $this->widget('modules.comments.widgets.comments.CommentsWidget', array(
        'appCategoryId' => 1,
        'appCategoryItemId' => $deal->id
    ));?>
    <hr>
    <?php $this->widget('modules.deals.widgets.relatedDeals.RelatedDealsWidget', array(
        'deal'=>$deal,
    ));?>
</section>
<script src="/js/readmore/readmore.min.js" type="text/javascript"></script>

<!-- Plugin initialization -->
<script type="text/javascript">
    $('#readMoreReadLess1').readmore({
        moreLink: '<a href="#" class="read-more-link text-right"><?=Yii::t('dealsModule', "Show full description");?></a>',
        lessLink: '<a href="#" class="read-more-link text-right"><?=Yii::t('core', "Close");?></a>',
        collapsedHeight: 72,
        speed: 100,
        afterToggle: function(trigger, element, expanded) {
            if(! expanded) { // The "Close" link was clicked
                $('html, body').animate({scrollTop: $(element).offset().top}, {duration: 100});
            }
        }
    });
</script>