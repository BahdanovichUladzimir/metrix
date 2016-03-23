<?php

/**
 * @var $model Deals
 * @var array $approveList
 * @var $videosModel XUploadForm
 * @var $linksDataProvider CActiveDataProvider
 * @var $linksModel DealLinks
 */
$this->breadcrumbs=array(
	Yii::t('userModule','Profile')=>$model->user->getPrivateUrl(),
    $model->name=>$model->getPublicUrl(),
    Yii::t('dealsModule','Video'),
);
?>
<script>
	$(document).ready(function(){
        var body = $("body");
        body.on('click','.delete-video', function(){
            if(confirm('<?=Yii::t('dealsModule',"Are you really want to delete this video?");?>')){
                var link = $(this);
                var video_id = link.data("video");
                $.ajax({
                    url:"/deals/user/userDeals/deleteVideo",
                    type: 'post',
                    data: {
                        "_method":"delete",
                        "video_id":video_id
                    },
                    beforeSend: function(){
                        link.addClass('loading');
                    },
                    success:function(data){
                        link.removeClass('loading');
                        $("#deal_video_"+video_id).remove()
                    }
                });
            }
            return false;
        });

        $('.fancybox-video').fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            arrows : false,
            helpers : {
                media : {}
            }
        });
        $('.edit-video-desc-textarea').each(function(){
            $(this).val($(this).data('value'));
        });
        body.on('change','.edit-video-desc-textarea', function(){
            var textarea = $(this);
            var group = textarea.closest(".form-group");
            var video_id = textarea.attr('id').substr(25);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/userDeals/setVideoDescription",
                type: 'post',
                data: {
                    video_id:video_id, description: description
                },
                beforeSend: function(){
                    textarea.addClass('loading');
                },
                success:function(json){
                    textarea.removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        group.find('.help-block').text(response.message).show();
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

        body.on('change','.edit-video-alias-textfield', function(){
            var field = $(this);
            var group = field.closest(".form-group");
            var video_id = field.attr('id').substr(27);
            var alias = field.val();
            $.ajax({
                url:"/deals/user/userDeals/setVideoAlias",
                type: 'post',
                data: {
                    video_id:video_id, alias: alias
                },
                beforeSend: function(){
                    field.addClass('loading');
                },
                success:function(json){
                    field.removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        group.find('.help-block').text(response.message).show();
                        /*setTimeout(function(){
                         $('#'+modal_id).modal('hide');
                         }, 1000);*/
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
        $('#check_all_link').click(function(){
            $('input[name="delete"]').prop('checked','checked');
            return false;
        });
        $('#uncheck_all_link').click(function(){
            $('input[name="delete"]').removeProp('checked');
            return false;
        });
        $('#delete_checked_link').click(function(){
            var checked = $('input[name="delete"]:checked');

                if (confirm('<?=Yii::t('dealsModule',"Are you sure?");?>')){
                    checked.each(function () {
                        var checkbox = $(this);
                        var video_id = checkbox.data("video_id");
                        $.ajax({
                            url: "/deals/user/userDeals/deleteVideo",
                            type: 'post',
                            data: {
                                "_method": "delete",
                                "video_id": video_id
                            },
                            beforeSend: function () {
                                checkbox.addClass('loading');
                            },
                            success: function (data) {
                                checkbox.removeClass('loading');
                                $("#deal_video_" + video_id).remove();
                                $(window).trigger('userVideos.count.change');
                            }
                        });
                    });
                }

            return false;
        });
    });
    $(function () {
        $('[data-tooltip="tooltip"]').tooltip()
    })

</script>
<h1 class="title section-title"><?=Yii::t('dealsModule','Add video');?></h1>
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p><strong>Внимание!</strong> Перед публикацией на сайте, загруженное видео должно пройти модерацию. Иногда для этого требуется некоторое время.</p>
</div>
<?php Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyAtc_4SE2BhMel6_WVpSBAjAeF1iczXUow&sensor=false");?>
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


<div class="cf">
    <ul class="nav nav-tabs navbar-left">
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/update', array('id'=> $model->id));?>">1. <?=Yii::t('dealsModule','Information');?></a></li>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/photo', array('id'=> $model->id));?>">2. <?=Yii::t('dealsModule','Photo');?></a></li>
        <li class="active"><a href="#">3. <?=Yii::t('dealsModule','Video');?></a></li>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/socialMediaVideo', array('id'=> $model->id));?>">4. <?=Yii::t('dealsModule','Youtube/Vimeo video');?></a></li>
    </ul>
</div>

<div class="tab-content">
    <div id="add-photo" class="tab-pane active">
        <?php
        $this->widget('widgets.MyXUpload.MyXUploadWidget', array(
            'url' => Yii::app()->createUrl("/deals/user/userDeals/uploadVideo",array('deal_id' => $model->id)),
            'model' => $videosModel,
            'attribute' => 'file',
            'multiple' => true,
            'autoUpload' => true,
            'formView' => 'videos_form',
            'uploadView' => 'video_upload',
            'downloadView' => 'video_download',
            'deal' => $model
        ));
        ?>
    </div>
</div>



