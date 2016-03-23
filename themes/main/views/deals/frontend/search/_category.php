<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.08.2015
 * @var $data DealsCategories
 */
;?>
<li class="search-result-categories-list-item">
    <?=CHtml::link($data->name,DealsCategories::getPublicUrlByCatId($data->id,$this->userCityKey));?>
</li>