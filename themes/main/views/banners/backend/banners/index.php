<?php

/**
 * @var $model Banners
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('bannersModule','Banners')=>array('index'),
	Yii::t('core','Manage'),
);
?>
<script>
    $(document).ready(function(){
        $(".fancybox").fancybox();
        $(".fancy-image").on("click",function(){
            var link = $(this).attr("src");
            $.fancybox({
                href:link
            })
        });
    });
</script>
<h1><?=Yii::t('bannersModule','Manage banners');?></h1>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?=CHtml::ajaxButton(
            Yii::t("bannersModule",'Approve selected'),
            Yii::app()->createUrl('/banners/backend/banners/approveSelected'),
            array(
                'type' => 'POST',
                'data' => 'js:{value : $.fn.yiiGridView.getChecked("banners-grid","approve_check")}',
                'success'=>'js:function(data){
					 $.fn.yiiGridView.update("banners-grid");
		}'
            ),
            array(
                'class' => 'btn btn-success'
            )

        );?>

    </div>
</div>
<?php $this->widget('booster.widgets.TbGridView',array(
	'id'=>'banners-grid',
	'dataProvider'=>$model->search(),
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
            'name' => 'name',
            'headerHtmlOptions' => array(
                //'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'type' => 'raw',
            'value' => 'CHtml::link($data->name,$data->getPrivateUrl())'
        ),
        array(
            'header' => 'Image',
            'class' => 'bootstrap.widgets.TbImageColumn',
            'imagePathExpression'=> '$data->getImageUrl()',
            'htmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1',
            ),
            'imageOptions' => array(
                'class' => 'fancy-image thumbnail banner-preview',
            ),
        ),
        array(
            'name' => 'user_id',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1'
            ),
            'value' => 'CHtml::link($data->user->username,array($data->user->getPublicUrl()))',
            'type' => 'raw'
        ),
        array(
            'name' => 'link',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1'
            ),
            'value' => 'CHtml::link($data->link,$data->link)',
            'type' => 'raw'
        ),
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
            'filter' => Banners::$approves,
        ),
        array(
            'name' => 'published',
            'header' => 'Published',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'type' => 'raw',
            'value' => function($data) {
                $html = $data->published ? "<h5 class='text-success'><i class='glyphicon glyphicon-ok'></i></h5>" : "<h5 class='text-danger'><i class='glyphicon glyphicon-ban-circle'></i></h5>";
                return $html;
            },
            'filter' => Banners::$publishes,
        ),
	array(
		'header' => Yii::t('ses', 'Edit'),
		'class'=>'booster.widgets.TbButtonColumn',
		'htmlOptions' => array('class' => 'col-lg-3 button-column'),
		'template'=>'{approve} {unapprove} {delete}',
		'buttons'=>array(
            'delete' => array(
                'options' => array('class' => 'btn btn-danger delete'),
                'visible' => 'Yii::app()->user->checkAccess("Banners.Backend.Banners.Delete")',
            ),
            'approve' => array(
                'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                'url'=>'Yii::app()->createUrl("/banners/backend/banners/approve", array("id" => $data->id))',
                //'imageUrl'=>'...',
                'options' => array(
                    'class' => 'btn btn-default',
                    'rel' => 'tooltip',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('bannersModule', 'Approve'),
                    'ajax' => array(
                        'type' => 'get',
                        'url'=>'js:$(this).attr("href")',
                        'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure?').'");}',
                        'success' => 'js:function(data) { $.fn.yiiGridView.update("banners-grid")}'
                    )
                ),
                'visible'=>'$data->approve == 0',
            ),
            'unapprove' => array(
                'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                'url'=>'Yii::app()->createUrl("/banners/backend/banners/unApprove", array("id" => $data->id))',
                //'imageUrl'=>'...',
                'options' => array(
                    'class' => 'btn btn-success',
                    'rel' => 'tooltip',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('bannersModule', 'UnApprove'),
                    'ajax' => array(
                        'type' => 'get',
                        'url'=>'js:$(this).attr("href")',
                        'beforeSend'=>'js:function(){return confirm("'.Yii::t('core','Are you sure?').'");}',
                        'success' => 'js:function(data) { $.fn.yiiGridView.update("banners-grid")}'
                    )
                ),
                //'click'=>'...',
                'visible'=>'$data->approve == 1',
            ),
            /*'view' => array(
                'options' => array('class' => 'btn btn-info view'),
                'url'=>'$data->link',
            ),*/

        ),
		),
	),
)); ?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?=CHtml::ajaxButton(
			Yii::t("bannersModule",'Approve selected'),
			Yii::app()->createUrl('/banners/backend/banners/approveSelected'),
			array(
				'type' => 'POST',
				'data' => 'js:{value : $.fn.yiiGridView.getChecked("banners-grid","approve_check")}',
				'success'=>'js:function(data){
					 $.fn.yiiGridView.update("banners-grid");
		}'
			),
			array(
				'class' => 'btn btn-success'
			)

		);?>

	</div>
</div>
