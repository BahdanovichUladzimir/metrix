<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 19.10.2015
 * @var EventsGuests $model
 * @var TbActiveForm $form
 * @var Events $event
 */
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>$model->isNewRecord ? 'events-guests-add-form' : 'events-guests-form',
    'enableAjaxValidation'=>true,
    'action' => $model->isNewRecord ? Yii::app()->createUrl("/events/user/eventsGuests/create") : Yii::app()->createUrl("/events/user/eventsGuests/update", array('id' => $model->id)),
)); ?>
<?php echo $form->hiddenField($model,'event_id', array("value" => $event->id)); ?>

<?php echo $form->textFieldGroup($model,'name',array('maxlength'=>255, "class" => 'form-control')); ?>

<div class="login-options form-group">
    <div>
        <span><?=Yii::t("dealsModule","Whose side");?>:</span>
    </div>
    <div class="change-select">
        <?php echo $form->dropDownList($model,'party_id', EventsGuests::getEventsGuestsParties());?>
        <?php echo $form->error($model,'party_id'); ?>
    </div>
</div>

<div class="login-options form-group">
    <div>
        <span><?=Yii::t("dealsModule","Guest status");?>:</span>
    </div>
    <div class="change-select">
        <?php echo $form->dropDownList($model,'status_id', EventsGuests::getEventsGuestsStatuses());?>
        <?php echo $form->error($model,'status_id');?>
    </div>
</div>
<?php echo $form->textAreaGroup($model,'note',array("widgetOptions"=>array("class" => 'form-control', 'rows'=>6, 'cols'=>50))); ?>
<div class="btn btn-big btn-success a-spr add-btn" >
    <?php if($model->isNewRecord):?>
        <?php $modalId = "#addGuest";?>
    <?php else:?>
        <?php $modalId = "#editGuest_".$model->id;?>
    <?php endif;?>
    <?php echo CHtml::ajaxSubmitButton(
        $model->isNewRecord ? Yii::t('core','Add') : Yii::t('core','Save'),
        $model->isNewRecord ? Yii::app()->createUrl("/events/user/eventsGuests/create") : Yii::app()->createUrl("/events/user/eventsGuests/update", array('id' => $model->id)),
        array(
            'success' => 'js:function(data){
                $("'.$modalId.'").modal("hide");
                window.location.href = "'.Yii::app()->createUrl('/events/user/events/guestsList', array('id' => $event->id, 'scrollToElement' => 'guests_list_page_panel')).'";
            }',
            'dataType' => 'json'
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>



