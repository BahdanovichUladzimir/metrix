<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::encode($data->event_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('men')); ?>:</b>
	<?php echo CHtml::encode($data->men); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('women')); ?>:</b>
	<?php echo CHtml::encode($data->women); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('children')); ?>:</b>
	<?php echo CHtml::encode($data->children); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('not_drinking_men')); ?>:</b>
	<?php echo CHtml::encode($data->not_drinking_men); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('not_drinking_women')); ?>:</b>
	<?php echo CHtml::encode($data->not_drinking_women); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('event_duration')); ?>:</b>
	<?php echo CHtml::encode($data->event_duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alcohol_consumption')); ?>:</b>
	<?php echo CHtml::encode($data->alcohol_consumption); ?>
	<br />

	*/ ?>

</div>