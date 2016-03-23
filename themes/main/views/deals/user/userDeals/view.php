<?php

/**
 * @var $model Deals
 * @var array $approveList
 * @var $imagesModel XUploadForm
 * @var $linksDataProvider CActiveDataProvider
 * @var $linksModel DealLinks
 */
$this->breadcrumbs=array(
	Yii::t('userModule','Profile')=>$model->user->getPrivateUrl(),
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
        $('.edit-image-desc-textarea').each(function(){
            $(this).val($(this).data('value'));
        });
        $('.edit-video-desc-textarea').each(function(){
            $(this).val($(this).data('value'));
        });
        var body = $("body");
        body.on('click','.edit-image-description', function(){
            var link = $(this);
            var container = link.closest(".modal-content").find(".edit-image-desc-container");
            var modal_id = container.closest(".modal").attr('id');
            var textarea = container.find('.edit-image-desc-textarea');
            var group = container.find(".form-group");
            var image_id = textarea.attr('id').substr(25);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/userDeals/setImageDescription",
                type: 'post',
                data: {
                    image_id:image_id, description: description
                },
                beforeSend: function(){
                    link.addClass('loading');
                },
                success:function(json){
                    $(this).removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        group.find('.help-block').text(response.message).show();
                        setTimeout(function(){
                            $('#'+modal_id).modal('hide');
                        }, 1000);
                    }
                    else if(response.status == "error"){
                        group.addClass('has-error');
                        group.find('.help-block').text(response.message).show();
                    }
                    else{
                        group.addClass('has-error');
                        group.find('.help-block').text("Unknown error").show();
                    }
                }
            });
            return false;
        });
        body.on('click','.edit-video-description', function(){
            var link = $(this);
            var container = link.closest(".modal-content").find(".edit-video-desc-container");
            var modal_id = container.closest(".modal").attr('id');
            var textarea = container.find('.edit-video-desc-textarea');
            var group = container.find(".form-group");
            var video_id = textarea.attr('id').substr(25);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/userDeals/setVideoDescription",
                type: 'post',
                data: {
                    video_id:video_id, description: description
                },
                beforeSend: function(){
                    link.addClass('loading');
                },
                success:function(json){
                    link.removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        group.find('.help-block').text(response.message).show();
                        setTimeout(function(){
                            $('#'+modal_id).modal('hide');
                        }, 1000);
                    }
                    else if(response.status == "error"){
                        group.addClass('has-error');
                        group.find('.help-block').text(response.message).show();
                    }
                    else{
                        group.addClass('has-error');
                        group.find('.help-block').text("Unknown error").show();
                    }
                }
            });
            return false;
        })
	});
    $(function () {
        $('[data-tooltip="tooltip"]').tooltip()
    })

</script>
<h1><small><?=Yii::t('dealsModule','View deal');?></small> <?php echo $model->name; ?></h1>
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
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/user/userDeals/deleteImage', array(
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
                    <button type="button" class="btn btn-success btn-sm" data-tooltip="tooltip" data-toggle="modal" title="<?=Yii::t('dealsModule','Edit description');?>" data-target="#image_desc_edit_modal_<?=$image->id;?>">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </button>

                    <script>
                        $(document).ready(function(){
                            $('#image_desc_edit_modal_<?=$image->id;?>').on('hide.bs.modal', function () {
                                $(this).find('.form-group').removeClass('has-error has-success').find('.help-block').text('').hide();
                            });
                        });
                    </script>
                    <div class="modal fade" id="image_desc_edit_modal_<?=$image->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?=Yii::t('dealsModule','Edit description');?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="edit-image-desc-container" id="edit_image_desc_container_<?=$image->id;?>">
                                        <div class="form-group">
                                            <label for="edit_image_desc_textarea_<?=$image->id;?>"><?=Yii::t('dealsModule','Image description');?></label>
                                            <textarea class="form-control edit-image-desc-textarea" data-value="<?=$image->description;?>" placeholder="<?=Yii::t('dealsModule','Enter comment');?>" id="edit_image_desc_textarea_<?=$image->id;?>" rows="3"></textarea>
                                            <span class="help-block" style="display:none"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <a class="btn btn-success edit-image-description" href=""><?=Yii::t('core','Save');?></a>
                                </div>
                            </div>
                        </div>
                    </div>

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
						$text = Yii::t('dealsModule',"<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>"),
						$url = Yii::app()->createUrl('/deals/user/userDeals/deleteVideo', array(
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
                    <button type="button" class="btn btn-success btn-sm" data-tooltip="tooltip" data-toggle="modal" title="<?=Yii::t('dealsModule','Edit description');?>" data-target="#video_desc_edit_modal_<?=$video->id;?>">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </button>

                    <!-- Modal -->
                    <script>
                        $(document).ready(function(){
                            $('#video_desc_edit_modal_<?=$video->id;?>').on('hide.bs.modal', function () {
                                $(this).find('.form-group').removeClass('has-error has-success').find('.help-block').text('').hide();
                            });
                        });
                    </script>
                    <div class="modal fade" id="video_desc_edit_modal_<?=$video->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?=Yii::t('dealsModule','Edit description');?></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="edit-video-desc-container" id="edit_video_desc_container_<?=$video->id;?>">
                                        <div class="form-group">
                                            <label for="edit_video_desc_textarea_<?=$video->id;?>"><?=Yii::t('dealsModule','Video description');?></label>
                                            <textarea class="form-control edit-video-desc-textarea" data-value="<?=$video->description;?>" placeholder="<?=Yii::t('dealsModule','Enter comment');?>" id="edit_video_desc_textarea_<?=$video->id;?>" rows="3"></textarea>
                                            <span class="help-block" style="display:none"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <a class="btn btn-success edit-video-description" href=""><?=Yii::t('core','Save');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>


		</div>
		<?php $counter++;?>
	<?php endforeach;?>
    <?php $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$linksDataProvider,
        'itemView'=>'//deals/user/dealLinks/_view',   // refers to the partial view named '_post'
        'id' => 'user_youtube_links_list',
        /*'sortableAttributes'=>array(
            'title',
            'create_time'=>'Post Time',
        ),*/
        'template' => '{items}',
        'summaryText' => '',
        'ajaxUpdate' => true,
        //class="pagination pagination-centered"
    ));?>
</div>

<div class="well">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
            <h3><?=Yii::t('dealsModule','Upload new image/video');?></h3>
        </div>
    </div>
	<?php
	$this->widget('xupload.XUpload', array(
		'url' => Yii::app()->createUrl("/deals/user/userDeals/upload",array('deal_id' => $model->id)),
		'model' => $imagesModel,
		'attribute' => 'file',
		'multiple' => true,
		'autoUpload' => true
	));
	?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
            <h3><?=Yii::t('dealsModule','Add new youtube link');?></h3>
        </div>
    </div>
    <?php $this->renderPartial('//deals/user/dealLinks/_form', array("model" => $linksModel, 'deal' => $model));?>
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
            /*array(
                'name' => 'user_id',
                'type' => 'raw',
                'value' => CHtml::link($model->user_id."(".User::model()->findByPk($model->user_id)->username.")",User::model()->findByPk($model->user_id)->getAdminUrl())
            ),*/
            array(
                'name' => 'status_id',
                'type' => 'raw',
                'value' => $model->status->label
            ),
            array(
                'name' => 'created_date',
                'type' => 'raw',
                'value' => $model->formattedCreatedDate
            ),
            array(
                'name' => 'published_date',
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
