<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 15.03.2015
 * @var array $cities
 * @var int $widgetId
 * @var int $userCityId
 * @var int $userCityKey
 * @var string $uri
 * @var $city Cities
 * @var int|null $moduleId
 * @var int $controllerId
 * @var int $actionId
 * @var DealsCategories|null $currentCategory
 */
;?>
<?php $moduleId = (isset(Yii::app()->controller->module)) ? Yii::app()->controller->module->getId() : NULL;?>
<?php $controllerId = Yii::app()->controller->id;?>
<?php $actionId = Yii::app()->controller->action->id;?>
<li id="city_select_widget_<?=$widgetId;?>">
    <a class="icon icon city-choice b-spr  dropdown-toggle" data-toggle="dropdown"></a>
    <ul class="dropdown-menu spec-select">
        <?php foreach ($cities as $city):?>
            <?php if($moduleId == 'deals' && $controllerId == 'frontend/catalog' && $actionId == 'deal'):?>
                <?php if(!is_null($currentCategory)):?>
                    <li><a href="<?=DealsCategories::getPublicUrlByCatId($currentCategory->id,$city->key);?>" <?=($city->key == $userCityKey)?'class="act b-spr"':"";?> ><?=$city->name;?></a></li>
                <?php else:?>
                    <li><a href="<?=Yii::app()->createUrl("/".$city->key);?>" <?=($city->key == $userCityKey)?'class="act b-spr"':"";?> ><?=$city->name;?></a></li>
                <?php endif;?>
            <?php else:?>
                <li><a href="<?=Yii::app()->createUrl("/".$city->key."/".$uri);?>" <?=($city->key == $userCityKey)?'class="act b-spr"':"";?> ><?=$city->name;?></a></li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>
</li>
