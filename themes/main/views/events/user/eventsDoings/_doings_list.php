<?php

/**
 * @var $model Events
 * @var $dataProvider CActiveDataProvider
 * @var EventsDoings $doingsModel
 * @var TbActiveForm $form
 */
?>

<table class="table func-tab guest-tab" id="guests_list_table">
	<tbody>
		<tr>
			<th><label class="checkbox"><input type="checkbox" id="check_all" class="checkall"><span class="a-spr"></span></label></th>
			<th class="ta-l"><?=Yii::t('eventsModule','Name');?></th>
			<th><?=Yii::t('eventsModule','Category');?></th>
			<th class="ta-l"><?=Yii::t('eventsModule','Note');?></th>
			<th><?=Yii::t('eventsModule','Price');?></th>
			<th class="ta-l"><?=Yii::t('eventsModule','Status');?></th>
		</tr>

		<?php foreach($dataProvider->getData() as $doing):?>
			<?php $this->renderPartial("_event_doing", array("data" => $doing));?>
		<?php endforeach;?>
	</tbody>
</table>

