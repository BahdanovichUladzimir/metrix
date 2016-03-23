<?php $this->pageTitle=Yii::app()->name . ' - '.Yii::t('userModule',"Change Password");
$this->breadcrumbs=array(
	Yii::t('userModule',"Login") => array('/user/login'),
	Yii::t('userModule',"Change Password"),
);
?>
<div class="col-md-4 col-lg-4">

</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <h1><?php echo Yii::t('userModule',"Change Password"); ?></h1>
    <div class="form">
        <?php echo CHtml::beginForm('','post',array('class'=>'form well')); ?>

        <p class="note"><?php echo Yii::t('userModule','Fields with <span class="required">*</span> are required.'); ?></p>
        <?php echo CHtml::errorSummary($form); ?>

            <?php echo CHtml::activeLabelEx($form,'password'); ?>
            <?php echo CHtml::activePasswordField($form,'password'); ?>
            <p class="hint">
                <?php echo Yii::t('userModule',"Minimal password length 4 symbols."); ?>
            </p>

            <?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
            <?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>


            <?php echo CHtml::submitButton(Yii::t('userModule',"Save"), array('class' => 'btn btn-success')); ?>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>
<div class="col-md-4 col-lg-4">

</div>
