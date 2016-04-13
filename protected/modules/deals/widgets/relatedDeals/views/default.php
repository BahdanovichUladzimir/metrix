<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var $deal Deals
 * @var Deals[] $relatedDeals
 */
;?>
<h3 class="title section-title h3"><?=Yii::t('dealsModule',"You can come in handy");?>:</h3>
<div class="row">
    <?php foreach($relatedDeals as $deal):?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body service-link recommended cf">
                        <?php
                        if(Yii::app()->user->getId() == $deal->user_id || Yii::app()->getModule('user')->isModerator()){
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
                        <div class="bottom-container">
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
