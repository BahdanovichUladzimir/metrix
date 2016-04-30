<?php
/**
 * Created by PhpStorm.
 * User: Mikhail
 * Date: 15.06.2015
 * Time: 19:00
 * @var FrontendController $this
 */

?>
<?php /*if($this->beginCache('frontend_footer_'.$this->userCityId.'_'.Yii::app()->language, array('duration' => 60*60*24))):*/?>
    <footer>
        <div class="footer-nav">
            <div class="container">
                <nav class="row">
                    <ul class="nav navbar-nav">
                        <li class="col-md-2 col-sm-2">&nbsp;<?=DealsCategories::getPublicLinkByCatId(1,$this->userCityKey, array('rel' => 'nofollow'));?>
                            <ul class="nav">
                                <!--<li><?/*=DealsCategories::getPublicLinkByCatId(5,$this->userCityKey, array('rel' => 'nofollow'));*/?></li>
                                <li><?/*=DealsCategories::getPublicLinkByCatId(8,$this->userCityKey, array('rel' => 'nofollow'));*/?></li>
                                <li><?/*=DealsCategories::getPublicLinkByCatId(14,$this->userCityKey, array('rel' => 'nofollow'));*/?></li>-->
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<?=DealsCategories::getPublicLinkByCatId(2,$this->userCityKey, array('rel' => 'nofollow'));?>
                            <ul class="nav">
                                <li><?=DealsCategories::getPublicLinkByCatId(5,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(8,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(14,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(10,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(12,$this->userCityKey, array('rel' => 'nofollow'));?></li>

                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<?=DealsCategories::getPublicLinkByCatId(2,$this->userCityKey, array('rel' => 'nofollow'));?>
                            <ul class="nav">
                                <li><?=DealsCategories::getPublicLinkByCatId(13,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(18,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(9,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(16,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(17,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(6,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<?=DealsCategories::getPublicLinkByCatId(3,$this->userCityKey, array('rel' => 'nofollow'));?>
                            <ul class="nav">
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<?=DealsCategories::getPublicLinkByCatId(4,$this->userCityKey, array('rel' => 'nofollow'));?>
                            <ul class="nav">
                                <li><?=DealsCategories::getPublicLinkByCatId(22,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(23,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(24,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(26,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<?=DealsCategories::getPublicLinkByCatId(4,$this->userCityKey, array('rel' => 'nofollow'));?>
                            <ul class="nav">
                                <li><?=DealsCategories::getPublicLinkByCatId(27,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(28,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(29,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                                <li><?=DealsCategories::getPublicLinkByCatId(41,$this->userCityKey, array('rel' => 'nofollow'));?></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="footer-nav-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 col-xs-12">
                        <ul class="nav navbar-nav">
                            <li><a href="<?=Yii::app()->createUrl('site/news');?>">Новости</a></li>
                            <li><a href="<?=Yii::app()->createUrl('site/articles');?>">Статьи</a></li>
                            <!--<li><a rel="nofollow" href="<?/*=Yii::app()->cms->createUrl('paid_services');*/?>">Пользовательское соглашение</a></li>-->
                            <!--<li><a rel="nofollow" href="<?/*=Yii::app()->cms->createUrl('instruction');*/?>">Инструкция</a></li>-->
                            <?php /*<li><a rel="nofollow" href="<?=Yii::app()->cms->createUrl('faq');?>">FAQ </a></li>*/?>
                            <li><a rel="nofollow" href="<?=Yii::app()->createUrl('feedback/feedback/create');?>">Обратная связь</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12">
                        <div class="webmoney">
                            <a href="http://www.megastock.ru" target="_blank" rel="nofollow"><span class="wm-img1"></span></a>
                            <a href="http://passport.webmoney.ru/asp/certView.asp?wmid=382375517265" target="_blank" rel="nofollow"><span class="wm-img2"></span></a>
                        </div>
                        <ul class="nav navbar-right navbar-nav socials">
                            <?php /*<li><a href="#" class="skype"></a></li>*/?>
                            <li><a target="_blank" rel="nofollow" href="https://twitter.com" class="twitter"></a></li>
                            <li><a target="_blank" rel="nofollow" href="https://vk.com" class="vk"></a></li>
                            <li><a target="_blank" rel="nofollow" href="https://facebook.com" class="facebook"></a></li>
                            <!--<li><a target="_blank" rel="nofollow" href="https://plus.google.com/+All4holidays_com/posts" class="gplus"></a></li>-->
                            <li><div class="g-plusone" data-size="medium"></div></li>
                            <?php /*<li><a target="_blank" rel="nofollow" href="https://instagram.com/allforholidays" class="instagram"></a></li>*/?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <span>&copy; <?=date('Y');?> <?=Yii::t('layout','Republic of Belarus');?>, <?=Yii::t('layout','Minsk');?> | <?=Yii::t('layout','All rights reserved');?> | METRIX.BY</span>
            </div>

        </div>
        <?php /*Yii::app()->cms->block('metrika'); */?>
    </footer>
    <?php /*$this->endCache();*/?><!--
--><?php /*endif;*/?>
<script src="https://apis.google.com/js/platform.js" async defer>
    {lang: 'ru'}
</script>

