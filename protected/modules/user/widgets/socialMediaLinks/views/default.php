<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 19.04.2015
 * @var $user User
 * @var $profile Profile
 */
$profile = $user->profile;
;?>
<div class="socials">
    <?/*=$profile->getLinkedinLink();*/?>
    <?=$profile->getSkypeLink();?>
    <?=$profile->getVimeoLink();?>
    <?=$profile->getTwitterLink();?>
    <?=$profile->getFacebookLink();?>
    <?=$profile->getVkLink();?>
    <?=$profile->getOkLink();?>
    <?=$profile->getYoutubeLink();?>
    <?=$profile->getInstagramLink();?>
</div>