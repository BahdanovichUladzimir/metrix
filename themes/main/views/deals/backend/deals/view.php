<?php

/**
 * @var $model Deals
 * @var array $approveList
 * @var $imagesModel XUploadForm
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Deals')=>array('index'),
	$model->name,
);

?>
<script>
	$(document).ready(function() {
		$(".fancybox").fancybox();
		$('.fancybox-media').fancybox({
			openEffect : 'fade',
			closeEffect : 'elastic',
			//prevEffect : 'none',
			//nextEffect : 'none',
			arrows : false,
			helpers : {
				media : {}
			}
		});
	});

</script>
<h1><?=Yii::t('dealsModule','View Deal');?> <?php echo $model->name; ?></h1>
<?php if(sizeof($model->dealsImages)>0):?>
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
			<h3><?=Yii::t('dealsModule','Deal images');?></h3>
		</div>
	</div>
<?php endif;?>
<div class="row">
	<?php $counter = 1;?>
	<?php foreach($model->dealsImages as $image):?>
		<div class="col-xs-2 col-md-2 col-lg-2 col-sm-2 deal-image-thumb-container" id="deal_image_<?=$image->id;?>">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<a href="<?=$image->getLargeThumbUrl();?>" class="thumbnail fancybox deal-image-thumb" rel="images-group">
						<img src="<?=$image->getSmallThumbUrl();?>" class="" alt="<?=$image->name;?>" />
					</a>
				</div>
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<?php echo CHtml::ajaxLink(
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/backend/deals/unApproveImage', array(
							"_method" => "unApprove",
							"image_id" => $image->id,
						)),
						$ajaxOptions=array (
							'type'=>'POST',
							'dataType'=>'json',
							'success'=>'function(data){
								if(data == 1){
									var container = $("#deal_image_'.$image->id.'");
									var approve_btn = container.find(".image-approve-btn");
									var unapprove_btn = container.find(".image-unapprove-btn");
									unapprove_btn.hide();
									approve_btn.show();
								}
								else{
									console.log(data);
								}
							}',
						),
						$htmlOptions=array(
							'class' => 'btn btn-success btn-sm image-unapprove-btn',
							'data-toggle'=>"tooltip",
							'data-original-title'=>Yii::t("core","UnApprove"),
							'style' => ($image->approve == 1)?"":"display:none;"
						)
					);?>
					<?php echo CHtml::ajaxLink(
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/backend/deals/approveImage', array(
							"_method" => "approve",
							"image_id" => $image->id,
						)),
						$ajaxOptions=array (
							'type'=>'POST',
							'dataType'=>'json',
							'success'=>'function(data){
								if(data == 1){
									var container = $("#deal_image_'.$image->id.'");
									var approve_btn = container.find(".image-approve-btn");
									var unapprove_btn = container.find(".image-unapprove-btn");
									approve_btn.hide();
									unapprove_btn.show();
								}
								else{
									console.log(data);
								}
							}',
						),
						$htmlOptions=array(
							'class' => 'btn btn-default btn-sm image-approve-btn',
							'data-toggle'=>"tooltip",
							'data-original-title'=>Yii::t("core","Approve"),
							'style' => ($image->approve == 0)?"":"display:none;"

						)
					);?>

					<?php echo CHtml::ajaxLink(
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/backend/deals/deleteImage', array(
							"_method" => "delete",
							"file" => $image->file_name,
							"deal_id" => $image->deal_id,
							"image_id" => $image->id,
						)),
						$ajaxOptions=array (
							'type'=>'POST',
							'dataType'=>'json',
							'success'=>'function(data){
								$("#deal_image_'.$image->id.'").remove()
							}',
						),
						$htmlOptions=array(
							'class' => 'btn btn-danger btn-sm',
							'data-toggle'=>"tooltip",
							'data-original-title'=>Yii::t("core","Delete"),
						)
					);?>

				</div>
			</div>

		</div>
		<?php $counter++;?>
	<?php endforeach;?>
</div>
<?php if(sizeof($model->dealsVideos)>0):?>
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
			<h3><?=Yii::t('dealsModule','Deal videos');?></h3>
		</div>
	</div>
<?php endif;?>
<div class="row">
	<?php $counter = 1;?>
	<?php foreach($model->dealsVideos as $video):?>
		<div class="col-xs-2 col-md-2 col-lg-2 col-sm-2 deal-video-thumb-container" id="deal_video_<?=$video->id;?>">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<a href="<?=Yii::app()->request->baseUrl.'/js/uppod.swf?file='.$video->url;?>" class="thumbnail fancybox-media deal-video-thumb" rel="videos-group">
						<img src="<?=$video->getSmallThumbUrl();?>" alt="<?=$video->name;?>" />
					</a>
				</div>
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<?php echo CHtml::ajaxLink(
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/backend/deals/unApproveVideo', array(
							"_method" => "unApprove",
							"video_id" => $video->id,
						)),
						$ajaxOptions=array (
							'type'=>'POST',
							'dataType'=>'json',
							'success'=>'function(data){
								if(data == 1){
									var container = $("#deal_video_'.$video->id.'");
									var approve_btn = container.find(".video-approve-btn");
									var unapprove_btn = container.find(".video-unapprove-btn");
									unapprove_btn.hide();
									approve_btn.show();
								}
								else{
									console.log(data);
								}
							}',
						),
						$htmlOptions=array(
							'class' => 'btn btn-success btn-sm video-unapprove-btn',
							'data-toggle'=>"tooltip",
							'data-original-title'=>Yii::t("core","UnApprove"),
							'style' => ($video->approve == 1)?"":"display:none;"
						)
					);?>
					<?php echo CHtml::ajaxLink(
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/backend/deals/approveVideo', array(
							"_method" => "approve",
							"video_id" => $video->id,
						)),
						$ajaxOptions=array (
							'type'=>'POST',
							'dataType'=>'json',
							'success'=>'function(data){
								if(data == 1){
									var container = $("#deal_video_'.$video->id.'");
									var approve_btn = container.find(".video-approve-btn");
									var unapprove_btn = container.find(".video-unapprove-btn");
									approve_btn.hide();
									unapprove_btn.show();
								}
								else{
									console.log(data);
								}
							}',
						),
						$htmlOptions=array(
							'class' => 'btn btn-default btn-sm video-approve-btn',
							'data-toggle'=>"tooltip",
							'data-original-title'=>Yii::t("core","Approve"),
							'style' => ($video->approve == 0)?"":"display:none;"

						)
					);?>

					<?php echo CHtml::ajaxLink(
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/backend/deals/deleteVideo', array(
							"_method" => "delete",
							"file" => $video->file_name,
							"deal_id" => $video->deal_id,
							"video_id" => $video->id,
						)),
						$ajaxOptions=array (
							'type'=>'POST',
							'dataType'=>'json',
							'success'=>'function(data){
								$("#deal_video_'.$video->id.'").remove()
							}',
						),
						$htmlOptions=array(
							'class' => 'btn btn-danger btn-sm',
							'data-toggle'=>"tooltip",
							'data-original-title'=>Yii::t("core","Delete"),
						)
					);?>
				</div>
			</div>

			<?php
/*
				$this->widget('ext.Yiippod.Yiippod', array(
					'video'=>$video->url, //if you don't use playlist
					//'video'=>"http://www.youtube.com/watch?v=qD2olIdUGd8", //if you use playlist
					'id' => 'yiippodplayer_'.$video->id,
					'autoplay'=>false,
					'width'=>500,
					'view'=>6,
					'height'=>500,
					'bgcolor'=>'#000'
				));

			*/?>

		</div>
		<?php $counter++;?>
	<?php endforeach;?>
