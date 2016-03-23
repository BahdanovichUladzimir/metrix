<?php
/**
 * @var $model Alcohol
 * @var $form TbActiveForm
*/
;?>
<div class="panel">
    <div class="panel-body">
        <!--<div class="ta-r options ta-r">
            <a href="#" class="btn btn-primary b-spr print"><?/*=Yii::t('eventsModule','Print');*/?></a>
        </div>-->
        <h1 class="title section-title h1"><?=Yii::t('eventsModule','Alcohol calculator');?></h1>
        <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
            'id'=>'alcohol-form',
            'enableAjaxValidation'=>true,
            'type' => 'horizontal',
        )); ?>

        <div class="row settings-form calc">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php echo $form->hiddenField($model,'event_id',array('maxlength'=>10)); ?>
                            <span class="num"><span>1</span> <?=Yii::t("eventsModule","Enter the guests count");?>:</span>
                            <div class="input-group">
                                <?php echo $form->labelEx($model,'men', array("class" => "input-group-addon")); ?>
                                <?php echo $form->textField($model,'men',array('maxlength'=>10, "class" => 'form-control num-val')); ?>
                                <?php echo $form->error($model,'men'); ?>
                            </div>
                            <div class="input-group">
                                <?php echo $form->labelEx($model,'women', array("class" => "input-group-addon")); ?>
                                <?php echo $form->textField($model,'women',array('maxlength'=>10, "class" => 'form-control num-val')); ?>
                                <?php echo $form->error($model,'women'); ?>
                            </div>
                            <div class="input-group">
                                <?php echo $form->labelEx($model,'children', array("class" => "input-group-addon")); ?>
                                <?php echo $form->textField($model,'children',array('maxlength'=>10, "class" => 'form-control num-val')); ?>
                                <?php echo $form->error($model,'children'); ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <span class="num"><span>2</span> <?=Yii::t("eventsModule","Non-drinking guests");?>:</span>
                            <div class="input-group">
                                <?php echo $form->labelEx($model,'not_drinking_men', array("class" => "input-group-addon")); ?>
                                <?php echo $form->textField($model,'not_drinking_men',array('maxlength'=>10, "class" => 'form-control num-val')); ?>
                                <?php echo $form->error($model,'not_drinking_men'); ?>

                            </div>
                            <div class="input-group">
                                <?php echo $form->labelEx($model,'not_drinking_women', array("class" => "input-group-addon")); ?>
                                <?php echo $form->textField($model,'not_drinking_women',array('maxlength'=>10, "class" => 'form-control num-val')); ?>
                                <?php echo $form->error($model,'not_drinking_women'); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <span class="num"><span>3</span> <?=Yii::t("eventsModule","Extra options");?>:</span>
                    <div class="input-group">
                        <?php /*echo $form->labelEx($model,'alcohol_consumption', array("class" => "input-group-addon")); */?>
                        <span class="input-group-addon"><?=Yii::t("dealsModule","Evaluate how much your guests like to drink alcohol");?>:</span>
                        <?php echo $form->dropDownList($model,'alcohol_consumption', Alcohol::getAlcoholConsumptionDegrees(),array('maxlength'=>10, "class" => 'form-control')); ?>
                        <?php echo $form->error($model,'alcohol_consumption'); ?>
                    </div>
                    <div class="input-group">
                        <?php /*echo $form->labelEx($model,'alcohol_consumption', array("class" => "input-group-addon")); */?>
                        <span class="input-group-addon"><?=Yii::t("dealsModule","Select the season in which the event is held");?>:</span>
                        <?php echo $form->dropDownList($model,'season', Alcohol::getSeasons(),array('maxlength'=>10, "class" => 'form-control')); ?>
                        <?php echo $form->error($model,'season'); ?>
                    </div>
                    <div class="input-group">
                        <?php /*echo $form->labelEx($model,'event_duration', array("class" => "input-group-addon")); */?>
                        <span class="input-group-addon"><?=Yii::t("dealsModule","Search event duration in hours (usually 6 hours)");?>:</span>
                        <?php echo $form->textField($model,'event_duration',array('maxlength'=>10, "class" => 'form-control num-val')); ?>
                        <?php echo $form->error($model,'event_duration'); ?>

                    </div>
                </div>
            </div>
            <div class="btns-wrap">
                <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'reset',
                    'context'=>'default',
                    'label'=>Yii::t('core','Reset'),
                )); ?>
                <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'context'=>'success',
                    'label'=>$model->isNewRecord ? Yii::t('core','Calculate') : Yii::t('core','Calculate'),
                )); ?>
                <!--<a href="#" class="btn btn-default">Сбросить</a>
                <input type="submit" value="Расчитать" class="btn btn-success"/>-->
            </div>
            <?php $this->endWidget(); ?>
    </div>
</div>


