<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 31.03.2015
 * @var string $moduleId
 * @var string $controllerId
 * @var string $actionId
 */
/*echo '<pre>';
     var_dump($moduleId);
     var_dump($controllerId);
     var_dump($actionId);
echo '</pre>';*/
;?>
<?php
/**
 * @var $this FrontendController
 * @var string $content
 */
if(is_null(Yii::app()->user->getId())){
    $favorites = CookiesFavorites::model()->count('cookie_id=:cookie_id', array(':cookie_id' => Yii::app()->request->cookies['favoritesId']->value));
}
else{
    $favorites = UsersFavorites::model()->count('user_id=:user_id', array(':user_id' => Yii::app()->user->getId()));
}
;?>

<div class="main-menu a">
    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
            <span class="sr-only"><?=Yii::t('core','Toggle navigation');?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <?=CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/logo-min.png',Yii::app()->name,array('class' => 'logo-min-mob')), Yii::app()->getHomeUrl());?>
        <nav class="user-nav mob">
            <ul class="nav navbar-nav navbar-right cf">
                <li>
                    <?=CHtml::link(($favorites>0) ? "<span class='notif'>".$favorites."</span>" : '' ,Yii::app()->createUrl('/deals/user/favorites/index'), array('class' => 'favorites-icon icon b-spr','rel'=>'nofollow'));?>
                </li>
                <li>
                    <?php $this->widget('widgets.citySelect.CitySelectWidget');?>
                </li>
                <?php $this->widget('widgets.userMenu.UserMenuWidget');?>
                <?php if(!Yii::app()->user->isGuest):?>
                    <li>
                        <?php if(is_null($this->currentCategory)):?>
                            <?=CHtml::link(Yii::t("dealsModule","Deal"),Yii::app()->createUrl('/deals/user/userDeals/create'), array('class' => 'btn btn-primary menu-btn a-spr'));?>
                        <?php else:?>
                            <?=CHtml::link(Yii::t("dealsModule","Deal"),Yii::app()->createUrl('/deals/user/userDeals/create', array('currentCategory'=> $this->currentCategory)), array('class' => 'btn btn-primary menu-btn a-spr'));?>
                        <?php endif;?>
                    </li>
                <?php else:?>
                    <li>
                        <?=CHtml::link('',Yii::app()->getModule('user')->loginUrl, array('class' => 'user-icon icon b-spr'));?>
                    </li>
                <?php endif;?>

            </ul>
        </nav>
        <div class="row">
            <div class="collapse navbar-collapse" id="main-menu">
                <div class="menu-wrap">
                    <div class="search mob">
                        <?php $this->widget(
                            'modules.deals.widgets.searchString.SearchStringWidget',
                            array(
                                'view'=>'mobile',
                                'query' => (isset($this->query) && !is_null($this->query)) ? $this->query : NULL,
                            )
                        )
                        ;?>
                    </div>
                    <?php if($this->beginCache('frontend_menu_'.$this->userCityId.'_'.Yii::app()->language, array('duration' => 60*60*24))):?>
                        <?=CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/logo-min.png',Yii::app()->name,array('class' => 'logo-min')), Yii::app()->getHomeUrl());?>
                        <nav>
                            <ul class="nav navbar-nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Свадьба</a>
                                    <ul class="dropdown-menu columns">
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(1,$this->userCityKey);?>">Платья</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(14,$this->userCityKey);?>">Мужские костюмы</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(114,$this->userCityKey);?>">Свадебное белье</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(13,$this->userCityKey);?>">Обувь</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(15,$this->userCityKey);?>">Аксессуары/ украшения</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(8,$this->userCityKey);?>">Красота и здоровье тела</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(2,$this->userCityKey);?>">Обручальные кольца</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(4,$this->userCityKey);?>">Флористика</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(130,$this->userCityKey);?>">Пригласительные и другое</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(33,$this->userCityKey);?>">Хореография</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(124,$this->userCityKey);?>">Аренда отелей, коттеджей и ресторанов</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(139,$this->userCityKey);?>">Оформление свадебного торжества</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(5,$this->userCityKey);?>">Застолье и фуршет</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(34,$this->userCityKey);?>">Ведущие</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(35,$this->userCityKey);?>">DJ</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(7,$this->userCityKey);?>">Фото и видео</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(322,$this->userCityKey);?>">Координаторы мероприятий</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(6,$this->userCityKey);?>">Развлечение гостей</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(3,$this->userCityKey);?>">Транспорт</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(358,$this->userCityKey);?>">Свадебные агентства</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(200,$this->userCityKey);?>">Церемония и традиции</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(201,$this->userCityKey);?>">Журналы и выставки</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(129,$this->userCityKey);?>">Подарки</a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Вечеринка</a>
                                    <ul class="dropdown-menu columns">
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(139,$this->userCityKey);?>">Оформление торжества</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(34,$this->userCityKey);?>">Ведущие</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(35,$this->userCityKey);?>">DJ</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(322,$this->userCityKey);?>">Координаторы мероприятий</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(7,$this->userCityKey);?>">Фото и видео</a></li>


                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(5,$this->userCityKey);?>">Застолье и фуршет</a></li>
                                                <?php /*отдых и городские мероприятия*/?>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(124,$this->userCityKey);?>">Аренда отелей, коттеджей и ресторанов</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(199,$this->userCityKey);?>">Путешествия</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(60,$this->userCityKey);?>">Вечерние платья</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(14,$this->userCityKey);?>">Мужские костюмы</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(15,$this->userCityKey);?>">Аксессуары/ украшения</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(13,$this->userCityKey);?>">Обувь</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(30,$this->userCityKey);?>">Стилисты-визажисты</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(32,$this->userCityKey);?>">Маникюр</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(229,$this->userCityKey);?>">Парикмахеры</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(33,$this->userCityKey);?>">Хореография</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(3,$this->userCityKey);?>">Транспорт</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(129,$this->userCityKey);?>">Подарки</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Детский праздник</a>
                                    <ul class="dropdown-menu columns">
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(34,$this->userCityKey);?>">Ведущие</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(35,$this->userCityKey);?>">DJ</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(322,$this->userCityKey);?>">Координаторы мероприятий</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(7,$this->userCityKey);?>">Фото и видео</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(79,$this->userCityKey);?>">Аниматоры</a></li>

                                            </ul>
                                        </li>
                                        <li>
                                            <ul>

                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(88,$this->userCityKey);?>">Костюмы для мальчиков</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(162,$this->userCityKey);?>">Платья для девочек</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(316,$this->userCityKey);?>">Прокат детских нарядов</a></li>


                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(5,$this->userCityKey);?>">Застолье и фуршет</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(319,$this->userCityKey);?>">Детские кафе</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(326,$this->userCityKey);?>">Базы отдыха</a></li>
                                                <li><a href="<?=DealsCategories::getPublicUrlByCatId(139,$this->userCityKey);?>">Оформление торжества</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                        <?php $this->endCache();?>
                    <?php endif;?>
                </div>
                <div class="search-toggle">
                    <?php $this->widget(
                        'modules.deals.widgets.searchString.SearchStringWidget',
                        array(
                            'view'=>'main_menu',
                            'query' => (isset($this->query) && !is_null($this->query)) ? $this->query : NULL,
                        )
                    )
                    ;?>
                </div>
                <nav>
                    <?php if(Yii::app()->user->isGuest):?>
                    <ul class="nav navbar-nav login-nav">
                        <li><a href="<?=Yii::app()->createUrl('/user/registration/authorization');?>"><?=Yii::t('userModule','Login');?></a></li>
                        <li><a href="<?=Yii::app()->createUrl('/user/registration/authorization');?>"><?=Yii::t('userModule','Registration');?></a></li>
                    </ul>
                    <?php endif;?>
                </nav>
                <nav class="user-nav desc">
                    <ul class="nav navbar-nav navbar-right cf">
                        <li class="search-hdn"><a href="#" class="search-icon icon b-spr"></a></li>
                        <li>
                            <?=CHtml::link(($favorites>0) ? "<span class='notif'>".$favorites."</span>" : '' ,Yii::app()->createUrl('/deals/user/favorites/index'), array('class' => 'favorites-icon icon b-spr','rel'=>'nofollow'));?>
                        </li>
                        <?php $this->widget('widgets.citySelect.CitySelectWidget');?>
                        <?php $this->widget('widgets.userMenu.UserMenuWidget');?>
                        <?php if(!Yii::app()->user->isGuest):?>
                            <li>
                                <?php if(is_null($this->currentCategory)):?>
                                    <?=CHtml::link(Yii::t("dealsModule","Deal"),Yii::app()->createUrl('/deals/user/userDeals/create'), array('class' => 'btn btn-primary menu-btn a-spr'));?>
                                <?php else:?>
                                    <?=CHtml::link(Yii::t("dealsModule","Deal"),Yii::app()->createUrl('/deals/user/userDeals/create', array('currentCategory'=> $this->currentCategory)), array('class' => 'btn btn-primary menu-btn a-spr'));?>
                                <?php endif;?>
                            </li>
                        <?php endif;?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