</div>
<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
		<h3><?=Yii::t('dealsModule','Upload new image/video');?></h3>
	</div>
</div>
<div class="well">
	<?php
	$this->widget('xupload.XUpload', array(
		'url' => Yii::app()->createUrl("/deals/backend/deals/upload",array('deal_id' => $model->id)),
		'model' => $imagesModel,
		'attribute' => 'file',
		'multiple' => true,
		'autoUpload' => true
	));
	?>
</div>
<?php $dealParams = array();?>
<?php foreach($model->dealsParamsValues as $param):?>
    <?php $dealParams[] = array(
        'name' => $param->param->label,
        'type' => "raw",
        'value' => $param->value
    );
    ;?>
<?php endforeach;?>
<?php $this->widget('booster.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>CMap::mergeArray(
        array(
            'id',
            'name',
            'intro',
            array(
                'name' => 'approve',
                'type' => 'raw',
                'value' => $approveList[$model->approve]
            ),
            'description',
            'price',
            array(
                'name' => 'user_id',
                'type' => 'raw',
                'value' => CHtml::link($model->user_id."(".User::model()->findByPk($model->user_id)->username.")",User::model()->findByPk($model->user_id)->getAdminUrl())
            ),
            'status_id',
            array(
                'name' => 'created_date',
                'type' => 'raw',
                'value' => $model->formattedCreatedDate
            ),
            array(
                'name' => 'reply_date',
                'type' => 'raw',
                'value' => $model->formattedPublishedDate
            ),
            'priority'
        ),
        $dealParams
    ),
)); ?>
<p>
	<?php echo CHtml::link(
		Yii::t('adminModule', 'Edit'),
		array(
			'update',
			'id'=>$model->id,
		),
		array(
			'class'=>'btn btn-success',
		)
	);?>
</p>

