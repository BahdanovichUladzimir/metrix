<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 07.05.2015
 * @var $this ProfileController
 */
;?>
<div class="cf">
    <ul class="nav nav-tabs navbar-left">
        <li <?=($this->action->id == "editMainSettings") ? "class=\"active\"" : "";?>><?=CHtml::link(Yii::t("userModule","Main settings"),Yii::app()->createUrl('user/profile/editMainSettings'));?></li>
        <li <?=($this->action->id == "editContactsSettings") ? "class=\"active\"" : "";?>><?=CHtml::link(Yii::t("userModule","Contacts and information"),Yii::app()->createUrl('user/profile/editContactsSettings'));?></li>
        <li <?=($this->action->id == "changepassword") ? "class=\"active\"" : "";?>><?=CHtml::link(Yii::t("userModule","Password"),Yii::app()->createUrl('user/profile/changepassword'));?></a></li>
    </ul>
</div>