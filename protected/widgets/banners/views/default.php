<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var int $widgetId
 * @var Banners[] $banners
 * @var $form TbActiveForm
 */
;?>
<div id="bannersWidget_<?=$widgetId;?>">
    <?php foreach($banners as $banner):?>
        <div class="banner-container panel" id="banner_container_<?=$banner->id;?>">
            <?=CHtml::link(CHtml::image($banner->getImageUrl(),$banner->name, array("class"=>"banner-image")),Yii::app()->createUrl("/banners/frontend/banners/banner", array("id" => $banner->id)), array('target' => "_blank"));?>
        </div>
    <?php endforeach;?>
</div>

