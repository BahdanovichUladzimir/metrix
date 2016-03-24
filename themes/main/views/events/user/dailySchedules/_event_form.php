<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.03.2016
 * @var DailySchedulesEvents $model
 * @var DailySchedules $scheduleModel
 * @var TbActiveForm $form
 */
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>$model->isNewRecord ? 'daily-schedules-events-add-form' : 'daily-schedules-events-form',
    'enableAjaxValidation'=>true,
    'action' => $model->isNewRecord ? Yii::app()->createUrl("/events/user/dailySchedulesEvents/create") : Yii::app()->createUrl("/events/user/dailySchedulesEvents/update", array('id' => $model->id)),
)); ?>
<?php echo $form->hiddenField($model,'schedule_id', array("value" => $scheduleModel->id)); ?>

<?php echo $form->textFieldGroup($model,'name',array('maxlength'=>255, "class" => 'form-control')); ?>

<?php echo $form->textAreaGroup($model,'description',array("widgetOptions"=>array("class" => 'form-control', 'rows'=>6, 'cols'=>50))); ?>
<div class="form-group">
    <?=$form->labelEx($model,"start");?>
    <div>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            <?php
            $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                'model' => $model,
                'form' => $form,
                'attribute' => 'start',
                'options' => array(
                    'datepicker'=>false,
                    'format'=>'H:i',
                    'lang'=>'ru',
                ), //DateTimePicker options
                'htmlOptions' => array(
                    'class' => 'form-control ct-form-control',
                    'value' => $model->isNewRecord ? date('H:i', time()) : $model->publicStart,
                    'placeholder' => $model->getAttributeLabel('start'),
                    'id' => $model->isNewRecord ? 'DailySchedulesEvents_start' : 'DailySchedulesEvents_start_'.$model->id,
                ),
            ));
            ;?>
        </div>
        <?php $errId = $model->isNewRecord ? "DailySchedulesEvents_start_em_" : "DailySchedulesEvents_start_".$model->id."_em_";?>
        <?=$form->error($model,"start", array('id' => $errId));?>

    </div>
</div>
<div class="form-group">
    <?=$form->labelEx($model,"end");?>
    <div>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            <?php
            $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                'model' => $model,
                'form' => $form,
                'attribute' => 'end',
                'options' => array(
                    'datepicker'=>false,
                    'format'=>'H:i',
                    'lang'=>'ru',
                ), //DateTimePicker options
                'htmlOptions' => array(
                    'class' => 'form-control ct-form-control',
                    'value' => $model->isNewRecord ? date('H:i', time()) : $model->publicEnd,
                    'placeholder' => $model->getAttributeLabel('end'),
                    'id' => $model->isNewRecord ? 'DailySchedulesEvents_end' : 'DailySchedulesEvents_end_'.$model->id,
                ),
            ));
            ;?>
        </div>
        <?php $errId = $model->isNewRecord ? "Calendar_start_em_" : "Calendar_start_".$model->id."_em_";?>
        <?=$form->error($model,"end", array('id' => $errId));?>

    </div>
</div>
<div class="btn btn-big btn-success a-spr add-btn" >
    <?php if($model->isNewRecord):?>
        <?php $modalId = "#addDoing";?>
    <?php else:?>
        <?php $modalId = "#editDoing_".$model->id;?>
    <?php endif;?>
    <?php echo CHtml::ajaxSubmitButton(
        $model->isNewRecord ? Yii::t('core','Add') : Yii::t('core','Save'),
        $model->isNewRecord ? Yii::app()->createUrl("/events/user/dailySchedulesEvents/create") : Yii::app()->createUrl("/events/user/dailySchedulesEvents/update", array('id' => $model->id)),
        array(
            'success' => 'js:function(data){
                $("'.$modalId.'").modal("hide");
                window.location.href = "'.Yii::app()->createUrl('/events/user/dailySchedules/view', array('id' => $scheduleModel->id, 'scrollToElement' => 'daily_schedules_events_list_panel')).'";
            }',
            'dataType' => 'json'
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>



