<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var int $widgetId
 * @var $model UserLogin
 * @var $form TbActiveForm
 */
;?>
<li id="authenticateWidget_<?=$widgetId;?>">
    <?php if(!Yii::app()->user->isGuest):?>
        <?=CHtml::link(Yii::t("dealsModule","Deal"),Yii::app()->createUrl('/deals/user/userDeals/create'), array('class' => 'btn btn-primary menu-btn a-spr'));?>
    <?php endif;?>
</li>