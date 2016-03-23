<?php
/**
 * @var $model Events
 * @var $form TbActiveForm
*/
$xs = "12";
$sm = "12";
$lg = "4";
$md = "9";
;?>
<script>
    $(document).ready(function(){
        $('#Events_public_status_id').change(function(){
            var value = $(this).val();
            var container = $("#event_form_hidden_fields_container");
            if(value == 2){
                container.show();
            }
            else{
                if(container.is(':visible')){
                    container.hide();
                }
            }
        })
    });
</script>
<div class="panel panel-default">
	<div class="panel-body">
        <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
            'id'=>'events-form',
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

                <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

                <?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

                <?php echo $form->textFieldGroup($model,'venue',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <?php echo $form->datePickerGroup(
                            $model,
                            'date',
                            array(
                                'widgetOptions' => array(
                                    'options' => array(
                                        'language' => 'ru',
                                        'class' => 'form-control'
                                    ),
                                ),
                                'wrapperHtmlOptions' => array(
                                    //'class' => 'col-sm-5',
                                ),
                                //'hint' => 'Click inside! This is a super cool date field.',
                                'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
                            )
                        ); ?>
                        <div class="form-group">
                            <label for="Events_time" class="control-label"><?=$model->getAttributeLabel('time');?></label>
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <?php
                                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                                        'model' => $model,
                                        'attribute' => 'time',
                                        'options' => array(
                                            'datepicker'=>false,
                                            'format'=>'H:i'
                                        ), //DateTimePicker options
                                        'htmlOptions' => array(
                                            'class' => 'form-control ct-form-control',
                                            'placeholder' => $model->getAttributeLabel('time')
                                        ),
                                    ));
                                    ;?>
                                </div>
                                <div style="display:none" id="Events_time_em_" class="help-block error"></div>
                            </div>
                        </div>

                        <?php /*echo $form->timePickerGroup(
                            $model,
                            'time',
                            array(
                                'widgetOptions' => array(
                                    'wrapperHtmlOptions' => array(
                                        //'class' => 'col-sm-3'
                                    ),
                                ),
                                //'hint' => 'Nice bootstrap time picker',
                            )
                        ); */?>

                    </div>
                </div>

                <?php echo $form->dropDownListGroup(
                    $model,
                    'status_id',
                    array(
                        'widgetOptions' => array(
                            'data' => Events::getStatusesListData(),
                            'htmlOptions' => array(
                                //'multiple' => false,
                                //'empty' => Yii::t('dealsModule', 'Empty'),
                            )
                        ),
                        'label' => Yii::t('eventsModule','Status')
                    )
                ); ?>
                <?php echo $form->dropDownListGroup(
                    $model,
                    'public_status_id',
                    array(
                        'widgetOptions' => array(
                            'data' => Events::getPublicStatusesListData(),
                        ),
                        'label' => Yii::t('eventsModule','Public status')
                    )
                ); ?>
                <div class="event-form-hidden-fields-container" id="event_form_hidden_fields_container" <?=($model->public_status_id == 1) ? 'style="display: none"' : '';?>>
                    <?php echo $form->textAreaGroup(
                        $model,
                        'login',
                        array(
                            'widgetOptions'=>array(
                                'htmlOptions'=>array(
                                    'rows'=>6,
                                    'cols'=>50
                                )
                            ),
                            'hint' => "Если вы заполните это поле и выберите Публичный статус \"".Yii::t('eventsModule','Private')."\", то доступ к странице мероприятия будет осуществляться по паролю, который вы введёте в поле \"Пароль\". Содержимое данного поля будет отображено как подсказка к паролю."
                        )
                    ); ?>


                    <?php echo $form->textFieldGroup($model,'password',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

                </div>
                <?php echo $form->dropDownListGroup(
                    $model,
                    'type_id',
                    array(
                        'widgetOptions' => array(
                            'data' => CHtml::listData(EventsTypes::model()->findAll(), "id", "label"),
                        ),
                        'label' => Yii::t('eventsModule','Type')
                    )
                ); ?>

                <?php /*echo $form->textFieldGroup($model,'url',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); */?>
            </div>
        </div>

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

        <?php $this->endWidget(); ?>

    </div>
</div>


