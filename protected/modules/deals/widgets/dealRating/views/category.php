<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.03.2015
 * @var $deal Deals
 * @var $category DealsCategories
 * @var array $currentRatings
 * @var int|string $currentTotalRating
 */
;?>
<div class="rating-container service-info">
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 pull-right">
            <span class="rating-title"><?=Yii::t("dealsModule","Rating");?></span>
            <div class="rating total-rating" id="total_rating_container">
                <div class="rating-form">
                    <?php for($i=1;$i<=5;$i++):?>
                        <?php $currentClass = '';?>
                        <?php if($i<=$currentTotalRating):?>
                            <?php $currentClass = 'active';?>
                        <?php endif;?>
                        <span data-num="<?=$i;?>" data-fix="1" class="category-rating-star <?=$currentClass;?>"></span>
                    <?php endfor;?>
                </div>
            </div>

        </div>
    </div>
</div>

