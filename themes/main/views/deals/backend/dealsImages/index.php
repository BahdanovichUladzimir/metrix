<?php

/**
 * @var $model DealsImages
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Deals images')=>array('index'),
	Yii::t('dealsModule','Manage'),
);
?>
<script>
	$(document).ready(function(){
		$(".fancybox").fancybox();
		$(".fancy-image").on("click",function(){
			var link = $(this).closest("tr").find("a.fancybox").attr("href");
			$.fancybox({
				href:link
			})
		});
	});
</script>
<h1><?=Yii::t('dealsModule','Manage deals images');?></h1>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?=CHtml::ajaxButton(
			'Approve selected',
			Yii::app()->createUrl('/deals/backend/dealsImages/approveSelected'),
			array(
				'type' => 'POST',
				'data' => 'js:{value : $.fn.yiiGridView.getChecked("deals-images-grid","approve_check")}',
				'success'=>'js:function(data){
                    //console.log(data);
                    $.fn.yiiGridView.update("deals-images-grid");
				}'
			),
			array(
				'class' => 'btn btn-success'
			)

		);?>

	</div>
</div>

<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'deals-images-grid',
	'dataProvider'=>$model->adminSearch(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
    'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'id'=>'approve_check',
            'header' => 'Approve',
            'selectableRows' => 2,
            'disabled' => '$data->approve'
        ),
		array(
			'header' => Yii::t('dealsModule','Image size'),
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'type' => 'raw',
            'value' => '$data->width."x".$data->height'
		),
		array(
			'header' => 'Photo',
			'class' => 'bootstrap.widgets.TbImageColumn',
			'imagePathExpression'=> '$data->getSmallThumbUrl()',
			'htmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1',
			),
			'imageOptions' => array(
				'class' => 'fancy-image thumbnail',
			),
		),
        array(
            'name' => 'description',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'type' => 'raw',
            'value' => '"<strong>".$data->alias."</strong><br />".$data->description'
        ),
		/*array(
			'name' => 'path',
			'value' => 'CHtml::link($data->path,array("/deals/backend/dealsImages/view", "id" => $data->id))',
			'type' => 'raw'

		),*/
		array(
			'name' => 'deal_id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			),
			'value' => 'CHtml::link($data->deal_id,array($data->deal->getPublicUrl()))',
			'type' => 'raw'

		),
		array(
			'name' => 'deal_id.user_id',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1'
			),
			'header' => 'User',
			'value' => 'CHtml::link($data->deal->user->username,$data->deal->user->getAdminUrl())',
			'type' => 'raw'
		),
		/*'file_name',
		'ext',
		'path',
		'dir_path',
		'dir_url',
		'url',
		'width',
		'height',*/
		//'user_id',
		array(
			'name' => 'approve',
			'header' => 'Approve',
			'headerHtmlOptions' => array(
				'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
			),
			'type' => 'raw',
			'value' => function($data) {
				$html = $data->approve ? "<h5 class='text-success'><i class='glyphicon glyphicon-ok'></i></h5>" : "<h5 class='text-danger'><i class='glyphicon glyphicon-ban-circle'></i></h5>";
				return $html;
			},
			'filter' => DealsImages::getApproveListData(),
		),
		array(
			'header' => Yii::t('ses', 'Edit'),
			'class'=>'booster.widgets.TbButtonColumn',
			'htmlOptions' => array('class' => 'col-lg-3 button-column'),
			'template'=>'{approve} {view} {delete}',
			'buttons'=>array(
				'delete' => array(
					'options' => array('class' => 'btn btn-danger delete'),
					'visible' => 'Yii::app()->user->checkAccess("Deals.Backend.DealsImages.Delete")',
				),
				'approve' => array(
					'label'=>'<i class="glyphicon glyphicon-ok"></i>',
					'url'=>'Yii::app()->createUrl("/deals/backend/dealsImages/approve", array("id" => $data->id))',
					//'imageUrl'=>'...',
					'options' => array(
						'class' => 'btn btn-default',
						'rel' => 'tooltip',
						'data-toggle' => 'tooltip',
						'title' => Yii::t('dealsModule', 'Approve'),
						'ajax' => array(
							'type' => 'get',
							'url'=>'js:$(this).attr("href")',
							'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure you want to approve the image?').'");}',
							'success' => 'js:function(data) { $.fn.yiiGridView.update("deals-images-grid")}'
						)
					),
					'visible'=>'$data->approve == 0',
				),
				'unapprove' => array(
					'label'=>'<i class="glyphicon glyphicon-ok"></i>',
					'url'=>'Yii::app()->createUrl("/deals/backend/dealsImages/unApprove", array("id" => $data->id))',
					//'imageUrl'=>'...',
					'options' => array(
						'class' => 'btn btn-success',
						'rel' => 'tooltip',
						'data-toggle' => 'tooltip',
						'title' => Yii::t('dealsModule', 'UnApprove'),
						'ajax' => array(
							'type' => 'get',
							'url'=>'js:$(this).attr("href")',
							'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure you want to reject the image?').'");}',
							'success' => 'js:function(data) { $.fn.yiiGridView.update("deals-images-grid")}'
						)
						),
					//'click'=>'...',
					'visible'=>'$data->approve == 1',
				),
				'view' => array(
					'options' => array('class' => 'btn btn-info view fancybox'),
					'url'=>'$data->url',
				),
			)
		),
	),
)); ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?=CHtml::ajaxButton(
			Yii::t("dealsModule",'Approve selected'),
			Yii::app()->createUrl('/deals/backend/dealsImages/approveSelected'),
			array(
				'type' => 'POST',
				'data' => 'js:{value : $.fn.yiiGridView.getChecked("deals-images-grid","approve_check")}',
				'success'=>'js:function(data){
					 $.fn.yiiGridView.update("deals-images-grid");
		}'
			),
			array(
				'class' => 'btn btn-success'
			)

		);?>

	</div>
</div>

