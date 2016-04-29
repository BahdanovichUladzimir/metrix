<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.03.2015
 * @var $deal Deals
 */

;?>
<div class="balloon-body-container">
    <div class="row">
        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3">
            <?php $this->widget('modules.deals.widgets.dealGallery.DealGalleryWidget', array(
                'deal' => $deal,
                'template' => 'map'
            ));?>
        </div>
        <div class="col-xs-9 col-lg-9 col-md-9 col-sm-9">
            <h5 class="balloon-title"><?=$deal->name;?></h5>
            <?php $this->widget('modules.deals.widgets.dealParams.DealParamsWidget', array(
                'deal' => $deal,
                'template' => 'map'
            ));?>
            <?=CHtml::link(Yii::t('dealsModule',"More..."),$deal->getPublicUrl(), array('target' => '_blank', 'class' => 'balloon-read-more-link'));?>
        </div>
    </div>
</div>



