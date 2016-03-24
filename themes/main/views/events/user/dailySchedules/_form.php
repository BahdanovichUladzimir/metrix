<?php
/**
 * @var $model DailySchedules
 * @var $form TbActiveForm
*/
$xs = "12";
$sm = "12";
$lg = "4";
$md = "9";
;?>
<div class="panel panel-default">
	<div class="panel-body">
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
			'id'=>'daily-schedules-form',
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'type' => 'vertical',
            'clientOptions'=>array(
                "validateOnSubmit"=> true,
                'validateOnChange' => true,
                'validateOnType' => true,
            )
		)); ?>
        <div class="row">
            <div class="col-lg-6 col-md-<?=$md;?> col-sm-<?=$sm;?> col-xs-<?=$xs;?>">
                <p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

                    <?php echo $form->textFieldGroup(
                        $model,
                        'name',
                        array(
                            'widgetOptions'=>array(
                                'htmlOptions'=>array(
                                    'maxlength'=>255
                                )
                            )
                        )
                    ); ?>

                    <?php echo $form->textAreaGroup(
                        $model,
                        'description',
                        array(
                            'widgetOptions'=>array(
                                'htmlOptions'=>array(
                                    'maxlength'=>5000
                                )
                            )
                        )
                    ); ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="DailySchedules_date" class="control-label"><?=$model->getAttributeLabel('date');?></label>
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <?php
                                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                                        'model' => $model,
                                        'attribute' => 'date',
                                        'options' => array(
                                            'timepicker'=>false,
                                            'format'=>'Y-m-d',
                                            'lang'=>'ru',
                                        ), //DateTimePicker options
                                        'htmlOptions' => array(
                                            'class' => 'form-control ct-form-control',
                                            'placeholder' => $model->getAttributeLabel('date')
                                        ),
                                    ));
                                    ;?>
                                </div>
                                <div style="display:none" id="Events_time_em_" class="help-block error"></div>
                            </div>
                        </div>
                    </div>
                </div>

                    <?php echo $form->hiddenField($model,'event_id',array('maxlength'=>10)); ?>

                <div class="form-actions">
                    <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>	<?php $this->widget('booster.widgets.TbButton', array(
                            'buttonType'=>'reset',
                            'context'=>'danger',
                            'label'=>Yii::t('core','Reset'),
                        )); ?>
                    <?php $this->widget('booster.widgets.TbButton', array(
                            'buttonType'=>'submit',
                            'context'=>'success',
                            'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
                        )); ?>
                </div>
            </div>
        </div>
		<?php $this->endWidget(); ?>
	</div>
</div>



