<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 19.10.2015
 * @var EventsDoings $model
 * @var TbActiveForm $form
 * @var Events $event
 */
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
    'id'=>$model->isNewRecord ? 'events-doings-add-form' : 'events-doings-form',
    'enableAjaxValidation'=>true,
    'action' => $model->isNewRecord ? Yii::app()->createUrl("/events/user/eventsDoings/create") : Yii::app()->createUrl("/events/user/eventsDoings/update", array('id' => $model->id)),
)); ?>
<?php echo $form->hiddenField($model,'event_id', array("value" => $event->id)); ?>

<?php echo $form->textFieldGroup($model,'name',array('maxlength'=>255, "class" => 'form-control')); ?>

<div class="login-options form-group">
    <div>
        <span><?=Yii::t("dealsModule","Category");?>:</span>
    </div>
    <div class="change-select">
        <?php echo $form->dropDownList($model,'category_id', CHtml::listData(EventsDoingsCategories::model()->findAll(),"id","name"));?>
        <?php echo $form->error($model,'category_id'); ?>
    </div>
</div>
<div class="login-options form-group">
    <div>
        <span><?=Yii::t("dealsModule","To-do status");?>:</span>
    </div>
    <div class="change-select">
        <?php echo $form->dropDownList($model,'status', EventsDoings::$statuses);?>
        <?php echo $form->error($model,'status');?>
    </div>
</div>
<?php echo $form->textFieldGroup($model,'price',array("class" => 'form-control')); ?>

<?php echo $form->textAreaGroup($model,'comment',array("widgetOptions"=>array("class" => 'form-control', 'rows'=>6, 'cols'=>50))); ?>
<div class="btn btn-big btn-success a-spr add-btn" >
    <?php if($model->isNewRecord):?>
        <?php $modalId = "#addDoing";?>
    <?php else:?>
        <?php $modalId = "#editDoing_".$model->id;?>
    <?php endif;?>
    <?php echo CHtml::ajaxSubmitButton(
        $model->isNewRecord ? Yii::t('core','Add') : Yii::t('core','Save'),
        $model->isNewRecord ? Yii::app()->createUrl("/events/user/eventsDoings/create") : Yii::app()->createUrl("/events/user/eventsDoings/update", array('id' => $model->id)),
        array(
            'success' => 'js:function(data){
                $("'.$modalId.'").modal("hide");
                window.location.href = "'.Yii::app()->createUrl('/events/user/eventsDoings/index', array('event_id' => $event->id, 'scrollToElement' => 'event_doings_list_panel')).'";
            }',
            'dataType' => 'json'
        )
    ); ?>
</div>
<?php $this->endWidget(); ?>



