<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 07.04.2015
 * @var string $accessToken
 * @var array $registeredEmails
 */
$this->breadcrumbs=array(
    Yii::t('userModule',"Profile")=>array('/user/profile/privateProfile'),
    Yii::t('userModule',"Invite gmail friends"),
);?>
<script>
    $(document).ready(function(){
        generateGmailContactsList("<?=$accessToken;?>");
        $("#check_all_emails").change(function(){
            $("#gmail_invite input[type='checkbox']:enabled").not(this.disabled).prop('checked', this.checked);
        })
    });


    function generateGmailContactsList(access_token){
        $.get(
            "https://www.google.com/m8/feeds/contacts/default/full?alt=json&access_token=" + access_token + "&max-results=1000&v=3.0",
            function(response){
                var emails = [];
                $.each(response.feed.entry,function(i,item){
                   if(typeof item.gd$email !== "undefined"){
                       emails.push(item.gd$email[0].address);
                   }
                });
                if(emails.length>0){
                    $.ajax({
                        url: "<?=Yii::app()->createUrl('/user/gmail/checkEmails');?>",
                        data: {emails:JSON.stringify(emails)},
                        type: 'post',
                        success:function(json){
                            var response = $.parseJSON(json);
                            if(response.emails !== 'undefined'){
                                $.each(response.emails,function(i,item){
                                    if(item.status == 'not_registered'){
                                        $("#emails_list").append(
                                            "<div class='checkbox not-registered-email'>" +
                                                "<label class='checkbox'>" +
                                                    "<input type='checkbox' name='emails[]' value='"+item.email+"'>" +
                                                    "<span class='a-spr'></span><span>"+item.email+"</span>" +
                                                "</label>" +
                                            "</div>"
                                        )
                                    }
                                    else{
                                        $("#emails_list").append(
                                            "<div class='checkbox registered-email'>" +
                                                "<label class='checkbox'>" +
                                                    "<input type='checkbox' disabled='disabled' name='emails[]' value='"+item.email+"'>" +
                                                    "<span class='a-spr'></span><span>"+item.email+"</span>" +
                                                "</label>" +
                                            "</div>"
                                        )
                                    }
                                });
                            }
                        }
                    })
                }
            });
    }
</script>
<section>
    <h1 class="title section-title h1"><?=Yii::t('userModule','Invite gmail friends');?></h1>
    <div class="panel panel-default settings-form">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-2">
                    <?=CHtml::image('/images/gmail_100x100.png','gmail-icon',array('class' => 'gmail-icon'));?>
                </div>
                <div class="col-xs-10">
                    <h1 class="gmail-invite-page-title"><?=Yii::t('userModule','Invite your gmail friends.');?></h1>
                    <!--<h3><?/*=Yii::t('userModule','You will receive 10 additional positions for each friend who signs up for all4holidays.com.');*/?></h3>-->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                    <hr class="gmail-invite-hr"/>
                    <?php if( Yii::app()->user->hasFlash('usermodule.gmail.invite.success')):?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo Yii::app()->user->getFlash('usermodule.gmail.invite.success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if( Yii::app()->user->hasFlash('usermodule.gmail.invite.error')):?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo Yii::app()->user->getFlash('usermodule.gmail.invite.error'); ?>
                        </div>
                    <?php endif; ?>
                    <div id="gmail_contacts_list_wrapper" class="gmail-contacts-list-wrapper">
                        <form id="gmail_invite" action="<?=Yii::app()->createUrl("/user/gmail/invite");?>" class="form" method="POST">
                            <input type="hidden" name="access_token" value="<?=$accessToken;?>">
                            <div class="emails-list" id="emails_list">
                                <div class="checkbox check-all">
                                    <label for="check_all_emails" class="checkbox">
                                        <input type="checkbox" id="check_all_emails"/>
                                        <span class="a-spr"></span>
                                        <span><?=Yii::t('userModule',"Check all");?></span>
                                    </label>
                                </div>
                                <hr class="gmail-invite-hr"/>
                            </div>
                            <input type="submit" class="btn btn-success" value="<?=Yii::t('userModule','Send invite');?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


