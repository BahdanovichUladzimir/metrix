<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.03.2015
 * @var $data Deals
 */
$deal = $data;
;?>

<div class="panel panel-default">
    <div class="panel-body service-link cf">
        <div class="service-info">
            <a href="<?=$deal->getPublicUrl();?>"><?=$deal->name;?></a>
            <strong><?=$deal->user->getCommentUserName();?></strong>
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
            </div>
        </div>
        <?php
        if(Yii::app()->user->getId() == $deal->user_id || Yii::app()->getModule('user')->isAdmin()){
            $images = $deal->dealsImages;
        }
        else{
            $images = $deal->frontendDealsImages;
        }
        ;?>
        <?php if(sizeof($images)>0):?>
            <div class="gallery">
                <?php $counter=0;?>
                <?php foreach($images as $image):?>
                    <?php if($counter<3):?>
                        <div data-preview="<?=$image->preview;?>">
                            <?php echo CHtml::image(Yii::app()->request->baseUrl."/images/lazy128.png",$deal->name, array("class" => 'lazy', "data-original" => $image->getSmallThumbUrl()));?>
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
        <?php $this->widget('modules.deals.widgets.dealRating.DealRatingWidget', array(
            'deal'=>$deal,
            'template'=> 'category'
        ));?>
    </div>
</div>