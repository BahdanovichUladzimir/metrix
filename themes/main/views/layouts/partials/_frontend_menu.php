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
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=DealsCategories::model()->findByPk(1)->name;?></a>
                                    <ul class="dropdown-menu columns">
                                        <!--<li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(1,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(8,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(124,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(34,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(3,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>-->
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=DealsCategories::model()->findByPk(2)->name;?></a>
                                    <ul class="dropdown-menu columns">
                                        <li>
                                            <ul>
                                                <li><?=DealsCategories::getPublicLinkByCatId(5,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(8,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(14,$this->userCityKey);?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?=DealsCategories::getPublicLinkByCatId(10,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(12,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(13,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(18,$this->userCityKey);?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?=DealsCategories::getPublicLinkByCatId(9,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(16,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(17,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(6,$this->userCityKey);?></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=DealsCategories::model()->findByPk(3)->name;?></a>
                                    <ul class="dropdown-menu columns">
                                        <!--<li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(34,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(88,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(5,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>-->
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=DealsCategories::model()->findByPk(4)->name;?></a>
                                    <ul class="dropdown-menu columns">
                                        <li>
                                            <ul>
                                                <li><?=DealsCategories::getPublicLinkByCatId(22,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(23,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(24,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(26,$this->userCityKey);?></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <ul>
                                                <li><?=DealsCategories::getPublicLinkByCatId(27,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(28,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(29,$this->userCityKey);?></li>
                                                <li><?=DealsCategories::getPublicLinkByCatId(41,$this->userCityKey);?></li>
                                            </ul>
                                        </li>
                                        <!--<li>
                                            <ul>
                                                <li><?/*=DealsCategories::getPublicLinkByCatId(5,$this->userCityKey);*/?></li>
                                            </ul>
                                        </li>-->
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
