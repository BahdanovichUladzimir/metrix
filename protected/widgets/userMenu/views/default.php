<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.04.2015
 * @var $user RWebUser
 * @var $dbUser User
 * @var int $widgetId
 */
//Config::var_dump($user->getNewMessagesCount());

;?>
<li class="dropdown">
    <a href="<?=$dbUser->getPrivateUrl();?>" class="user-icon icon b-spr dropdown-toggle" data-toggle="dropdown"><?=($user->getNewMessagesCount()>0) ? "<span class='notif'>".$user->getNewMessagesCount()."</span>" : "";?></a>
    <ul class="dropdown-menu">
        <li><?=CHtml::link(User::model()->findByPk(Yii::app()->user->getId())->username,$dbUser->getPrivateUrl(), array('class' => 'user-title'));?></li>
        <li>
            <a href="<?=Yii::app()->createUrl('/messages/user/dialogues/index',array('#' => 'main_menu_container'));?>"><?=Yii::t('messagesModule', 'Messages');?></a>
            <?php if($user->getNewMessagesCount()>0):?>
                <span class="badge"><?=$user->getNewMessagesCount();?></span>
            <?php endif;?>
        </li>
        <?/*<li><a href="#">Действия на сайте</a></li>*/?>
        <?php /*<li><?=CHtml::link(Yii::t('paymentModule','Invite gmail friends'),Yii::app()->createUrl('/user/gmail/inviteFriends'),array('class'=>'gmail_invite_link'));?></li>*/;?>
        <li><a href="<?=Yii::app()->createUrl('/payment/user/payments/index');?>"><?=Yii::t('paymentModule','Balance');?></a></li>

        <li><?=CHtml::link(Yii::t("dealsModule","My deals"),$dbUser->getPrivateUrl()."#offers", array('class' => 'user-title'));?></li>
        <li><?=CHtml::link(Yii::t("eventsModule","My events"),$dbUser->getPrivateUrl()."#events", array('class' => 'user-title'));?></li>
        <li><?=CHtml::link(Yii::t("bannersModule","My banners"),$dbUser->getPrivateUrl()."#banners", array('class' => 'user-title'));?></li>
        <li><?=CHtml::link(Yii::t("userModule","Settings"),Yii::app()->createUrl('user/profile/editMainSettings'));?></li>
        <li><?=CHtml::link(Yii::t("userModule","Logout"),Yii::app()->getModule('user')->logoutUrl);?></li>

    </ul>
</li>

<?php if($widgetId == 1):?>
    <script>
        // google api
        $(document).ready(function(){
            var Script = document.createElement('script');
            Script.src = "https://apis.google.com/js/client.js?onload=handleClientLoad";
            Script.type = "text/javascript";
            document.getElementsByTagName('head')[0].appendChild(Script);

            var authorizeLink = $(".gmail_invite_link");
            authorizeLink.click(function(){
                checkAuth();
                return false;
            });
        });
        var clientId = "<?=Yii::app()->params['gmail']['clientId'];?>";

        var apiKey = "<?=Yii::app()->params['gmail']['apiKey'];?>";

        var scopes = 'https://www.google.com/m8/feeds';

        function handleClientLoad() {
            // Step 2: Reference the API key
            gapi.client.setApiKey(apiKey);
            //window.setTimeout(checkAuth,3);
        }


        function checkAuth() {
            gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
        }

        function handleAuthResult(authResult) {
            //var authorizeButton = document.getElementById('gmail_invite_link');
            //var authorizeLink = $("#gmail_invite_link");
            //console.log(authResult);
            if (authResult && !authResult.error){
                //console.log(authResult);
                window.location.href = "<?=Yii::app()->createUrl('/user/gmail/inviteFriends');?>?accessToken="+authResult.access_token;
                /*$.fancybox({
                 href: "<?/*=Yii::app()->createUrl('/user/gmail/inviteFriends');*/?>",
                 type: 'ajax'
                 });*/
                return false;
            }
            else{
                handleAuthClick();
                return false;
            }
        }

        function handleAuthClick(event) {
            // Step 3: get authorization to use private data
            gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
            return false;
        }
    </script>
<?php endif;?>
