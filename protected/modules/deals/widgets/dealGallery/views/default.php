<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.03.2015
 * @var $deal Deals
 * @var int $photosLimit
 * @var int $videosLimit
 * @var array $userVideos
 * @var DealsImages[] $images
 * @var DealsVideos[] $videos
 * @var DealLinks[] $links
 */
$sizeOfImages = sizeof($images);
$sizeOfVideos = sizeof($videos);
$sizeOfUserVideos = sizeof($userVideos);
$sizeOfLinks = sizeof($links);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.lazyload.min.js');
;?>
<script>
    $(document).ready(function(){
        var imgs = $("img.lazy");
        var invisible_imgs = $(".unvisible img.lazy");
        //imgs.trigger("onPageLoad");
        $('.show-all').click(function(){
            invisible_imgs.trigger("onShowAllImgs");
        });
        $('#photo_tab_li, #videos_tab_li').click(function(){
            imgs.trigger("onChangeTab");
        });
        imgs.lazyload({
            failure_limit: 40
        });
        imgs.lazyload({
            failure_limit: 40,
            event:"onChangeTab"
        });
        invisible_imgs.lazyload({
            failure_limit: 40,
            event : "onShowAllImgs"
        });

        $('.fancybox-video').fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            arrows : false,
            helpers : {
                media : {}
            }
        });
        $(".fancybox").fancybox();
        $('.fancybox-video-vimeo')
            .attr('rel', 'media-gallery')
            .fancybox({
                openEffect : 'none',
                closeEffect : 'none',
                prevEffect : 'none',
                nextEffect : 'none',

                arrows : false,
                helpers : {
                    media : {},
                    buttons : {}
                }
            });
    });

</script>
<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-tabs navbar-right">
            <?php if($sizeOfImages>0):?>
                <li class="active" id="photo_tab_li"><a href="#photo" data-toggle="tab"><?=Yii::t("dealsModule", "Photo");?></a></li>
            <?php endif;?>
            <?php if($sizeOfUserVideos>0):?>
                <li class="<?=($sizeOfImages>0) ? "" : "active";?>" id="videos_tab_li"><a href="#video" class="<?=($sizeOfImages>0) ? "" : "active";?>" data-toggle="tab"><?=Yii::t("dealsModule", "Video");?></a></li>
            <?php endif;?>
        </ul>
        <h2 class="title section-title"><?=Yii::t("dealsModule","Gallery");?></h2>
        <div class="tab-content">
            <?php if($sizeOfImages>0):?>
                <div id="photo" class="tab-pane active">
                    <div class="gallery cf">
                        <?php $counter = 0;?>
                        <?php foreach($images as $image):?>
                            <?php if($counter == 4):?>
                                <div class="unvisible" id="unvisible-photo">
                            <?php endif;?>
                            <a href="<?=$image->getImageUrl();?>" class="fancybox" title="<?=$image->description;?>" rel="deal_<?=$deal->id;?>_images_group">
                                <!--<img class="lazy" src="<?/*=$image->getMediumThumbUrl();*/?>" alt="<?/*=$image->name;*/?>" />-->
                                <img class="lazy" src="<?=Yii::app()->request->baseUrl."/images/lazy500x400.png";?>" data-original="<?=$image->getMediumThumbUrl();?>" alt="<?=$image->name;?>" />
                            </a>
                            <?php $counter++;?>
                        <?php endforeach;?>
                    <?php if($counter>4):?>
                        </div>
                    <?php endif;?>
                    </div>
                    <?php if($counter>4):?>
                        <a href="#" class="show-all" data-name="photo"><?=Yii::t("dealsModule","Show all photos");?></a>
                    <?php endif;?>
                    <?php unset($counter);?>
                </div>
            <?php endif;?>
            <?php if($sizeOfUserVideos>0):?>
                <div id="video" class="tab-pane <?=($sizeOfImages>0) ? "" : "active";?>">
                    <div class="gallery cf">
                        <?php $counter = 0;?>
                        <?php foreach($userVideos as $video):?>
                            <?php if($counter == 4):?>
                                <div class="unvisible" id="unvisible-video">
                            <?php endif;?>
                                <?php if($video['type'] == 'youtube'):?>
                                    <a href="<?=Yii::app()->request->baseUrl."/js/uppod.swf?file=".$video['url'];?>&https=1" class="fancybox-video" data-type="<?=$video['type'];?>" rel="deal_<?=$deal->id;?>_videos_group">
                                        <img class="lazy fancy-video" src="<?=Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL");?>" data-original="<?=$video['previewUrl'];?>" alt="<?=$video['url'];?>" />
                                    </a>
                                <?php elseif($video['type'] == 'vimeo'):?>
                                    <a href='<?=$video['url'];?>' class="fancybox-video-vimeo fancybox.iframe">
                                        <img class="lazy fancy-video" src="<?=Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL");?>" data-original="<?=$video['previewUrl'];?>" alt="<?=$video['url'];?>" />
                                    </a>
                                <?php else:?>
                                    <a href="<?=Yii::app()->request->baseUrl."/js/uppod.swf?file=".$video['url'];?>" class="fancybox-video" rel="deal_<?=$deal->id;?>_videos_group">
                                        <img class="lazy fancy-video" src="<?=Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL");?>" data-original="<?=$video['previewUrl'];?>" alt="<?=$video['url'];?>" />
                                    </a>
                                <?php endif;?>
                            <?php $counter++;?>
                        <?php endforeach;?>

                        <?php if($counter>4):?>
                            </div>
                        <?php endif;?>
                    </div>
                    <?php if($counter>4):?>
                        <a href="#" class="show-all" data-name="video"><?=Yii::t("dealsModule","Show all videos");?></a>
                    <?php endif;?>
                    <?php unset($counter);?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>