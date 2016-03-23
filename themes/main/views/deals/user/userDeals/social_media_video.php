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
    Yii::t('dealsModule','Social media video'),
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
		//$(".fancybox").fancybox();
        /*$(".fancybox").fancybox(
            {
                openEffect : 'fade',
                closeEffect : 'elastic',
                //prevEffect : 'none',
                //nextEffect : 'none',
                arrows : false,
                helpers : {
                    media : {}
                }
            }
        );*/
        $('.edit-video-desc-textarea').each(function(){
            $(this).val($(this).data('value'));
        });
        body.on('change','.edit-link-desc-textarea', function(){
            var textarea = $(this);
            var group = textarea.closest(".form-group");
            var link_id = textarea.attr('id').substr(24);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/dealLinks/setLinkDescription",
                type: 'post',
                data: {
                    link_id:link_id, description: description
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

        body.on('change','.edit-link-alias-textfield', function(){
            var field = $(this);
            var group = field.closest(".form-group");
            var link_id = field.attr('id').substr(26);
            var alias = field.val();
            $.ajax({
                url:"/deals/user/dealLinks/setLinkAlias",
                type: 'post',
                data: {
                    link_id:link_id, alias: alias
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
            if (checked.length>0 && confirm('<?=Yii::t('dealsModule',"Are you sure?");?>')){
                checked.each(function(){
                    var checkbox = $(this);
                    var link_id = checkbox.data("link_id");
                     $.ajax({
                         url: "<?=Yii::app()->createUrl('/deals/user/dealLinks/delete')?>",
                         type: 'post',
                         dataType: 'json',
                         data: {
                             "_method": "delete",
                             "link_id": link_id
                         },
                         beforeSend: function () {
                             checkbox.addClass('loading');
                         },
                         success: function (data) {
                             console.log(data);
                             checkbox.removeClass('loading');
                             if(data.status == "success"){
                                 $(window).trigger('userLinks.count.change');
                                 $("#deal_social_link_"+ link_id).remove();
                                 $("#add_link_messages_container").append(data.html);
                             }
                             else{
                                 $("#add_link_messages_container").append(data.html);
                             }
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
<script>
    $(document).ready(function(){

        $('.fancybox-video').fancybox({
            openEffect  : 'none',
            closeEffect : 'none',
            arrows : false,
            helpers : {
                media : {}
            }
        });
        $(".fancybox").fancybox();
        $('.fancybox-video-vimeo')
            .attr('rel', 'media-gallery')
            .fancybox({
                openEffect : 'none',
                closeEffect : 'none',
                prevEffect : 'none',
                nextEffect : 'none',

                arrows : false,
                helpers : {
                    media : {},
                    buttons : {}
                }
            });
    });

</script>
<h1 class="title section-title"><?=Yii::t('dealsModule','Add Youtube/Vimeo video');?></h1>
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p><strong>Внимание!</strong> Перед публикацией на сайте, добавленное видео должно пройти модерацию. Иногда для этого требуется некоторое время.</p>
</div>
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

<?php /*if(!$model->isNewRecord):*/?><!--
    <?php /*echo CHtml::link(Yii::t('core', 'View deal on site'),$model->getPublicUrl(), array('class' => 'btn btn-info'));*/?>

    <?php /*echo CHtml::link(Yii::t('core', 'View deal in my profile'),$model->getUserUrl(), array('class' => 'btn btn-info'));*/?>
--><?php /*endif;*/?>

<div class="cf">
    <ul class="nav nav-tabs navbar-left">
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/update', array('id'=> $model->id));?>">1. <?=Yii::t('dealsModule','Information');?></a></li>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/photo', array('id'=> $model->id));?>">2. <?=Yii::t('dealsModule','Photo');?></a></li>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/video', array('id'=> $model->id));?>">3. <?=Yii::t('dealsModule','Video');?></a></li>
        <li class="active"><a href="#">3. <?=Yii::t('dealsModule','Youtube/Vimeo video');?></a></li>
    </ul>
</div>

<div class="tab-content">
    <div id="add_social_media_link" class="tab-pane active">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php $this->renderPartial('//deals/user/dealLinks/_form', array("model" => $linksModel, 'deal' => $model));?>

                <div  class="functions cf fileupload-buttonbar">
                    <!--<span class="col-info pull-right">Загруженно <span data-count="<?/*=sizeof($model->dealLinks);*/?>" id="files_count"><?/*=sizeof($model->dealLinks);*/?></span> файлов</span>-->
                    <ul>
                        <li><a href="#" id="check_all_link"><?=Yii::t('dealsModule', 'Check all');?></a></li>
                        <li><a href="#" id="uncheck_all_link"><?=Yii::t('dealsModule', 'Uncheck all');?></a></li>
                        <li><a href="#" id="delete_checked_link"><?=Yii::t('dealsModule', 'Delete checked');?></a></li>
                    </ul>
                </div>

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

                <div class="add-bottom-nav">
                    <!--<a href="#">Отмена</a>-->
                    <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default back b'));?>
                    <a href="<?=$model->getPublicUrl();?>" class="btn btn-default"><?=Yii::t('dealsModule',"View");?></a>
                </div>
            </div>
        </div>
    </div>
</div>



