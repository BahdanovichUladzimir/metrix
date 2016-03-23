<?php

/**
 * @var $model Deals
 * @var $dataProvider CActiveDataProvider
 * @var Calendar $calendarModel
 * @var TbActiveForm $form
 * @var string|null $scrollToElement
 */
$this->breadcrumbs=array(
    Yii::t('dealsModule','My deals')=>$model->user->getPrivateUrl(),
    $model->name=>$model->getPublicUrl(),
    Yii::t('dealsModule','Calendar')
); ?>
<script>
    function is_touch_device() {
        return !!('ontouchstart' in window) || !!('onmsgesturechange' in window);
    };
    if (is_touch_device()) {
        $('.prlx').removeAttr('data-stellar-ratio');
        $.stellar({
            hideDistantElements: false,
            positionProperty: 'transform',
            horizontalScrolling: false,
            responsive: false
        });
    }
    $(document).ready(function(){
        <?php if(!is_null($scrollToElement)):?>
            $('html, body').animate({
                scrollTop: $("#<?=$scrollToElement;?>").offset().top-80
            }, 1000);
        <?php endif;?>
        $(".calendar-event-type-select").change(function(){
            var type_id = $(this).find(":selected").val();
            var event_id = $(this).data("event_id");
            $.ajax({
                url:"<?=Yii::app()->createUrl('/deals/user/calendar/setType');?>",
                dataType: "json",
                type: "post",
                data: {type_id:type_id, event_id: event_id},
                success: function(response){
                    updatePage();
                }
            })
        });
        $("#check_all").change(function(){
            $(".checkbox-td input[type='checkbox']").prop('checked', this.checked).attr("checked", this.checked);
        });
        $("#calendar_event_type_select").change(function(){
            //var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var checkboxes = $(".checkbox-td input[type='checkbox']:checked");
            var ids = [];
            checkboxes.each(function(i){
                ids.push($(this).data('event_id'));
            });
            if(ids.length > 0){
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/deals/user/calendar/setEventsType');?>",
                    dataType: "json",
                    type: "post",
                    data: {type:valueSelected, ids: ids},
                    success: function(response){
                        updatePage();
                    }
                })
            }
        });
        $("#delete_selected").click(function(){
            //var optionSelected = $("option:selected", this);
            var checkboxes = $(".checkbox-td input[type='checkbox']:checked");
            var ids = [];
            checkboxes.each(function(i){
                ids.push($(this).data('event_id'));
            });
            if(ids.length > 0){
                if(confirm("<?=Yii::t('dealsModule','Are you sure?');?>")){
                    $.ajax({
                        url:"<?=Yii::app()->createUrl('/deals/user/calendar/deleteSelected');?>",
                        dataType: "json",
                        type: "post",
                        data: {ids: ids},
                        success: function(response){
                            updatePage();
                        }
                    });

                }
            }
            return false;
        });

    });
    function updatePage(){
        window.location.href = "<?=Yii::app()->createUrl('/deals/user/calendar/index', array('deal_id' => $model->id, 'scrollToElement' => 'deal_calendar_list_panel'));?>";
    }
</script>
<div class="panel" id="deal_calendar_list_panel">
    <div class="panel-body">
        <!--<div class="ta-r options ta-r">
            <a href="#" class="btn btn-primary b-spr print"><?/*=Yii::t('dealsModule','Print');*/?></a>
        </div>-->
        <h1 class="title section-title h1"><?=Yii::t('dealsModule','Deal <strong>{dealName}</strong> calendar', array('{dealName}' => $model->name));?></h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="func-nav">
                    <div class="pull-right change-select guest-func vis-hdn">
                        <span><?=Yii::t("dealsModule","Edit Selected");?>:</span>
                        <select id="calendar_event_type_select" data-event_id="<?=$model->id;?>">
                            <option value="0"><?=Yii::t('dealsModule',"Select type");?></option>
                            <?php foreach(Calendar::$types as $key => $value):?>
                                <option value="<?=$key;?>"><?=$value;?></option>
                            <?php endforeach;?>
                        </select>
                        <a href="#" class="del-btn btn b-spr" id="delete_selected"><?=Yii::t("core","Delete");?></a>
                    </div>
                    <a data-toggle="modal" data-target="#addCalendarEvent" class="add-g b-spr"><?=Yii::t('dealsModule','Add event');?></a>
                </div>
                <div id="doings_list_table_container">
                    <?php $this->renderPartial(
                        '_list',
                        array(
                            'model'=>$model,
                            'dataProvider' => $dataProvider,
                            'calendarModel' => $calendarModel
                        )
                    );?>
                </div>
                <table class="table table-striped table-contacts g-total">
                    <tr>
                        <td colspan="2"><?=Yii::t('dealsModule','Data based on the table');?>:</td>
                    </tr>
                    <tr>
                        <td class="tt-u"><?=Yii::t('dealsModule','Total number of calendar events');?>:</td>
                        <td><?=$dataProvider->getTotalItemCount();?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="addCalendarEvent" aria-hidden="true" id="addCalendarEvent">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                <span class="title h3"><?=Yii::t('dealsModule',"New event");?></span>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_form',array("model" => $calendarModel, 'deal' => $model));?>
            </div>
        </div>
    </div>
</div>

