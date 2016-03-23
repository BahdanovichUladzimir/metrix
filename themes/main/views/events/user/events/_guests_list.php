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
 */
?>

<table class="table func-tab guest-tab" id="guests_list_table">
	<tbody>
		<tr>
			<th><label class="checkbox"><input type="checkbox" id="check_all" class="checkall"><span class="a-spr"></span></label></th>
			<th class="ta-l"><?=Yii::t('eventsModule','Name');?></th>
			<th><?=Yii::t('eventsModule','Side');?></th>
			<th class="ta-l"><?=Yii::t('eventsModule','Note');?></th>
			<th><?=Yii::t('eventsModule','Status');?></th>
		</tr>

		<?php foreach($dataProvider->getData() as $guest):?>
			<?php $this->renderPartial("_event_guest", array("data" => $guest));?>
		<?php endforeach;?>
	</tbody>
</table>

