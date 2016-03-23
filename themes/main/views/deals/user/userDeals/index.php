<?php
/**
 * @var $model Deals
 * @var int $userId User ID
 * @var $user User
 */
$this->breadcrumbs=array(
	Yii::t('userModule','Profile')=>$user->getPublicUrl(),
	//Yii::t('dealsModule','My deals')=>array('index'),
	Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('dealsModule','Manage my deals');?></h1>
<p>
	<?php echo CHtml::link(
		Yii::t('dealsModule', Yii::t('Deals','Create new deal')),
		array('create'),
		array(
			'class'=>'btn btn-success',
		)
	);?></p>
<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'deals-grid',
	'dataProvider'=>$model->userSearch($userId),
	//'filter'=>$model,
	'sortableRows'=>true,
	'template' => '{pager}{items}{pager}',
	'enablePagination' => true,
	//'ajaxUpdate'=>false,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'value' => 'CHtml::link($data->id,array("/deals/user/userDeals/view", "id" => $data->id))',
			'type' => 'raw'
		),
		array(
			'name' => 'name',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			),
			'value' => 'CHtml::link($data->name,array("/deals/user/userDeals/view", "id" => $data->id))',
			'type' => 'raw'
		),
		//'intro',

		array(
			'name' => 'approve',
			'header' => 'Approve',
			'type' => 'raw',
			'value' => '($data->approve == "1") ? "Approved" : "Not Approved" ',
			'filter' => Deals::getApproveListData(),
		),
		array(
			'name' => 'archive',
			'header' => 'Archive',
			'type' => 'raw',
			'value' => '($data->archive == "1") ? "Archive" : "Not Archive" ',
			'filter' => Deals::getArchiveListData(),
		),
		//'description',
		array(
			'name' => 'status_id',
			'header' => 'Status',
			'type' => 'raw',
			'value' => '$data->status->label',
			'filter' => DealsCategoriesStatuses::getListData(),
		),
		array(
			'name' => 'created_date',
			'header' => 'Created date',
			'type' => 'raw',
			'value' => '$data->formattedCreatedDate',
		),
		array(
			'name' => 'published_date',
			'header' => 'Published date',
			'type' => 'raw',
			'value' => '$data->formattedPublishedDate',
		),
		array(
			'name' => 'categoriesSearch',
			'header' => 'Category',
			'type' => 'raw',
			'value' => '$data->getCategoriesString()',
			'filter' => DealsCategories::getListData(true, false),
		),

		/*array(
			'name' => 'priority',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			)
		),*/
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{view} {update} {delete}',
		'buttons'=>array(
			'delete' => array(
					'options' => array('class' => 'btn btn-danger delete')
				),
                'update' => array(
                    'options' => array('class' => 'btn btn-success update')
                ),
                'view' => array(
                    'options' => array('class' => 'btn btn-info view'),
                    'url' => '$data->getPublicUrl()'
                ),
                /*'addToFavorites' => array(
                    'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                    'url'=>'Yii::app()->createUrl("/deals/user/userDeals/addToFavorites", array("id" => $data->id))',
                    //'imageUrl'=>'...',
                    'options' => array(
                        'class' => 'btn btn-success',
                        'rel' => 'tooltip',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('dealsModule', 'Add to favorites'),
                        'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("deals-images-grid")}')
                    ),
                    //'click'=>'...',
                    'visible' => "Yii::app()->user->checkAccess('Deals.User.UserDeals.AddToFavorites')",
                ),*/
		    ),
		),
	),
)); ?>
