<?php
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('userModule','Users')=>array('/admin/users'),
	$model->username,
);
$ips = UsersIps::model()->findAllByAttributes(array("user_id" => $model->id));
/*$this->menu=array(
    array('label'=>Yii::t('userModule','Create User'), 'url'=>array('create')),
    array('label'=>Yii::t('userModule','Update User'), 'url'=>array('update','id'=>$model->id)),
    array('label'=>Yii::t('userModule','Delete User'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('userModule','Are you sure to delete this item?'))),
    array('label'=>Yii::t('userModule','Manage Users'), 'url'=>array('admin')),
    array('label'=>Yii::t('userModule','Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>Yii::t('userModule','List User'), 'url'=>array('/user')),
);*/
?>
<h1><?php echo Yii::t('userModule','View User').' "'.$model->username.'"'; ?></h1>
<div class="row">
	<div class="col-xs-12">


<?php
 
	$attributes = array(
		'id',
		'username',
	);
	
	$profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	if ($profileFields) {
		foreach($profileFields as $field) {
			array_push($attributes,array(
					'label' => Yii::t('userModule',$field->title),
					'name' => $field->varname,
					'type'=>'raw',
					'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
				));
		}
	}
	
	array_push($attributes,
		//'password',
		'email',
		//'activkey',
		'create_at',
		'lastvisit_at',
		/*array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),*/
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);

	$this->widget('booster.widgets.TbDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
?>
	</div>
</div>
<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
	<li class="active"><a href="#user_ips" data-toggle="tab"><?=Yii::t('userModule','User IPs');?></a></li>
	<li><a href="#user_deals" data-toggle="tab"><?=Yii::t('userModule','User Deals');?></a></li>
	<li><a href="#user_payments" data-toggle="tab"><?=Yii::t('userModule','User Payments');?></a></li>
</ul>
<div id="my-tab-content" class="tab-content">
	<div class="tab-pane active" id="user_ips">
		<?php if(sizeof($ips)>0):?>
			<ul class="user-ips">
				<?php foreach($ips as $ip):?>
					<li><?=$ip->ip;?></li>
				<?php endforeach;?>
			</ul>
		<?php endif;?>
	</div>
	<div class="tab-pane" id="user_deals">
		<?php $deals = Deals::model()->findAllByAttributes(array('user_id' => $model->id));?>
		<?php if(sizeof($deals)>0):?>
			<ul class="user-deals">
				<?php foreach($deals as $deal):?>
					<li><?=CHtml::link($deal->name,$deal->getPublicUrl());?></li>
				<?php endforeach;?>
			</ul>
		<?php endif;?>
	</div>
	<div class="tab-pane" id="user_payments">
		<h3><?=Yii::t('userModule','Ballance');?> : <span id="user_balance"><?=$model->ballance;?></span></h3>
		<?php $userPayments = new Payments('search');?>
		<?php $userPayments->unsetAttributes();?>
		<?php $userPayments->user_id = $model->id;?>
		<h4><?=Yii::t('userModule','Payments');?>:</h4>
		<?php $this->widget('booster.widgets.TbGridView',array(
			'id'=>'payments-grid',
			'dataProvider'=>$userPayments->adminSearch(),
			'filter'=>$userPayments,
			'ajaxUrl' => Yii::app()->createUrl('/payment/backend/payments/getUserPayments', array('user_id' => $model->id)),
			'columns'=>array(
				//'id',
				//'app_category_id',
				/*array(
                    'name' => 'app_category_id',
                    'header' => 'Application category',
                    'type' => 'raw',
                    'value' => '$data->appCategory->name',
                    'filter' => AppCategories::getListData(),
                ),*/
				//'app_item_id',
				//'user_id',
                //'time',
				array(
					'name' => 'time',
					'header' => 'Date',
					'type' => 'raw',
					'value' => '$data->getFormattedDate()',
                    'filter' => false
				),
				array(
					'name' => 'type_id',
					'header' => 'Type',
					'type' => 'raw',
					'value' => '$data->type->name',
					'filter' => PaymentsTypes::getListData(),
				),
				array(
					'name' => 'typeType',
					'header' => 'Type type',
					'type' => 'raw',
					'value' => '$data->type->type',
					'filter' => PaymentsTypes::getTypesListData(),
				),

				'amount',
				'real_amount',
				array(
					'header' => Yii::t('ses', 'View'),
					'class'=>'booster.widgets.TbButtonColumn',
					'htmlOptions' => array('class' => 'col-lg-3 button-column'),
					'template'=>'{view}',
					'buttons'=>array(
						/*'delete' => array(
                                'options' => array('class' => 'btn btn-danger delete'),
                                'visible' => "Yii::app()->user->checkAccess('Payment.Backend.Payments.Delete')",
                            ),
                            'update' => array(
                                'options' => array('class' => 'btn btn-success update'),
                                'visible' => "Yii::app()->user->checkAccess('Payment.Backend.Payments.Update')",
                            ),*/
						'view' => array(
							'options' => array('class' => 'btn btn-info view')
						),
					),
				),
			),
		)); ?>
		<div class="messages"></div>
		<?=CHtml::beginForm(Yii::app()->createUrl('/payment/backend/payments/addBonus'),'post',array('id'>'add_bonus_form', 'class' => 'form-inline'));?>
		<?=CHtml::hiddenField('user_id',$model->id);?>
		<div class="form-group">
			<?=CHtml::textField('count','', array('class'=>'form-control'));?>
			<?=CHtml::ajaxSubmitButton(
				Yii::t('paymentModule','Add bonus'),
				Yii::app()->createUrl('/payment/backend/payments/addBonus'),
				array(
					'update' => '.messages',
					'success' => 'js:function(json){
                        $.fn.yiiGridView.update("payments-grid");
                        $("#user_balance").text(json.user_balance);
                    }',
                    'dataType' => 'json'
				),
				array('class' => 'btn btn-success')
			);?>

		</div>
		<?=CHtml::endForm();?>
		<?=CHtml::beginForm(Yii::app()->createUrl('/payment/backend/payments/addFine'),'post',array('id'>'add_fine_form', 'class' => 'form-inline'));?>
		<?=CHtml::hiddenField('user_id',$model->id);?>
		<div class="form-group">
			<?=CHtml::textField('count','', array('class'=>'form-control'));?>
			<?=CHtml::ajaxSubmitButton(
				Yii::t('paymentModule','Add fine'),
				Yii::app()->createUrl('/payment/backend/payments/addFine'),
				array(
					'update' => '.messages',
					'success' => 'js:function(json){
                        $.fn.yiiGridView.update("payments-grid");
                        $("#user_balance").text(json.user_balance);
                    }',
                    'dataType' => 'json'
                ),
				array('class' => 'btn btn-danger')
			);?>

		</div>
		<?=CHtml::endForm();?>
	</div>

</div>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$('#tabs').tab();
	});
</script>
<div class="row spacer-10">

</div>
<div class="row">
	<div class="col-xs-12">
		<?php echo CHtml::link(Yii::t('core','Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>
		<?php echo CHtml::link(Yii::t('core','Edit'),Yii::app()->createUrl('/user/backend/default/update',array('id' => $model->id)),array('class' => 'btn btn-success'));?>
	</div>
</div>



