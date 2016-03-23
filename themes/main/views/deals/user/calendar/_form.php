<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 19.10.2015
 * @var Calendar $model
 * @var TbActiveForm $form
 * @var Deals $deal
 */
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>$model->isNewRecord ? 'calendar-event-add-form' : 'calendar-event-form_'.$model->id,
    'enableAjaxValidation'=>true,
    'action' => $model->isNewRecord ? Yii::app()->createUrl("/deals/user/calendar/create") : Yii::app()->createUrl("/deals/user/calendar/update", array('id' => $model->id)),
)); ?>
<?php echo $form->hiddenField($model,'deal_id', array("value" => $deal->id)); ?>
<div class="errors text-danger" id="calendar_form_errors_container_<?=$model->id;?>">

</div>
<?php echo $form->textFieldGroup($model,'title',array('maxlength'=>255, "class" => 'form-control')); ?>

<div class="login-options form-group">
    <div>
        <span><?=Yii::t("dealsModule","Type");?>:</span>
    </div>
    <div class="change-select">
        <?php echo $form->dropDownList($model,'type', Calendar::$types);?>
        <?php echo $form->error($model,'type');?>
    </div>
</div>
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
                    //'datepicker'=>false,
                    'format'=>'d.m.Y H:i'
                ), //DateTimePicker options
                'htmlOptions' => array(
                    'class' => 'form-control ct-form-control',
                    'value' => $model->isNewRecord ? date('d.m.Y H:i', time()) : $model->formattedStart,
                    'placeholder' => $model->getAttributeLabel('start'),
                    'id' => $model->isNewRecord ? 'Calendar_start' : 'Calendar_start_'.$model->id,
                ),
            ));
            ;?>
        </div>
        <?php $errId = $model->isNewRecord ? "Calendar_start_em_" : "Calendar_start_".$model->id."_em_";?>
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
                    //'datepicker'=>false,
                    'format'=>' d.m.Y H:i'
                ), //DateTimePicker options
                'htmlOptions' => array(
                    'class' => 'form-control ct-form-control',
                    'value' => $model->isNewRecord ? date('d.m.Y H:i', time()) : $model->formattedEnd,
                    'placeholder' => $model->getAttributeLabel('end'),
                    'id' => $model->isNewRecord ? 'Calendar_end' : 'Calendar_end_'.$model->id,
                ),
            ));
            ;?>
        </div>
        <?php $errId = $model->isNewRecord ? "Calendar_end_em_" : "Calendar_end_".$model->id."_em_";?>
        <?=$form->error($model,"end", array('id' => $errId));?>
    </div>
</div>

<?php echo $form->textAreaGroup($model,'description',array("widgetOptions"=>array("class" => 'form-control', 'rows'=>6, 'cols'=>50))); ?>
<div class="btn btn-big btn-success a-spr add-btn" >
    <?php if($model->isNewRecord):?>
        <?php $modalId = "#addCalendarEvent";?>
    <?php else:?>
        <?php $modalId = "#editCalendarEvent_".$model->id;?>
    <?php endif;?>
    <?php echo CHtml::ajaxSubmitButton(
        $model->isNewRecord ? Yii::t('core','Add') : Yii::t('core','Save'),
        $model->isNewRecord ? Yii::app()->createUrl("/deals/user/calendar/create") : Yii::app()->createUrl("/deals/user/calendar/update", array('id' => $model->id)),
        array(
            'success' => 'js:function(data){
                if(data.status === "success"){
                    $("'.$modalId.'").modal("hide");
                    window.location.href = "'.Yii::app()->createUrl('/deals/user/calendar/index', array('deal_id' => $deal->id, 'scrollToElement' => 'deal_calendar_list_panel')).'";
                }
                else if(data.status === "error"){
                    if(data.errors){
                        $.each(data.errors, function(){
                            $("#calendar_form_errors_container_'.$model->id.'").append(this+"</br>");
                        });
                    }
                }
                else{

                };
                console.log(data);
            }',
            'dataType' => 'json'
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>



