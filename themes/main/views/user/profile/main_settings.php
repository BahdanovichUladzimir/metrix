      <?php
/**
 * @var $form TbActiveForm
 * @var $model User
 * @var $profile Profile
 * @var $this ProfileController
 */
$this->breadcrumbs=array(
	Yii::t('userModule',"Profile")=>array('privateProfile'),
	Yii::t('userModule',"Edit"),
);?>
<script>
    $(document).ready(function(){
        $('#delete_avatar_link').click(function(){
            if(confirm("<?=Yii::t('userModule', 'Are you really?');?>")){
                var $this = $(this);
                var image = $this.closest(".upload-wrap").find('.img img');
                $.ajax({
                    url: "<?=Yii::app()->createUrl('/user/profile/removeAvatar');?>",
                    success:function(response){
                        response = $.parseJSON(response);
                        if(response.status == "success"){
                            image.attr('src',response.default_image_url).removeClass("loading");
                        }
                        else{
                            console.log(response.message);
                        }
                    },
                    beforeSend: function(){
                        image.addClass("loading");
                    }

                });
            }
            return false;
        });
        $('#Profile_file').change(function(){

            var form_data = new FormData();

            console.log($(this).val());
            form_data.append('file', this.files[0]);
            var image = $("#user_avatar_image");
            var progress_bar_container = $("#avatar_progress");
            var progress_bar = $("#avatar_progress_bar");
            $.ajax({
                url: "<?=Yii::app()->createUrl('/user/profile/uploadAvatar');?>",
                type: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                beforeSend: function(){
                    image.addClass("loading");
                    progress_bar_container.show();
                    progress_bar.attr({"aria-valuenow":"0","aria-valuemax":"100"}).css({width: "0%"});
                },
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // Check if upload property exists
                        myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                    }
                    return myXhr;
                },
                success:function(response){
                    if(response.status === 'success'){
                        image.attr({"src":response.image, "alt":response.image}).removeClass("loading");
                        progress_bar_container.hide();
                    }
                }
            });
        });
        $("#invitekey_copy_btn").click(function(){
            var text = $(this).prev().text();
            copyToClipboard(text);
        });$("#invitelink_copy_btn").click(function(){
            var text = $(this).prev().text();
            copyToClipboard(text);
        });
    });
    function progressHandlingFunction(e){
        if(e.lengthComputable){
            var current_width = e.loaded/ e.total*100;
            $('#avatar_progress_bar').attr({"aria-valuenow":e.loaded,"aria-valuemax":e.total}).css({width: current_width+"%"});
        }
    }
    function copyToClipboard (text) {
        window.prompt ("<?=Yii::t('userModule','To copy the code to the clipboard, press Ctrl + C and Enter');?>", text);
    }

</script>
<?php if((is_null($model->invitecode) || strlen(trim($model->invitecode)) == 0) && strtotime($model->create_at)+(15*60)>time()):?>
    <script>
        $(document).ready(function(){
            var code = prompt("<?=Yii::t("userModule","Please enter invite code.");?>");
            if(code!==null){
                $.ajax({
                    url:"<?=Yii::app()->createUrl('/user/registration/SetInviteCode');?>",
                    data: {code:code},
                    type: "POST",
                    dataType: 'json',
                    success: function(response){
                        if(response.status == 'success'){
                            var html = '<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.message+'</div>';
                        }
                        else if(response.status == 'error'){
                            var html = '<div class="alert alert-danger alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.message+'</div>';
                        }
                        $("#messages").append(html);
                    },
                    error:function(data){
                        var html = '<div class="alert alert-danger alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Undefined error!</div>';
                        $("#messages").append(html);
                    }
                })
            }
        });
    </script>
