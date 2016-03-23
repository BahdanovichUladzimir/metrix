<?php

/**
 * @var $model Events
 * @var $dataProvider CActiveDataProvider
 * @var int $sizeOfNotSubmitted
 * @var int $sizeOfSubmitted
 * @var int $sizeOfConfirmed
 * @var int $sizeOfRefused
 * @var EventsGuests $guestModel
 * @var TbActiveForm $form
 * @var string|null $scrollToElement
 */
$this->breadcrumbs=array(
    Yii::t('eventsModule','Events')=>array('index'),
	$model->name=>$model->getPrivateUrl(),
    Yii::t('eventsModule','Table of guests at the event')
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
		$(".guest-party-select").change(function(){
			var party_id = $(this).find(":selected").val();
			var guest_id = $(this).data("guest_id");
			$.ajax({
				url:"<?=Yii::app()->createUrl('/events/user/eventsGuests/setParty');?>",
				dataType: "json",
				type: "post",
				data: {party_id:party_id, guest_id: guest_id},
				success: function(response){
                    updatePage();
				}
			})
		});
		$(".guest-status-select").change(function(){
			var status_id = $(this).find(":selected").val();
			var guest_id = $(this).data("guest_id");
			$.ajax({
				url:"<?=Yii::app()->createUrl('/events/user/eventsGuests/setStatus');?>",
				dataType: "json",
				type: "post",
				data: {status_id:status_id, guest_id: guest_id},
				success: function(response){
                    updatePage();
                }
			})
		});
        $("#check_all").change(function(){
            $(".checkbox-td input[type='checkbox']").prop('checked', this.checked).attr("checked", this.checked);
        });
        $("#guests_party_select").change(function(){
            //var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var checkboxes = $(".checkbox-td input[type='checkbox']:checked");
            var ids = [];
            checkboxes.each(function(i){
                ids.push($(this).data('guest_id'));
            });
            if(ids.length > 0){
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/events/user/eventsGuests/setGuestsParty');?>",
                    dataType: "json",
                    type: "post",
                    data: {party:valueSelected, ids: ids},
                    success: function(response){
                        updatePage();
                    }
                })
            }
        });
        $("#guests_status_select").change(function(){
            //var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var checkboxes = $(".checkbox-td input[type='checkbox']:checked");
            var ids = [];
            checkboxes.each(function(i){
                ids.push($(this).data('guest_id'));
            });
            if(ids.length > 0){
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/events/user/eventsGuests/setGuestsStatus');?>",
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
                ids.push($(this).data('guest_id'));
            });
            if(ids.length > 0){
                if(confirm("<?=Yii::t('eventsModule','Are you sure?');?>")){
                    $.ajax({
                        url:"<?=Yii::app()->createUrl('/events/user/eventsGuests/deleteSelected');?>",
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
		window.location.href = "<?=Yii::app()->createUrl('/events/user/events/guestsList', array('id' => $model->id, 'scrollToElement' => 'guests_list_page_panel'));?>";
    }
</script>
<div class="panel" id="guests_list_page_panel">
	<div class="panel-body">
        <?php /*<div class="edit-wrap actions ta-r">
            <a href="#" class="gr-btn edit arr a"><?=Yii::t("eventsModule","Actions");?></a>
            <ul class="dropdown-menu">
                <!--<li><a href="#" class="ed-opt it-1 b-spr">Изменить</a></li>
                <li><a href="#" class="ed-opt it-2 b-spr">Сохранить</a></li>
                <li><a href="#" class="ed-opt it-3 b-spr">Печать</a></li>
                <li><a href="#" class="ed-opt it-4 b-spr">Поделиться</a></li>-->
                <li>
                    <?=CHtml::ajaxLink(
                        Yii::t('ses','Delete'),
                        array(
                            '/events/user/events/deleteGuestsList',
                            'id'=>$model->id,
                        ),
                        array(
                            'type'=>'POST',
                            'dataType'=> 'json',
                            'success'=>'js:function(data){
                                updatePage();
                            }',
                        ),
                        array(
                            'class' => 'ed-opt it-5 b-spr delete',
                            'confirm'=>Yii::t('userModule','Are you sure?')
                        )
                    );?>
                </li>
            </ul>
            <!--<span class="note">Последние изменения 15 октября 2015</span>-->
        </div>*/;?>
        <div class="row">
            <div class="col-lg-12">
                <div class="padding-wrap">
                    <span class="title icon-ttl b-spr it-2" id="guests_list_page_title"><?=Yii::t('eventsModule','Table of guests at the event');?></span>
                    <div class="func-nav">
                        <div class="pull-right change-select guest-func vis-hdn">

                            <span><?=Yii::t("eventsModule","Edit Selected");?>:</span>
                            <select id="guests_party_select" data-event_id="<?=$model->id;?>">
                                <option value="0"><?=Yii::t('eventsModule',"Select party");?></option>
                                <?php foreach(EventsGuests::getEventsGuestsParties() as $key => $value):?>
                                    <option value="<?=$key;?>"><?=$value;?></option>
                                <?php endforeach;?>
                            </select>
                            <select id="guests_status_select" data-event_id="<?=$model->id;?>">
                                <option value="0"><?=Yii::t('eventsModule',"Select status");?></option>
                                <?php foreach(EventsGuests::getEventsGuestsStatuses() as $key => $value):?>
                                    <option value="<?=$key;?>"><?=$value;?></option>
                                <?php endforeach;?>
                            </select>

                            <a href="#" class="del-btn btn b-spr" id="delete_selected"><?=Yii::t("core","Delete");?></a>
                        </div>
                        <a data-toggle="modal" data-target="#addGuest" class="add-g b-spr"><?=Yii::t('eventsModule','Add guest');?></a>
                    </div>
                    <div id="guests_list_table_container">
                        <?php $this->renderPartial(
                            '_guests_list',
                            array(
                                'model'=>$model,
                                'dataProvider' => $dataProvider,
                                'sizeOfNotSubmitted' => $sizeOfNotSubmitted,
                                'sizeOfSubmitted' => $sizeOfSubmitted,
                                'sizeOfConfirmed' => $sizeOfConfirmed,
                                'sizeOfRefused' => $sizeOfRefused,
                                'guestModel' => $guestModel
                            )
                        );?>
                    </div>
                    <table class="table table-striped table-contacts g-total">
                        <tr>
                            <td colspan="2"><?=Yii::t('eventsModule','Data based on the table');?>:</td>
                        </tr>
                        <tr>
                            <td class="tt-u"><?=Yii::t('eventsModule','Total number of guests');?>:</td>
                            <td><?=$dataProvider->getTotalItemCount();?> <?=Yii::t('eventsModule','pers');?>.</td>
                        </tr>
                        <tr>
                            <td class="tt-u"><?=Yii::t('eventsModule','Submitted');?>:</td>
                            <td><?=$sizeOfSubmitted;?> <?=Yii::t('eventsModule','pers');?>.</td>
                        </tr>
                        <tr>
                            <td class="tt-u"><?=Yii::t('eventsModule','Confirmed');?>:</td>
                            <td><?=$sizeOfConfirmed;?> <?=Yii::t('eventsModule','pers');?>.</td>
                        </tr>
                        <tr>
                            <td class="tt-u"><?=Yii::t('eventsModule','Refused');?>:</td>
                            <td><?=$sizeOfRefused;?> <?=Yii::t('eventsModule','pers');?>.</td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
	</div>
</div>
<div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="addGuest" aria-hidden="true" id="addGuest">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                <span class="title h3"><?=Yii::t('eventsModule',"New guest");?></span>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_event_guest_form',array("model" => $guestModel, 'event' => $model));?>
            </div>
        </div>
    </div>
</div>

