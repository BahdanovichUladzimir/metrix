<?php $moduleId = Yii::app()->controller->module->getId();?>
<?php $controllerId = Yii::app()->controller->getId();?>
<?php $actionId = Yii::app()->controller->action->getId();?>
<?php $this->widget('booster.widgets.TbMenu', array(
	'firstItemCssClass'=>'first',
	'lastItemCssClass'=>'last',
	'type' => 'pills',
	'htmlOptions'=>array('class'=>'rights-nav'),
	'items'=>array(
		array(
			'label'=>Rights::t('core', 'Assignments'),
			'url'=>array('assignment/view'),
			'active' => $moduleId == "rights" && $controllerId == 'assignment',
		),
		array(
			'label'=>Rights::t('core', 'Permissions'),
			'url'=>array('/rights/authItem/permissions'),
			'active' => $moduleId == "rights" && $controllerId == 'authItem' && ($actionId == "permissions" || $actionId == "generate"),
		),
		array(
			'label'=>Rights::t('core', 'Roles'),
			'url'=>array('/rights/authItem/roles'),
			'active' => $moduleId == "rights" && $controllerId == 'authItem' && ($actionId == "roles" || $actionId == "update"),
		),
		array(
			'label'=>Rights::t('core', 'Tasks'),
			'url'=>array('/rights/authItem/tasks'),
			'active' => $moduleId == "rights" && $controllerId == 'authItem' && $actionId == "tasks",
		),
		array(
			'label'=>Rights::t('core', 'Operations'),
			'url'=>array('/rights/authItem/operations'),
			'active' => $moduleId == "rights" && $controllerId == 'authItem' && $actionId == "operations",
		),
	)
));	?>