<?php endif;?>
<section>
    <h1 class="title section-title h1"><?=Yii::t('userModule','Account settings');?></h1>
    <div id="messages"></div>
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

    <?php if( Yii::app()->user->hasFlash('userVkAuthenticate')):?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::app()->user->getFlash('userVkAuthenticate'); ?>
        </div>
    <?php endif; ?>
    <?php $this->renderPartial('partials/_settings_menu');?>
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
        'id'=>'profile-form',
        'enableAjaxValidation'=>true,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'enctype'=>'multipart/form-data'
        )
    )); ?>


    <div class="panel panel-default settings-form">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">

                    <div class="input-group">
                        <?php echo $form->labelEx($model,'username',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->textField($model,'username',array('maxlength'=>20)); ?>
                        <?php echo $form->error($model,'username', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($model,'email',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->emailField($model,'email'); ?>
                        <?php echo $form->error($model,'email', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($profile,'first_name',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->textField($profile,'first_name',array('maxlength'=>255)); ?>
                        <?php echo $form->error($profile,'first_name', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($profile,'last_name',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->textField($profile,'last_name',array('maxlength'=>255)); ?>
                        <?php echo $form->error($profile,'last_name', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($profile,'type',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->dropDownList($profile,'type',Profile::getUserTypes()); ?>
                        <?php echo $form->error($profile,'type', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($profile,'city_id',array('class' => 'input-group-addon')); ?>
                        <?php echo $form->dropDownList($profile,'city_id',Cities::getAllCitiesListData()); ?>
                        <?php echo $form->error($profile,'city_id', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <?php echo $form->labelEx($model,'invitekey',array('class' => 'input-group-addon')); ?>
                        <p class="form-control-static invitekeyp"><span class="invitekey"><?=$model->invitekey;?></span>&nbsp;&nbsp;<i class="glyphicon glyphicon-copy invitekey-copy-btn" id="invitekey_copy_btn"></i></p>
                        <?php echo $form->error($model,'invitekey', array('class'=> 'text-danger')); ?>
                    </div>
                    <div class="input-group">
                        <label for="User_invitelink" class="input-group-addon"><?=Yii::t("userModule","Invite link");?></label>
                        <p class="form-control-static invitekeyp"><span class="invitekey"><?=Yii::app()->createAbsoluteUrl("user/registration/authorization?invite_code=".$model->invitekey);?></span>&nbsp;&nbsp;<i class="glyphicon glyphicon-copy invitekey-copy-btn" id="invitelink_copy_btn"></i></p>
                        <?php
                        $url = Yii::app()->createAbsoluteUrl("user/registration/authorization?invite_code=".$model->invitekey);
                        $title = Yii::t('userModule',"all4holidays.com - all for holidays");
                        $description = Yii::t('userModule',"Join me on all4holidays.com");
                        $image = Yii::app()->createAbsoluteUrl('images/logo.png')
                        ;?>

                        <a href="http://vk.com/share.php?url=<?=$url;?>&title=<?=$title;?>&description=<?=$description;?>&image=<?=$image;?>" target="_blank">
                            <?=Yii::t('userModule',"Share on Vkontakte");?>
                        </a>
                        <br>
                        <!--<a href="https://www.facebook.com/sharer/sharer.php?u=<?/*=$url;*/?>" target="_blank">
                            <?/*=Yii::t('userModule',"Share on Facebook");*/?>
                        </a>-->

                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="right-block">
                        <div class="input-group">
                            <?php echo $form->labelEx($profile,'description',array('class' => 'input-group-addon')); ?>
                            <?php echo $form->textArea($profile,'description'); ?>
                            <?php echo $form->error($profile,'description', array('class'=> 'text-danger')); ?>
                        </div>
                        <div class="input-group">
                            <?php echo $form->labelEx($profile,'file',array('class' => 'input-group-addon')); ?>
                            <div class="upload-wrap">
                                <div class="img">
                                    <?=CHtml::image($profile->getMediumThumbUrl(),$profile->avatar, array('class' => "user-avatar-image", "id" => "user_avatar_image"));?>
                                    <div class="progress avatar-progress" id="avatar_progress" style="display: none;">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" id="avatar_progress_bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="upload-btn-wrap">
                                    <div class="file-btn">
                                        <?php echo $form->fileField($profile,'file', array("class" => "userpic")); ?>
                                        <?php echo $form->error($profile,'file', array('class'=> 'text-danger')); ?>
                                        <a href="#" class="btn btn-default"><?=Yii::t('userModule',"Select file");?></a>
                                    </div>
                                    <?php if(strlen($profile->avatar) > 0):?>
                                        <a href="" id="delete_avatar_link" class="btn btn-danger"><?=Yii::t('core','Remove');?></a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="buttons pull-right">
                        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('userModule','Create') : Yii::t('userModule','Save'), array('class' => 'btn btn-success')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</section>

