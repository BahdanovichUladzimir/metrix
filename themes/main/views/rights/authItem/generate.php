<?php $this->breadcrumbs = array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Rights::t('core', 'Rights')=>Rights::getBaseUrl(),
	Rights::t('core', 'Generate items'),
); ?>

<div id="generator">
	<h2><?php echo Rights::t('core', 'Generate items'); ?></h2>
	<p><?php echo Rights::t('core', 'Please select which items you wish to generate.'); ?></p>
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm'); ?>
			<table class="items table table-condensed generate-item-table" border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr class="application-heading-row">
						<th class="bg-primary" colspan="3"><?php echo Rights::t('core', 'Application'); ?></th>
					</tr>

					<?php $this->renderPartial('_generateItems', array(
						'model'=>$model,
						'form'=>$form,
						'items'=>$items,
						'existingItems'=>$existingItems,
						'displayModuleHeadingRow'=>true,
						'basePathLength'=>strlen(Yii::app()->basePath),
					)); ?>
				</tbody>
			</table>
			<?php echo CHtml::link(
				Rights::t('core', 'Select all'),
				'#',
				array(
					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').attr('checked', 'checked'); return false;",
					'class'=>'selectAllLink'))
			;?>
			/
			<?php echo CHtml::link(
				Rights::t('core', 'Select none'),
				'#',
				array(
					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').removeAttr('checked'); return false;",
					'class'=>'selectNoneLink'))
			;?>
			<?php $this->widget('booster.widgets.TbButton',
				array(
					'buttonType' => 'submit',
					'context' => 'success',
					'label' => Rights::t('core', 'Generate'))
			);?>
		<?php $this->endWidget(); ?>
</div>