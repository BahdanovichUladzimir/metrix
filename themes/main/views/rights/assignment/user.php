<?php $this->breadcrumbs = array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Rights::t('core', 'Rights')=>Rights::getBaseUrl(),
	Rights::t('core', 'Assignments')=>array('assignment/view'),
	$model->getName(),
); ?>

<div id="userAssignments">

	<h2><?php echo Rights::t('core', 'Assignments for :username', array(
		':username'=>$model->getName()
	)); ?></h2>
	
	<div class="assignments first">

		<?php $this->widget('booster.widgets.TbExtendedGridView', array(
			'dataProvider'=>$dataProvider,
			'type'=>'striped condensed',
			'template'=>'{items}',
			'hideHeader'=>true,
			'emptyText'=>Rights::t('core', 'This user has not been assigned any items.'),
			'htmlOptions'=>array('class'=>'grid-view user-assignment-table mini'),
			'columns'=>array(
    			array(
    				'name'=>'name',
    				'header'=>Rights::t('core', 'Name'),
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'name-column'),
    				'value'=>'$data->getNameText()',
    			),
    			array(
    				'name'=>'type',
    				'header'=>Rights::t('core', 'Type'),
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'type-column'),
    				'value'=>'$data->getTypeText()',
    			),
    			array(
    				'header'=>'&nbsp;',
    				'type'=>'raw',
    				'htmlOptions'=>array('class'=>'actions-column'),
    				'value'=>'$data->getRevokeAssignmentLink()',
    			),
			)
		)); ?>

	</div>

	<div class="add-assignment last">

		<h3><?php echo Rights::t('core', 'Assign item'); ?></h3>

		<?php if( $formModel!==null ): ?>

			<div class="form">

				<?php $this->renderPartial('_form', array(
					'model'=>$formModel,
					'itemnameSelectOptions'=>$assignSelectOptions,
				)); ?>

			</div>

		<?php else: ?>

			<p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>

		<?php endif; ?>

	</div>

</div>
