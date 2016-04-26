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
        $(".fancybox").fancybox();
    });

</script>
<?php if($sizeOfImages>0):?>
    <img class="balloon-image" src="<?=$images[0]->getSmallThumbUrl();?>" alt="<?=$images[0]->name;?>" />
<?php endif;?>
           
