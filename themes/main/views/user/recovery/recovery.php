<?php $this->pageTitle=Yii::app()->name . ' - '.Yii::t('userModule',"Restore");
$this->breadcrumbs=array(
	Yii::t('userModule',"Login") => array('/user/login'),
	Yii::t('userModule',"Restore"),
);
?>
    <div class="col-md-4 col-lg-4">

    </div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <h1><?php echo Yii::t('userModule',"Restore"); ?></h1>

        <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
            <div class="success">
                <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
            </div>
        <?php else: ?>

            <div class="form">
                <?php echo CHtml::beginForm('','post',array('class'=>'form well')); ?>

                <?php echo CHtml::errorSummary($form); ?>

                <?php echo CHtml::activeLabel($form,'login_or_email'); ?>
                <?php echo CHtml::activeTextField($form,'login_or_email') ?>
                <p class="hint"><?php echo Yii::t('userModule',"Please enter your login or email addres."); ?></p>

                <?php echo CHtml::submitButton(Yii::t('userModule',"Restore"), array('class' => 'btn btn-success')); ?>

                <?php echo CHtml::endForm(); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-4 col-lg-4">

    </div>
