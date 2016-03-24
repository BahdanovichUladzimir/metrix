<?php
/**
 * @var $profile Profile
 * @var $model User
 * @var $deal Deals
 */
$this->title = $model->username.", ".$model->getCommentUserName()." - all4holidays";
$this->breadcrumbs=array(
    //Yii::t('userModule',"Users")=>'/users',
    CHtml::encode($model->username),
);
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');

?>
<script>
    $(document).ready(function(){
        $('.fancybox-public-avatar').click(function(){
            var avatar = $(this);
            $.fancybox({
                'href': avatar.data('href')
            });
        });
    });
</script>
<section>
    <h1 class="title section-title h1"><?php echo Yii::t('userModule','User profile'); ?></h1>
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
    <div class="panel panel-default">
        <div class="panel-body cf">
            <div class="service-info inner">
                <img src="<?=$profile->getMediumThumbUrl();?>" data-href="<?=$profile->getLargeThumbUrl();?>" class="img-left avatar fancybox-public-avatar" alt="<?=$model->username;?>" />
                <h1 class="title section-title"><?php echo CHtml::encode($model->username);?></h1>
                <?php if($profile->city):?>
                    <span class="location b-spr"><?=CHtml::encode($profile->city->name);?>, <?=CHtml::encode($profile->city->country->name);?></span>
                <?php endif;?>
                <p><?=CHtml::encode($profile->description);?></p>
                <div class="bottom-container">
                    <?php if(strlen($profile->phone)>0):?>
                        <div class="phone b-spr">
                            <span><?=Yii::t('userModule','Phone');?></span>
                            <span><?=CHtml::link(DealCategoriesParams::getPublicPhoneNumber($profile->phone),"tel:".$profile->phone);?></span>
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
            <?php if(sizeof($model->publicDeals)>0):?>
                <li class="active"><a href="#offers" data-toggle="tab"><?=Yii::t('dealsModule','My deals');?></a></li>
            <?php endif;?>
            <!--<li><a href="#notices" data-toggle="tab">Мои объявления</a></li>-->
        </ul>
    </div>
    <div class="tab-content">
        <?php if(sizeof($model->publicDeals)>0):?>
            <div id="offers" class="tab-pane active">
                <div class="row">
                    <?php foreach($model->publicDeals as $deal):?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-body service-link recommended cf">
                                    <?php
                                    if(Yii::app()->user->getId() == $deal->user_id || Yii::app()->getModule('user')->isAdmin()){
                                        $images = $deal->dealsImages;
                                    }
                                    else{
                                        $images = $deal->frontendDealsImages;
                                    }
                                    ;?>
                                    <div class="gallery">
                                        <?php if(sizeof($images)>0):?>
                                            <div>
                                                <?php echo CHtml::image($images[0]->getSmallThumbUrl(),$deal->name);?>
                                            </div>
                                        <?php else:?>
                                            <div>
                                                <img src="/images/photos_img.png" alt="" />
                                            </div>
                                        <?php endif;?>
                                    </div>

                                    <div class="service-info">
                                        <a href="<?=$deal->getPublicUrl();?>"><?=$deal->name;?></a>
                                        <?/*=$deal->getDealAuthorLink();*/?>
                                        <p>
                                            <?=Deals::cropText($deal->intro, 150);?>
                                            <?/*=CHtml::link(Yii::t('dealsModule', 'Read more ->'),$deal->getPublicUrl());*/?>

                                        </p>
                                        <div class="bottom-container user-deal">
                                            <div>
                                                <?php $this->widget('modules.deals.widgets.addToFavorites.AddToFavoritesWidget', array(
                                                    'deal'=>$deal,
                                                ));?>
                                                <a href="<?=$deal->getPublicUrl();?>" class="more btn"><span class="a-spr"><?=Yii::t("dealsModule","More");?></span></a>
                                            </div>
                                            <div class="price">
                                                <?php $this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
                                                    'deal'=>$deal,
                                                ));?>
                                            </div>
                                            <?php /*<div>
                                <span>Рейтинг на сайте</span>
                                <div class="rating">
                                    <span>8</span>
                                    <div class="rating-form static">
                                        <span data-num="1" class="active"></span>
                                        <span data-num="2" data-fix="1"></span>
                                        <span data-num="3" data-fix="1"></span>
                                        <span data-num="4" data-fix="1"></span>
                                        <span data-num="5" data-fix="1"></span>
                                    </div>
                                </div>
                            </div> */;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>




                <?php /*foreach($model->publicDeals as $deal):*/?><!--
                    <div class="panel panel-default user-service" id="user_deal_<?/*=$deal->id;*/?>">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="bottom-container">
                                        <div><?/*=CHtml::link($deal->name,$deal->getPublicUrl());*/?></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="bottom-container">
                                        <div class="price">
                                            <?php /*$this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
                                                'deal'=>$deal,
                                            ));*/?>
                                        </div>
                                        <div class="deal-rating-widget-container">
                                            <?php /*$this->widget('modules.deals.widgets.dealRating.DealRatingWidget', array(
                                                'deal'=>$deal,
                                            ));*/?>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                --><?php /*endforeach;*/?>


        </div>
        <?php endif;?>
    </div>
</section>


