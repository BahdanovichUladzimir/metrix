<?php
/**
 * @var $model Deals
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('adminModule','Deals')=>array('index'),
	Yii::t('adminModule','Manage'),
);
?>

<h1><?=Yii::t('dealsModule','Manage Deals');?></h1>
	<?php /*echo CHtml::link(
		Yii::t('dealsModule', 'Create new Deal'),
		array('/user/create'),
		array(
			'class'=>'btn btn-success',
		)
	);*/?>
<?php if( Yii::app()->user->hasFlash('backendDealsSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('backendDealsSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('backendDealsError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('backendDealsError'); ?>
	</div>
<?php endif; ?>
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'deals-grid',
	'dataProvider'=>$model->adminSearch(),
	'filter'=>$model,
	'sortableRows'=>true,
	//'template' => '{pager}{items}{pager}',
	'enablePagination' => true,
	'ajaxUpdate'=>false,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'value' => 'CHtml::link($data->id,$data->getPublicUrl())',
			'type' => 'raw'
		),
		array(
			'name' => 'name',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			),
			'value' => 'CHtml::link($data->name,$data->getPublicUrl())',
			'type' => 'raw'
		),
		//'intro',
		array(
			'name' => 'user_id',
			'header' => 'User ID',
			'type' => 'raw',
			'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
		),
		array(
			'name' => 'city_id',
			'header' => 'City',
			'type' => 'raw',
			'value' => '$data->city->name',
            'filter' => CHtml::listData(Cities::model()->findAll(),'id','name'),

        ),
		//'description',

		array(
			'name' => 'created_date',
			'header' => 'Created date',
			'type' => 'raw',
			'value' => 'date("d.m.Y", $data->created_date)',
		),
		//'created_date',
		//'published_date',
		array(
			'name' => 'categoriesSearch',
			'header' => 'Category',
			'type' => 'raw',
			'value' => '$data->getCategoriesString()',
			'filter' => DealsCategories::getListData(true, false),
		),
        array(
            'name' => 'approve',
            'header' => 'Approve',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'type' => 'raw',
            'value' => function($data) {
                if($data->approve == 0){
                    $html = "<h5 class='text-danger'><i class='glyphicon glyphicon-ban-circle'></i></h5>";
                }
                elseif($data->approve == 1){
                    $html = "<h5 class='text-success'><i class='glyphicon glyphicon-ok'></i></h5>";
                }
                elseif($data->approve == 2){
                    $html = "<h5 class='text-warning'><i class='glyphicon glyphicon-question-sign'></i></h5>";
                }
                else{
                    $html = "<h5>Undefined approve status</h5>";
                }
                return $html;
            },
            'filter' => Deals::getApproveListData(),
        ),
		array(
            'name' => "paid",
            'value' => function($data){
                return Deals::$paidStatuses[$data->paid];
            },
            'filter' => Deals::$paidStatuses,
        ),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{approve} {unapprove} {update} {delete} {forRevision} {publishToVk}',
		'buttons'=>array(
			'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => 'Yii::app()->user->checkAccess("Deals.Backend.Deals.Delete")'
            ),
			'update' => array(
				'options' => array('class' => 'btn btn-success update'),
                'visible' => 'Yii::app()->user->checkAccess("Deals.Backend.Deals.Update")',
                'url'=>'Yii::app()->createUrl("/deals/user/userDeals/update", array("id" => $data->id))',

            ),
			'view' => array(
				'options' => array('class' => 'btn btn-info view'),
				'url' => '$data->getPublicUrl()',
                'visible' => 'Yii::app()->user->checkAccess("Deals.Backend.Deals.View")'
            ),
            'approve' => array(
                'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                'url'=>'Yii::app()->createUrl("/deals/backend/deals/approve", array("id" => $data->id))',
                //'imageUrl'=>'...',
                'options' => array(
                    'class' => 'btn btn-default',
                    'rel' => 'tooltip',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('dealsModule', 'Approve'),
                    'ajax' => array(
						'type' => 'get',
						'url'=>'js:$(this).attr("href")',
                        'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure you want to approve the deal?').'");}',
						'success' => 'js:function(data) { $.fn.yiiGridView.update("deals-grid")}'
					)
                ),
				'visible'=>'$data->approve == 0 || $data->approve == 2',
            ),
            'unapprove' => array(
                'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                'url'=>'Yii::app()->createUrl("/deals/backend/deals/unApprove", array("id" => $data->id))',
                //'imageUrl'=>'...',
                'options' => array(
                    'class' => 'btn btn-success',
                    'rel' => 'tooltip',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('dealsModule', 'UnApprove'),
                    'ajax' => array(
                        'type' => 'get',
                        'url'=>'js:$(this).attr("href")',
                        'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure you want to reject the deal?').'");}',
                        'success' => 'js:function(data) { $.fn.yiiGridView.update("deals-grid")}'
                    )
                ),
                //'click'=>'...',
                'visible'=>'$data->approve == 1',
            ),
            'forRevision' => array(
                'label'=>'<i class="glyphicon glyphicon-question-sign"></i>',
                'url'=>'Yii::app()->createUrl("/deals/backend/deals/sentBackForRevision", array("id" => $data->id))',
                //'imageUrl'=>'...',
                'options' => array(
                    'class' => 'btn btn-warning',
                    'rel' => 'tooltip',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('dealsModule', 'Sent back for revision'),
                    'ajax' => array(
                        'type' => 'get',
                        'url'=>'js:$(this).attr("href")',
                        'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure you want to send deal for revision?').'");}',
                        'success' => 'js:function(data) { $.fn.yiiGridView.update("deals-grid")}'
                    )
                ),
                //'click'=>'...',
                'visible'=>'$data->approve == 0',
                ),
				'publishToVk' => array(
                'label'=>'<i class="glyphicon glyphicon-share"></i> VK',
                'url'=>'
                Yii::app()->createUrl(
                    "/cms/socialMediaPosting/create",
                    array(
                        "item_id" => $data->id,
                        "network" => 1,
                        "type" => 2,
                    )
                )
                ',
                //'imageUrl'=>'...',
                'options' => array(
                    'class' => 'btn btn-primary btn-sm',
                    'rel' => 'tooltip',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('dealsModule', 'Publish to Vkontakte'),
                ),
                //'click'=>'...',
                'visible'=>'Yii::app()->user->checkAccess("Cms.SocialMediaPosting.Create") && $data->approve == 1',
            ),
		),
		),
	),
)); ?>
<?=CHtml::link(
    Yii::t('cmsModule',"Publish on Vkontakte"),
    Yii::app()->createUrl(
        "/cms/socialMediaPosting/create",
        array(
            "item_id" => $model->id,
            "network" => 1,
            "type" => 1,
        )
    ),
    array('class' => 'btn btn-success')
);?>