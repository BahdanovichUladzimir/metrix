<?php
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('userModule','Users')
);?>
<h1><?php echo Yii::t('userModule',"Manage Users"); ?></h1>

<p><?php echo Yii::t('userModule',"You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>
<?php if( Yii::app()->user->hasFlash('userModule.userDeleteSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('userModule.userDeleteSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('userModule.userDeleteError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('userModule.userDeleteError'); ?>
	</div>
<?php endif; ?>
<?php $this->widget('booster.widgets.TbExtendedGridView', array(
	'id'=>'user-grid',
	'type'=>'striped condensed',
	'dataProvider'=>$model->search(),
	'ajaxUpdate' => false,
	'filter'=>$model,

	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("view","id"=>$data->id))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		'lastvisit_at',
		/*array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),*/
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'header' => Yii::t('userModule', 'Last user Ip'),
			'type' => 'raw',
			'value'=>'$data->getLastIp()',
		),
		array(
			'header' => Yii::t('ses', 'Edit'),
			'class'  => 'booster.widgets.TbButtonColumn',
		),
	),
)); ?>
