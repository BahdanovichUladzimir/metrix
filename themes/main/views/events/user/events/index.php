<?php

/**
 * @var $model Events
 */
$this->breadcrumbs=array(
	Yii::t('eventsModule','Events')
);
?>
<section>
	<h1 class="title section-title h1"><?php echo Yii::t('userModule','Your profile'); ?></h1>
	<div class="messages">
		<?php if( Yii::app()->user->hasFlash('profileMessage')):?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
			</div>
		<?php endif; ?>

		<?php if( Yii::app()->user->hasFlash('profileMessageError')):?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo Yii::app()->user->getFlash('profileMessageError'); ?>
			</div>
		<?php endif; ?>

		<?php if( Yii::app()->user->hasFlash('deleteDeal')):?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo Yii::app()->user->getFlash('deleteDeal'); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="cf">
		<ul class="nav nav-tabs navbar-left">
			<?php if(sizeof($model->deals)>0):?>
				<li class="active"><a href="#offers" data-toggle="tab"><?=Yii::t('dealsModule','My deals');?></a></li>
			<?php endif;?>
			<li><a href="#events" data-toggle="tab"><?=Yii::t('eventsModule','My events');?></a></li>
		</ul>
	</div>
	<div class="tab-content">
		<?php if(sizeof($model->deals)>0):?>
			<div id="offers" class="tab-pane active">
				<?php foreach($model->deals as $deal):?>
					<div class="panel panel-default user-service" id="user_deal_<?=$deal->id;?>">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-6">
									<div class="bottom-container">
										<div><?=CHtml::link($deal->name,$deal->getPublicUrl());?></div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="bottom-container">
										<div class="price">
											<?php $this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
												'deal'=>$deal,
											));?>
										</div>
										<div class="deal-rating-widget-container">
											<?php $this->widget('modules.deals.widgets.dealRating.DealRatingWidget', array(
												'deal'=>$deal,
											));?>

										</div>


										<?php $this->widget('modules.deals.widgets.dealStatistics.DealStatisticsWidget', array(
											'deal'=>$deal,
										));?>
										<div>
											<div class="edit-wrap">
												<a href="#" class="edit b-spr"></a>
												<ul class="dropdown-menu">
													<li><?=CHtml::link(Yii::t('ses','Edit'),Yii::app()->createUrl('/deals/user/userDeals/update', array('id'=>$deal->id)));?></li>
													<li>
														<?=CHtml::ajaxLink(
															Yii::t('ses','Update'),
															array(
																'/deals/user/userDeals/setDealUpdatedDate',
																'deal_id'=>$deal->id,
															),
															array(
																'type'=>'POST',
																'success'=>'js:function(data){
                                                                console.log(data);
                                                            }'
															),
															array(
																'class' => 'delete'
															)
														);?>
													</li>
													<!--<li><a href="#">Скрыть</a></li>-->
													<li>
														<?=CHtml::ajaxLink(
															Yii::t('ses','Delete'),
															array(
																'/deals/user/userDeals/delete',
																'id'=>$deal->id,
															),
															array(
																'type'=>'POST',
																'dataType'=> 'json',
																'success'=>'js:function(data){
                                                                if(data.status == "success"){
                                                                    $("#user_deal_'.$deal->id.'").remove();
                                                                }
                                                                $(".messages").append(data.html);
                                                            }',
															),
															array(
																'class' => 'delete',
																'confirm'=>Yii::t('userModule','Are you sure?')
															)
														);?>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach;?>

			</div>
		<?php endif;?>
	</div>
</section>
<h1><?=Yii::t('eventsModule','Manage events');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('core','Create new event'),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'events-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'value' => 'CHtml::link($data->id,Yii::app()->createUrl("/events//user/events/view", array("id" => $data->id)))',
			'type' => 'raw'
		),
		array(
			'name' => 'name',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'value' => 'CHtml::link($data->name,Yii::app()->createUrl("/events//user/events/view", array("id" => $data->id)))',
			'type' => 'raw'
		),
		'description',
		array(
			'name' => 'user_id',
			'header' => 'User ID',
			'type' => 'raw',
			'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
		),
		array(
			'name' => 'status_id',
			'header' => 'Status',
			'type' => 'raw',
			'value' => 'Events::getStatusesListData()[$data->status_id]',
			'filter' => Events::getStatusesListData(),
		),
		array(
			'name' => 'type_id',
			'header' => 'Type',
			'type' => 'raw',
			'value' => '$data->type->label',
			'filter' => EventsTypes::getListData(),
		),
        array(
            'name' => 'public_status_id',
            'header' => 'Public status',
            'type' => 'raw',
            'value' => 'Events::getPublicStatusesListData()[$data->public_status_id]',
            'filter' => Events::getPublicStatusesListData(),
        ),

        /*
        'public_status_id',
        'url',
        'login',
        'password',
        */
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(

            'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => 'Yii::app()->user->checkAccess("Events.Backend.Events.Delete")'
            ),
            'update' => array(
                'options' => array('class' => 'btn btn-success update'),
                'visible' => 'Yii::app()->user->checkAccess("Events.Frontend.Events.Update")',
                'url'=>'Yii::app()->createUrl("/events/user/events/update", array("id" => $data->id))',

            ),
            'view' => array(
                'options' => array('class' => 'btn btn-info view'),
                'url' => 'Yii::app()->createUrl("/events/user/events/view", array("id" => $data->id))',
                'visible' => 'Yii::app()->user->checkAccess("Deals.Backend.Deals.View")'
            ),

        ),
		),
	),
)); ?>
