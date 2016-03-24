<?php

/**
 * @var $model DailySchedules
 * @var $dataProvider CActiveDataProvider
 * @var TbActiveForm $form
 */
?>

<table class="table func-tab guest-tab" id="guests_list_table">
	<tbody>
	<tr>
		<th><label class="checkbox"><input type="checkbox" id="check_all" class="checkall"><span class="a-spr"></span></label></th>
		<th class="ta-l"><?=Yii::t('eventsModule','Name');?></th>
		<th><?=Yii::t('eventsModule','Description');?></th>
		<th class="ta-l"><?=Yii::t('eventsModule','Start');?></th>
		<th><?=Yii::t('eventsModule','End');?></th>
	</tr>

	<?php foreach($model->dailySchedulesEvents as $event):?>
		<?php $this->renderPartial("_schedule_event", array("model" => $event, 'scheduleModel' => $model));?>
	<?php endforeach;?>
	</tbody>
</table>

