<?php
/**
 * @var $profile Profile
 * @var $model User
 * @var $deal Deals
 */
$this->breadcrumbs=array(
    Yii::t('userModule',"Profile"),
);?>
<script>
    $(document).ready(function(){
        if(window.location.hash === '#events'){
            $(".nav-tabs>li").removeClass("active");
            $("#events_li").addClass("active");
            $("#offers").removeClass("active");
            $("#banners").removeClass("active");
            $("#events").addClass("active");
        }
        else if(window.location.hash === '#banners'){
            $(".nav-tabs>li").removeClass("active");
            $("#banners_li").addClass("active");
            $("#offers").removeClass("active");
            $("#events").removeClass("active");
            $("#banners").addClass("active");
        }
        $('.fancybox').fancybox({
            href: $(this).attr('href')
        });
        $("#invitekey_copy_btn").click(function(){
            var text = $(this).prev().text();
            copyToClipboard(text);
        });$("#invitelink_copy_btn").click(function(){
            var text = $(this).prev().text();
            copyToClipboard(text);
        });

    });
    function copyToClipboard (text) {
        window.prompt ("<?=Yii::t('userModule','To copy the code to the clipboard, press Ctrl + C and Enter');?>", text);
    }
</script>

<section>
    <h1 class="title section-title h1"><?php echo Yii::t('userModule','Your profile'); ?></h1>
    <div class="messages">
        <?php if( Yii::app()->user->hasFlash('profileMessage')):?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
            </div>
        <?php endif; ?>

        <?php if( Yii::app()->user->hasFlash('profileMessageError')):?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::app()->user->getFlash('profileMessageError'); ?>
            </div>
        <?php endif; ?>

        <?php if( Yii::app()->user->hasFlash('deleteDeal')):?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo Yii::app()->user->getFlash('deleteDeal'); ?>
            </div>
        <?php endif; ?>
        <?php /** <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4>Учавствуйте в <a href="https://all4holidays.com/konkurs-23.html">конкурсе</a> и выигрывайте ценные призы!</h4>
        <ol>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/create');?>">Добавляйте новые объявления!</a></li>
        <?php
        $url = Yii::app()->createAbsoluteUrl("user/registration/authorization?invite_code=".$model->invitekey);
        $title = Yii::t('userModule',"all4holidays.com - all for holidays");
        $description = Yii::t('userModule',"Join me on all4holidays.com");
        $image = Yii::app()->createAbsoluteUrl('images/logo.png')
        ;?>
        <li>
        <a href="http://vk.com/share.php?url=<?=$url;?>&title=<?=$title;?>&description=<?=$description;?>&image=<?=$image;?>" target="_blank">
        Приглашайте коллег к участию!
        </a>
        </li>
        <li>
        <p>Скопируй код приглашения и отправь его другу</p>
        <p><span class="invitekey"><?=$model->invitekey;?></span>&nbsp;&nbsp;<i class="glyphicon glyphicon-copy invitekey-copy-btn" id="invitekey_copy_btn"></i></p>
        </li>
        <li>
        <p>Не забывайте делиться ссылкой с кодом приглашения:</p>
        <p><span class="invitekey"><?=Yii::app()->createAbsoluteUrl("user/registration/authorization?invite_code=".$model->invitekey);?></span>&nbsp;&nbsp;<i class="glyphicon glyphicon-copy invitekey-copy-btn" id="invitelink_copy_btn"></i></p>
        <p>Это многократно увеличит Ваши шансы на победу!</p>
        </li>
        </ol>
        <p><a href="https://all4holidays.com/konkurs-23.html">Узнать больше...</a></p>


        </div>*/;?>


    </div>
    <div class="panel panel-default">
        <div class="panel-body cf">
            <div class="service-info inner">
                <?=CHtml::link(Yii::t("userModule","Edit profile"),Yii::app()->createUrl('user/profile/editMainSettings'), array('class' => 'gr-btn pull-right'));?>
                <img src="<?=$profile->getMediumThumbUrl();?>" class="img-left avatar" alt="" />
                <h1 class="title section-title"><?php echo CHtml::encode($model->username);?></h1>
                <?php if($profile->city):?>
                    <span class="location b-spr"><?=CHtml::encode($profile->city->name);?>, <?=CHtml::encode($profile->city->country->name);?></span>
                <?php endif;?>
                <p><?=CHtml::encode($profile->description);?></p>
                <div class="bottom-container">
                    <?php if(strlen($profile->phone)>0):?>
                        <div class="phone b-spr">
                            <span><?=Yii::t('userModule','Phone');?></span>
                            <span><?=CHtml::encode($profile->phone);?></span>
                        </div>
                    <?php endif;?>

                    <div>
                        <?php $this->widget('modules.user.widgets.socialMediaLinks.SocialMediaLinksWidget', array(
                            'user'=>$model,
                        ));?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?=CHtml::link(Yii::t("core","Edit"),Yii::app()->createUrl('user/profile/editContactsSettings'), array('class' => 'gr-btn pull-right'));?>
            <h2 class="title section-title"><?=Yii::t('userModule','Contacts and information');?></h2>
            <table class="table table-striped table-contacts">
                <?php if(strlen($profile->email)>0):?>
                    <tr>
                        <td><?=Yii::t('userModule','Email');?></td>
                        <td><?=$profile->email;?></td>
                    </tr>
                <?php endif;?>
            </table>
        </div>
    </div>
    <div class="cf">
        <ul class="nav nav-tabs navbar-left">
            <li class="active" id="deals_li"><a href="#offers" data-toggle="tab"><?=Yii::t('dealsModule','My deals');?></a></li>
            <li id="events_li"><a href="#events" data-toggle="tab"><?=Yii::t('dealsModule','My events');?></a></li>
            <li id="banners_li"><a href="#banners" data-toggle="tab"><?=Yii::t('dealsModule','My banners');?></a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div id="offers" class="tab-pane active">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?=CHtml::link("+ ".Yii::t("dealsModule","Add deal"),Yii::app()->createUrl('/deals/user/userDeals/create'));?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(sizeof($model->deals)>0):?>
                <?php foreach($model->deals as $deal):?>
                    <div class="panel panel-default user-service" id="user_deal_<?=$deal->id;?>">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="bottom-container">
                                        <div>
                                            <?=CHtml::link($deal->name,$deal->getPublicUrl());?>
                                            <?php if($deal->exceeding_category_limit_hidden == '1'):?>
                                                <p class="text-danger deal-exceeding-category-limit-info" <?=($deal->exceeding_category_limit_hidden == 1) ? "style='display:block'" : "style='display:none'";?> >
                                                    <?=Yii::t("dealsModule","Exceeded limit deals for the category <strong>{categories}</strong>!",array('{categories}' => $deal->getExceedingLimitCategoriesString()));?>
                                                </p>
                                                <?=CHtml::ajaxLink(
                                                    Yii::t('dealsModule','Enable paid impressions.'),
                                                    array(
                                                        '/deals/user/userDeals/payForLimit',
                                                        'id'=>$deal->id,
                                                        'enable'=>1,
                                                    ),
                                                    array(
                                                        'type'=>'POST',
                                                        'dataType'=> 'json',
                                                        'success'=>'js:function(data){
                                                                    if(data.status == "success"){
                                                                        $("#enable_pay_for_limit_link_'.$deal->id.'").hide().prev().hide();
                                                                        $("#disable_pay_for_limit_link_'.$deal->id.'").show();
                                                                    }
                                                                    $(".messages").append(data.html);
                                                                }',
                                                    ),
                                                    array(
                                                        'id' => 'enable_pay_for_limit_link_'.$deal->id,
                                                        'class' => 'btn btn-success turn-paid-impressions-btn',
                                                        'style' => ($deal->exceeding_limit_paid == 0) ? "display:block" : "display:none",
                                                        'confirm'=>Yii::t('userModule','Are you sure you want to enable paid impressions to deal "{name}"?', array("{name}" => $deal->name))
                                                    )
                                                );?>
                                                <?=CHtml::ajaxLink(
                                                    Yii::t('dealsModule','Disable paid impressions.'),
                                                    array(
                                                        '/deals/user/userDeals/payForLimit',
                                                        'id'=>$deal->id,
                                                        'enable'=>0,
                                                    ),
                                                    array(
                                                        'type'=>'POST',
                                                        'dataType'=> 'json',
                                                        'success'=>'js:function(data){
                                                                    if(data.status == "success"){
                                                                        $("#disable_pay_for_limit_link_'.$deal->id.'").hide();
                                                                        $("#enable_pay_for_limit_link_'.$deal->id.'").show().prev().show();
                                                                    }
                                                                    $(".messages").append(data.html);
                                                                }',
                                                    ),
                                                    array(
                                                        'id' => 'disable_pay_for_limit_link_'.$deal->id,
                                                        'class' => 'btn btn-success turn-paid-impressions-btn',
                                                        'style' => ($deal->exceeding_limit_paid == 1) ? "display:block" : "display:none",
                                                        'confirm'=>Yii::t('userModule','Are you sure you want to enable paid impressions to deal "{name}"?', array("{name}" => $deal->name))
                                                    )
                                                );?>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bottom-container">
                                        <div class="price">
                                            <?php $this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
                                                'deal'=>$deal,
                                            ));?>
                                        </div>
                                        <div class="deal-rating-widget-container">
                                            <?php $this->widget('modules.deals.widgets.dealRating.DealRatingWidget', array(
                                                'deal'=>$deal,
                                            ));?>

                                        </div>


                                        <?php $this->widget('modules.deals.widgets.dealStatistics.DealStatisticsWidget', array(
                                            'deal'=>$deal,
                                        ));?>
                                        <div>
                                            <div class="edit-wrap">
                                                <a href="#" class="edit b-spr"></a>
                                                <ul class="dropdown-menu">
                                                    <li><?=CHtml::link(Yii::t('ses','Edit'),Yii::app()->createUrl('/deals/user/userDeals/update', array('id'=>$deal->id)));?></li>
                                                    <li>
                                                        <?=CHtml::ajaxLink(
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
                                                                'class' => 'delete'
                                                            )
                                                        );?>
                                                    </li>
                                                    <!--<li><a href="#">Скрыть</a></li>-->
                                                    <li id="set_paid_list_item_<?=$deal->id;?>" <?=($deal->paid == 0) ? "style='display:block'" : "style='display:none'";?> >
                                                        <?=CHtml::ajaxLink(
                                                            Yii::t('dealsModule','Enable paid impressions'),
                                                            array(
                                                                '/deals/user/userDeals/setPaid',
                                                                'id'=>$deal->id,
                                                                'paid'=>1,
                                                            ),
                                                            array(
                                                                'type'=>'POST',
                                                                'dataType'=> 'json',
                                                                'success'=>'js:function(data){
                                                                    if(data.status == "success"){
                                                                        $("#set_paid_list_item_'.$deal->id.'").hide();
                                                                        $("#set_notpaid_list_item_'.$deal->id.'").show();
                                                                    }
                                                                    $(".messages").append(data.html);
                                                                }',
                                                            ),
                                                            array(
                                                                'class' => 'delete',
                                                                'confirm'=>Yii::t('userModule','Are you sure you want to enable paid impressions to deal "{name}"?', array("{name}" => $deal->name))
                                                            )
                                                        );?>
                                                    </li>
                                                    <li id="set_notpaid_list_item_<?=$deal->id;?>" <?=($deal->paid == 1) ? "style='display:block'" : "style='display:none'";?> >
                                                        <?=CHtml::ajaxLink(
                                                            Yii::t('dealsModule','Disable paid impressions'),
                                                            array(
                                                                '/deals/user/userDeals/setPaid',
                                                                'id'=>$deal->id,
                                                                'paid'=>0,
                                                            ),
                                                            array(
                                                                'type'=>'POST',
                                                                'dataType'=> 'json',
                                                                'success'=>'js:function(data){
                                                                if(data.status == "success"){
                                                                        $("#set_notpaid_list_item_'.$deal->id.'").hide();
                                                                        $("#set_paid_list_item_'.$deal->id.'").show();
                                                                    }
                                                                    $(".messages").append(data.html);
                                                                }',
                                                            ),
                                                            array(
                                                                'class' => 'delete',
                                                                'confirm'=>Yii::t('userModule','Are you sure you want to disable paid impressions to deal "{name}"?', array("{name}" => $deal->name))
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
                                                                        $("#user_deal_'.$deal->id.'").remove();
                                                                    }
                                                                    $(".messages").append(data.html);
                                                                }',
                                                            ),
                                                            array(
                                                                'class' => 'delete',
                                                                'confirm'=>Yii::t('userModule','Are you sure?')
                                                            )
                                                        );?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div id="events" class="tab-pane">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?=CHtml::link("+ ".Yii::t("eventsModule","Add event"),Yii::app()->createUrl('/events/user/events/create'));?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(sizeof($model->events)>0):?>
                <?php foreach($model->events as $event):?>
                    <div class="panel panel-default user-service" id="user_event_<?=$event->id;?>">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="bottom-container">
                                        <div><?=CHtml::link($event->name,$event->getPrivateUrl());?></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bottom-container">

                                        <div>
                                            <div class="edit-wrap">
                                                <a href="#" class="edit b-spr"></a>
                                                <ul class="dropdown-menu">
                                                    <li><?=CHtml::link(Yii::t('ses','Edit'),Yii::app()->createUrl('/events/user/events/update', array('id'=>$event->id)));?></li>
                                                    <li>
                                                        <?=CHtml::ajaxLink(
                                                            Yii::t('ses','Delete'),
                                                            array(
                                                                '/events/user/events/delete',
                                                                'id'=>$event->id,
                                                            ),
                                                            array(
                                                                'type'=>'POST',
                                                                'dataType'=> 'json',
                                                                'success'=>'js:function(data){
                                                                if(data.status == "success"){
                                                                    $("#user_event_'.$event->id.'").remove();
                                                                }
                                                                $(".messages").append(data.html);
                                                            }',
                                                            ),
                                                            array(
                                                                'class' => 'delete',
                                                                'confirm'=>Yii::t('userModule','Are you sure?')
                                                            )
                                                        );?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
        <div id="banners" class="tab-pane">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?=CHtml::link("+ ".Yii::t("bannersModule","Add banner"),Yii::app()->createUrl('/banners/user/banners/create'));?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="banners_messages">

            </div>
            <?php if(sizeof($model->banners)>0):?>
                <?php foreach($model->banners as $banner):?>
                    <div class="panel panel-default user-service" id="user_banner_<?=$banner->id;?>">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <?=CHtml::link($banner->name,$banner->getPrivateUrl(),array('class' => 'banner-name-link'));?>
                                    <?=CHtml::link(CHtml::image($banner->getImageUrl(),$banner->name,array('class' => 'banner-preview')),$banner->getImageUrl(), array('class' => 'fancybox banner-preview-link'));?>
                                </div>
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="banner-row-margin-container">
                                                <?=CHtml::ajaxLink(
                                                    Banners::$publishes[$banner->published],
                                                    array(
                                                        '/banners/user/banners/publish',
                                                        'id'=>$banner->id
                                                    ),
                                                    array(
                                                        'type'=>'POST',
                                                        'dataType'=> 'json',
                                                        'success'=>'js:function(data){
                                                                console.log(data);
                                                                if(data.status == "success"){
                                                                    var banner_container = $("#user_banner_'.$banner->id.'");
                                                                    banner_container.find(".banner-publish").text(data.published);
                                                                }
                                                                $("#banners_messages").append(data.html);
                                                            }',
                                                    ),
                                                    array(
                                                        'confirm'=>Yii::t('bannersModule','Are you sure you want to publish the banner "{name}"?', array("{name}" => $banner->name)),
                                                        'class' => 'banner-publish',
                                                        'title' => Yii::t('bannersModule', 'Change published status'),
                                                        'id' => 'banner_publish_link_'.$banner->id
                                                    )
                                                );?>
                                                |
                                                <span class="banner-approve"><?=Banners::$approves[$banner->approve];?></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="banner-row-margin-container">
                                                <span class="banner-paid-date">
                                                    <?php if(strtotime($banner->paid_end_date)>time()):?>
                                                        <?=Yii::t('bannersModule',"End date");?>: <?=$banner->publicDate;?>
                                                    <?php endif;?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <?php if($banner->approve == '1'):?>
                                                <div class="banner-row-margin-container">
                                                    <?=CHtml::ajaxLink(
                                                        Yii::t("bannersModule","Extended for 30 days")." ( ".$banner->getPaymentAmount(30)." )",
                                                        array(
                                                            '/banners/user/banners/pay',
                                                            'id'=>$banner->id,
                                                        ),
                                                        array(
                                                            'type'=>'POST',
                                                            'dataType'=> 'json',
                                                            'success'=>'js:function(data){
                                                                console.log(data);
                                                                if(data.status == "success"){
                                                                    var banner_container = $("#user_banner_'.$banner->id.'");
                                                                    console.log(banner_container);
                                                                    console.log(banner_container.find(".banner-paid-date"));
                                                                    console.log(banner_container.find(".banner-publish"));
                                                                    banner_container.find(".banner-paid-date").text(data.public_date);
                                                                    banner_container.find(".banner-publish").text(data.publish);
                                                                }
                                                                $("#banners_messages").append(data.html);
                                                            }',
                                                        ),
                                                        array(
                                                            'class' => 'btn btn-success',
                                                            'confirm'=>Yii::t('bannersModule','Are you sure you want to extend the banner "{name}" to 30 days? ( {price} ) ', array("{name}" => $banner->name, '{price}' => $banner->getPaymentAmount(30)))
                                                        )
                                                    );?>
                                                </div>
                                            <?php else:?>
                                                <span><?=Yii::t('bannersModule','You can pay a banner after it is approved by a moderator.');?></span>
                                            <?php endif;?>

                                        </div>
                                    </div>
                                    <?php /*<hr class="hr">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                                <strong><?=Yii::t('dealsModule',"Clicks");?>: </strong>
                                                <span><?=Yii::t('dealsModule',"Today");?>: <strong><?=$banner->getTodayClicks();?></strong></span> |
                                                <span><?=Yii::t('dealsModule',"Yesterday");?>: <strong><?=$banner->getYesterdayClicks();?></strong></span> |
                                                <span><?=Yii::t('dealsModule',"Last month");?>: <strong><?=$banner->getLastMonthClicks();?></strong></span>
                                            </p>;
                                        </div>
                                    </div>*/?>
                                </div>
                                <div class="col-lg-1">
                                    <div class="bottom-container">
                                        <div>
                                            <div class="edit-wrap">
                                                <a href="#" class="edit b-spr"></a>
                                                <ul class="dropdown-menu">
                                                    <li><?=CHtml::link(Yii::t('ses','Edit'),Yii::app()->createUrl('/banners/user/banners/update', array('id'=>$banner->id)));?></li>
                                                    <!--<li><a href="#">Скрыть</a></li>-->
                                                    <li>
                                                        <?=CHtml::ajaxLink(
                                                            Yii::t('ses','Delete'),
                                                            array(
                                                                '/banners/user/banners/delete',
                                                                'id'=>$banner->id,
                                                            ),
                                                            array(
                                                                'type'=>'POST',
                                                                'dataType'=> 'json',
                                                                'success'=>'js:function(data){
                                                                if(data.status == "success"){
                                                                    $("#user_banner_'.$banner->id.'").remove();
                                                                }
                                                                $(".messages").append(data.html);
                                                            }',
                                                            ),
                                                            array(
                                                                'class' => 'delete',
                                                                'confirm'=>Yii::t('userModule','Are you sure?')
                                                            )
                                                        );?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</section>


