<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<script>
    $(document).ready(function(){
        $('.error-page-back-button').click(function(){
            history.go(-1);
            return false;
        });

    });
</script>
<div class="spacer-20">

</div>
<div class="row">
	<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">
        <p class="text-center">
            <img class="error-page-error-image" src="/images/ERROR.png" alt="error.png">
        </p>
        <p class="text-center">
            <span class="error-page-error-code"><?php echo $code;?></span>
        </p>
        <p class="text-center">
            <span class="error-page-error"><?php echo CHtml::encode($message); ?></span>
        </p>
        <p class="text-center">
            <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default error-page-back-button'));?>
        </p>
	</div>
</div>
