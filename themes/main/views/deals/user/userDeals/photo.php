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
    $model->name=>$model->getPublicUrl(),
    Yii::t('dealsModule','Photo'),
);
?>
<script>
	$(document).ready(function(){
        var body = $("body");
        body.on('click','.delete-image', function(){
            if(confirm('<?=Yii::t('dealsModule',"Are you really want to delete this image?");?>')){
                var link = $(this);
                var image_id = link.data("image");
                $.ajax({
                    url:"/deals/user/userDeals/deleteImage",
                    type: 'post',
                    data: {
                        "_method":"delete",
                        "image_id":image_id
                    },
                    beforeSend: function(){
                        link.addClass('loading');
                    },
                    success:function(data){
                        link.removeClass('loading');
                        $("#deal_image_"+image_id).remove()
                    }
                });
            }
            return false;
        });
		$(".fancybox").fancybox();

        $('.edit-image-desc-textarea').each(function(){
            $(this).val($(this).data('value'));
        });
        body.on('change','.edit-image-desc-textarea', function(){
            var textarea = $(this);
            var group = textarea.closest(".form-group");
            var image_id = textarea.attr('id').substr(25);
            var description = textarea.val();
            $.ajax({
                url:"/deals/user/userDeals/setImageDescription",
                type: 'post',
                data: {
                    image_id:image_id, description: description
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

        body.on('change','.edit-image-alias-textfield', function(){
            var field = $(this);
            var group = field.closest(".form-group");
            var image_id = field.attr('id').substr(27);
            var alias = field.val();
            $.ajax({
                url:"/deals/user/userDeals/setImageAlias",
                type: 'post',
                data: {
                    image_id:image_id, alias: alias
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
        body.on('change','.image-preview-checkbox', function(){

            var checkbox = $(this);
            var group = checkbox.closest(".form-group");
            group.removeClass('has-success').removeClass("has-error");
            var image_id = checkbox.attr('id').substr(23);
            var value = checkbox.prop("checked") ? "1" : "0";
            $.ajax({
                url:"/deals/user/userDeals/setImagePreview",
                type: 'post',
                data: {
                    image_id:image_id, value: value
                },
                beforeSend: function(){
                    checkbox.addClass('loading');
                },
                success:function(json){
                    checkbox.removeClass('loading');
                    var response = $.parseJSON(json);
                    if(response.status == "success"){
                        group.addClass('has-success');
                        var checked = $(".image-preview-checkbox:checked");
                        var not_checked = $(".image-preview-checkbox:not(:checked)");
                        if(checked.length>2){
                            alert("<?=Yii::t("dealsModule","You can define a maximum of 3 images to preview.");?>");
                            not_checked.each(function(){
                                $(this).attr("disabled","disabled");
                            })
                        }
                        else{
                            not_checked.each(function(){
                                $(this).removeAttr("disabled");
                            });
                        }
                        //group.find('.help-block').text(response.message).show();
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
            if(confirm('<?=Yii::t('dealsModule',"Do you want to delete this images?");?>')) {
                checked.each(function () {
                    var checkbox = $(this);
                    var image_id = checkbox.data("image_id");
                    $.ajax({
                        url: "/deals/user/userDeals/deleteImage",
                        type: 'post',
                        data: {
                            "_method": "delete",
                            "image_id": image_id
                        },
                        beforeSend: function () {
                            checkbox.addClass('loading');
                        },
                        success: function (data) {
                            checkbox.removeClass('loading');
                            $("#deal_image_" + image_id).remove();
                            // @todo Обновлять счётчик файлов
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
<h1 class="title section-title"><?=Yii::t('dealsModule','Add photo');?></h1>
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <p><strong>Внимание!</strong> Перед публикацией на сайте, загруженное изображение должно пройти модерацию. Иногда для этого требуется некоторое время.</p>
</div>
<?php Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true&language=ru");?>
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
        <li class="active"><a href="#">2. <?=Yii::t('dealsModule','Photo');?></a></li>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/video', array('id'=> $model->id));?>">3. <?=Yii::t('dealsModule','Video');?></a></li>
        <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/socialMediaVideo', array('id'=> $model->id));?>">4. <?=Yii::t('dealsModule','Youtube/Vimeo video');?></a></li>
    </ul>
</div>
<div class="tab-content">
    <div id="add-photo" class="tab-pane active">
        <?php
        $this->widget('widgets.MyXUpload.MyXUploadWidget', array(
            'url' => Yii::app()->createUrl("/deals/user/userDeals/uploadImage",array('deal_id' => $model->id)),
            'model' => $imagesModel,
            'attribute' => 'file',
            'multiple' => true,
            'autoUpload' => true,
            'formView' => 'images_form',
            'deal' => $model
        ));
        ?>
    </div>
</div>



