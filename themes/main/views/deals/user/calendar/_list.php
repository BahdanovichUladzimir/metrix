<?php

/**
 * @var $model Deals
 * @var $dataProvider CActiveDataProvider
 * @var Calendar $calendarModel
 * @var TbActiveForm $form
 */
?>

<table class="table func-tab guest-tab calendar-tab" id="guests_list_table">
	<tbody>
		<tr>
			<th><label class="checkbox"><input type="checkbox" id="check_all" class="checkall"><span class="a-spr"></span></label></th>
			<th class="ta-l"><?=Yii::t('dealsModule','Title');?></th>
			<th><?=Yii::t('eventsModule','Description');?></th>
			<th class="ta-l"><?=Yii::t('dealsModule','Start');?></th>
			<th><?=Yii::t('eventsModule','End');?></th>
			<th class="ta-l"><?=Yii::t('eventsModule','Type');?></th>
		</tr>

		<?php foreach($dataProvider->getData() as $item):?>
			<?php $this->renderPartial("_item", array("data" => $item));?>
		<?php endforeach;?>
	</tbody>
</table>

