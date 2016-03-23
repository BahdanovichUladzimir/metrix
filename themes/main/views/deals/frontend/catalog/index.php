<?php
/**
 * @var $this CatalogController
 * @var array $categories
 * @var $category DealsCategories
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/owl.carousel.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('owl_carousel_init',"
$('.slider').owlCarousel({
		items:1,
		margin:0,
		dots: false,
		nav: true,
		loop: true
	});
");
?>
<h1 class="main-title a b">
    <span class="head">Всё для организации</span>
    <span>Свадьбы<span> & </span>Праздника</span>
</h1>
<div class="slider">
    <div>
        <div class="row">
            <?php $counter = 1;?>
            <?php foreach($categories as $category):?>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <a href="<?=$category->getPublicUrl($this->userCityKey);?>" class="main-link thumbnail">
                        <div class="image a">
                            <span><span class="a"><?=Yii::t("dealsModule","Move on");?></span></span>
                            <img src="<?=$category->getMediumThumbUrl();?>" alt="<?=$category->name;?>" />
                        </div>
                        <div class="caption">
                            <h2 class="title h2"><?=$category->name;?></h2>
                        </div>
                    </a>
                </div>
                <?php if($counter%6 == 0 && $counter !== sizeof($categories)):?>
        </div>
    </div>
    <div>
        <div class="row">

        <?php endif;?>
                <?php $counter++;?>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!--<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php /*Yii::app()->cms->block('left_text'); */?>
        <a href="<?/*= Yii::app()->createUrl('user/login');*/?>" class="btn btn-big btn-success">Разместиться на сайте</a>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php /*Yii::app()->cms->block('right_text'); */?>
        <a href="<?/*= Yii::app()->createUrl('user/login');*/?>" class="btn btn-big btn-success">Разместиться на сайте</a>
    </div>
</div>-->

