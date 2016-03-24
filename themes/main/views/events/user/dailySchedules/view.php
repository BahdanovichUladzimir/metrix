<?php

/**
 * @var $model DailySchedules
 * @var $eventModel DailySchedulesEvents
 * @var $form TbActiveForm
 * @var string|null $scrollToElement
 */
$this->breadcrumbs=array(
		Yii::t('eventsModule','Events')=>array('index'),
		Yii::t('eventsModule','Daily schedules')=>array('index'),
		$model->publicDate,
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



		$("#check_all").change(function(){
			$(".checkbox-td input[type='checkbox']").prop('checked', this.checked).attr("checked", this.checked);
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
						url:"<?=Yii::app()->createUrl('/events/user/dailySchedulesEvents/deleteSelected');?>",
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
		window.location.href = "<?=Yii::app()->createUrl('/events/user/dailySchedules/view', array('id' => $model->id, 'scrollToElement' => 'daily_schedules_events_list_panel'));?>";
	}
</script>
<div class="panel" id="daily_schedules_events_list_panel">
	<div class="panel-body">
		<h1 class="title section-title h1" id="to_does_list_title"><?=Yii::t('eventsModule','Daily schedule {date}', array("{date}" => $model->publicDate));?></h1>
		<h3><?=$model->name;?></h3>
		<p><?=$model->description;?></p>
		<div class="row">
			<div class="col-lg-12">
				<div class="func-nav">
					<div class="pull-right change-select guest-func vis-hdn">

						<!--<span><?/*=Yii::t("eventsModule","Edit Selected");*/?>:</span>
						<select id="doings_category_select" data-doing_id="<?/*=$model->id;*/?>">
							<option value="0"><?/*=Yii::t('eventsModule',"Select category");*/?></option>
							<?php /*foreach(CHtml::listData(EventsDoingsCategories::model()->findAll(),'id', 'name') as $key => $value):*/?>
								<option value="<?/*=$key;*/?>"><?/*=$value;*/?></option>
							<?php /*endforeach;*/?>
						</select>
						<select id="doings_status_select" data-event_id="<?/*=$model->id;*/?>">
							<option value="0"><?/*=Yii::t('eventsModule',"Select status");*/?></option>
							<?php /*foreach(EventsDoings::$statuses as $key => $value):*/?>
								<option value="<?/*=$key;*/?>"><?/*=$value;*/?></option>
							<?php /*endforeach;*/?>
						</select>-->

						<a href="#" class="del-btn btn b-spr" id="delete_selected"><?=Yii::t("core","Delete");?></a>
					</div>
					<a data-toggle="modal" data-target="#addDoing" class="add-g b-spr"><?=Yii::t('eventsModule','Add event');?></a>
				</div>
				<div id="doings_list_table_container">
					<?php $this->renderPartial(
							'_view',
							array(
								'model'=>$model,
								'eventModel' => $eventModel
							)
					);?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="addDoing" aria-hidden="true" id="addDoing">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
				<span class="title h3"><?=Yii::t('eventsModule',"New event");?></span>
			</div>
			<div class="modal-body">
				<?php $this->renderPartial('_event_form',array("model" => $eventModel, 'scheduleModel' => $model));?>
			</div>
		</div>
	</div>
</div>


