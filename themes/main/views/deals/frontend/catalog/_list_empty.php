<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 05.08.2015
 * @var string $title
 * @var string $message
 */
;?>
<script>
    $(document).ready(function(){
        $('.error-page-back-button').click(function(){
            history.go(-1);
            return false;
        });

    });
</script>
<div class="spacer-100">

</div>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
        <p class="text-center">
            <img class="list-empty-image" src="/images/photos_img.png" alt="photos_img.png">
        </p>
        <h3 class="list-empty-title text-center"><?php echo CHtml::encode($title);?></h3>
        <p class="text-center">
            <span class="list-empty-message"><?php echo CHtml::encode($message); ?></span>
        </p>
        <p class="text-center">
            <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default error-page-back-button'));?>
        </p>
    </div>
</div>
