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
                    <!--<ul class="nav navbar-nav">
                        <li class="col-md-2 col-sm-2">&nbsp;<a href="#">Свадьба</a>
                            <ul class="nav">
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(1,$this->userCityKey);*/?>">Свадебные платья</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(229,$this->userCityKey);*/?>">Прически на свадьбу</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(30,$this->userCityKey);*/?>">Макияж на дому</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(26,$this->userCityKey);*/?>">Свадебные букеты</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(2,$this->userCityKey);*/?>">Обручальные кольца</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(116,$this->userCityKey);*/?>">Подвязка невесты</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<a href="#">Банкет</a>
                            <ul class="nav">
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(14,$this->userCityKey);*/?>">Костюм жениха</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(110,$this->userCityKey);*/?>">Мужские галстуки</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(193,$this->userCityKey);*/?>">Мужские туфли</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(185,$this->userCityKey);*/?>">Мужское белье</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(73,$this->userCityKey);*/?>">Бутоньерка жениха</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(111,$this->userCityKey);*/?>">Запонки</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<a href="#">Транспорт</a>
                            <ul class="nav">
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(40,$this->userCityKey);*/?>">Фотографы</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(157,$this->userCityKey);*/?>">Видеооператоры</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(42,$this->userCityKey);*/?>">Свадебный фотоальбом</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(155,$this->userCityKey);*/?>">Фотосессия Love story</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(34,$this->userCityKey);*/?>">Тамада</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<a href="#">Транспорт</a>
                            <ul class="nav">
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(139,$this->userCityKey);*/?>">Оформление свадьбы</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(130,$this->userCityKey);*/?>">Свадебный скрапбукинг</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(74,$this->userCityKey);*/?>">Украшения на машину</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(280,$this->userCityKey);*/?>">Свадебный кортеж</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<a href="#">Транспорт</a>
                            <ul class="nav">
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(33,$this->userCityKey);*/?>">Первый танец</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(36,$this->userCityKey);*/?>">Музыканты</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(255,$this->userCityKey);*/?>">Первая брачная ночь</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(288,$this->userCityKey);*/?>">Медовый месяц</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(39,$this->userCityKey);*/?>">Свадебный салют</a></li>
                                <li><a rel="nofollow" href="<?/*=DealsCategories::getPublicUrlByCatId(35,$this->userCityKey);*/?>">Выездная регистрация</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(287,$this->userCityKey);*/?>">Свадебные голуби</a></li>
                            </ul>
                        </li>
                        <li class="col-md-2 col-sm-2">&nbsp;<a href="#">Транспорт</a>
                            <ul class="nav">
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(75,$this->userCityKey);*/?>">Кейтеринг</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(358,$this->userCityKey);*/?>">Свадебные агентства</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(124,$this->userCityKey);*/?>">Аренда коттеджа</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(292,$this->userCityKey);*/?>">Выездная регистрация</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(129,$this->userCityKey);*/?>">Подарки</a></li>
                                <li><a rel="nofollow"  href="<?/*=DealsCategories::getPublicUrlByCatId(39,$this->userCityKey);*/?>">Праздничный салют</a></li>
                            </ul>
                        </li>
                    </ul>-->
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
                            <li><a rel="nofollow" href="<?=Yii::app()->cms->createUrl('paid_services');?>">Пользовательское соглашение</a></li>
                            <li><a rel="nofollow" href="<?=Yii::app()->cms->createUrl('instruction');?>">Инструкция</a></li>
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

