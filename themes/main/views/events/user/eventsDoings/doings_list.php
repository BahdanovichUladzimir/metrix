<?php

/**
 * @var $model Events
 * @var $dataProvider CActiveDataProvider
 * @var EventsDoings $doingsModel
 * @var int $sizeOfReady
 * @var TbActiveForm $form
 * @var string|null $scrollToElement
 */
$this->breadcrumbs=array(
    Yii::t('eventsModule','Events')=>array('index'),
    $model->name=>$model->getPrivateUrl(),
    Yii::t('eventsModule','To-do list for the event')
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

        $(".doing-category-select").change(function(){
            var category_id = $(this).find(":selected").val();
            var doing_id = $(this).data("doing_id");
            $.ajax({
                url:"<?=Yii::app()->createUrl('/events/user/eventsDoings/setCategory');?>",
                dataType: "json",
                type: "post",
                data: {category_id:category_id, doing_id: doing_id},
                success: function(response){
                    updatePage();
                }
            })
        });
        $(".doing-status-select").change(function(){
            var status_id = $(this).find(":selected").val();
            var doing_id = $(this).data("doing_id");
            $.ajax({
                url:"<?=Yii::app()->createUrl('/events/user/eventsDoings/setStatus');?>",
                dataType: "json",
                type: "post",
                data: {status_id:status_id, doing_id: doing_id},
                success: function(response){
                    updatePage();
                }
            })
        });
        $("#check_all").change(function(){
            $(".checkbox-td input[type='checkbox']").prop('checked', this.checked).attr("checked", this.checked);
        });
        $("#doings_category_select").change(function(){
            //var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var checkboxes = $(".checkbox-td input[type='checkbox']:checked");
            var ids = [];
            checkboxes.each(function(i){
                ids.push($(this).data('doing_id'));
            });
            if(ids.length > 0){
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/events/user/eventsDoings/setDoingsCategory');?>",
                    dataType: "json",
                    type: "post",
                    data: {category_id:valueSelected, ids: ids},
                    success: function(response){
                        updatePage();
                    }
                })
            }
        });
        $("#doings_status_select").change(function(){
            //var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var checkboxes = $(".checkbox-td input[type='checkbox']:checked");
            var ids = [];
            checkboxes.each(function(i){
                ids.push($(this).data('doing_id'));
            });
            if(ids.length > 0){
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/events/user/eventsDoings/setDoingsStatus');?>",
                    dataType: "json",
                    type: "post",
                    data: {status:valueSelected, ids: ids},
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
                ids.push($(this).data('doing_id'));
            });
            if(ids.length > 0){
                if(confirm("<?=Yii::t('eventsModule','Are you sure?');?>")){
                    $.ajax({
                        url:"<?=Yii::app()->createUrl('/events/user/eventsDoings/deleteSelected');?>",
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
        window.location.href = "<?=Yii::app()->createUrl('/events/user/eventsDoings/index', array('event_id' => $model->id, 'scrollToElement' => 'event_doings_list_panel'));?>";
    }
</script>
<div class="panel" id="event_doings_list_panel">
    <div class="panel-body">
        <!--<div class="ta-r options ta-r">
            <a href="#" class="btn btn-primary b-spr print"><?/*=Yii::t('eventsModule','Print');*/?></a>
        </div>-->
        <h1 class="title section-title h1" id="to_does_list_title"><?=Yii::t('eventsModule','To-do list for the event');?></h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="func-nav">
                    <div class="pull-right change-select guest-func vis-hdn">

                        <span><?=Yii::t("eventsModule","Edit Selected");?>:</span>
                        <select id="doings_category_select" data-doing_id="<?=$model->id;?>">
                            <option value="0"><?=Yii::t('eventsModule',"Select category");?></option>
                            <?php foreach(CHtml::listData(EventsDoingsCategories::model()->findAll(),'id', 'name') as $key => $value):?>
                                <option value="<?=$key;?>"><?=$value;?></option>
                            <?php endforeach;?>
                        </select>
                        <select id="doings_status_select" data-event_id="<?=$model->id;?>">
                            <option value="0"><?=Yii::t('eventsModule',"Select status");?></option>
                            <?php foreach(EventsDoings::$statuses as $key => $value):?>
                                <option value="<?=$key;?>"><?=$value;?></option>
                            <?php endforeach;?>
                        </select>

                        <a href="#" class="del-btn btn b-spr" id="delete_selected"><?=Yii::t("core","Delete");?></a>
                    </div>
                    <a data-toggle="modal" data-target="#addDoing" class="add-g b-spr"><?=Yii::t('eventsModule','Add to-do');?></a>
                </div>
                <div id="doings_list_table_container">
                    <?php $this->renderPartial(
                        '_doings_list',
                        array(
                            'model'=>$model,
                            'dataProvider' => $dataProvider,
                            'doingsModel' => $doingsModel
                        )
                    );?>
                </div>
                <table class="table table-striped table-contacts g-total">
                    <tr>
                        <td colspan="2"><?=Yii::t('eventsModule','Data based on the table');?>:</td>
                    </tr>
                    <tr>
                        <td class="tt-u"><?=Yii::t('eventsModule','Total number of to-do\'s');?>:</td>
                        <td><?=$dataProvider->getTotalItemCount();?></td>
                    </tr>
                    <tr>
                        <td class="tt-u"><?=Yii::t('eventsModule','Ready');?>:</td>
                        <td><?=$sizeOfReady;?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="addDoing" aria-hidden="true" id="addDoing">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                <span class="title h3"><?=Yii::t('eventsModule',"New to-do");?></span>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_event_doing_form',array("model" => $doingsModel, 'event' => $model));?>
            </div>
        </div>
    </div>
</div>

