<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 24.04.2015
 * @var $dialog Dialogues
 * @var array $dialogues
 */
;?>
<script>
    $(document).ready(function(){
        var readMessageHandler = function(event,data){
            var currentBadge = $("#dialog_badge_"+data.dialog_id);
            var currentVal = parseInt(currentBadge.data("value"));
            var newVal = currentVal-1;
            if(newVal == 0){
                currentBadge.remove();
            }
            currentBadge.text(newVal).attr('data-value', newVal).data('value',newVal);
        };
        var userDialoguesWrap = $('#dialogues_scroll_pane');
        userDialoguesWrap.jScrollPane(
            {
                autoReinitialise: true
                //maintainPosition: true,
                //stickToBottom: true
            }
        );
        $(window).on('messagesModule.readMessage.success',readMessageHandler);
        //var dialoguesPane = userDialoguesWrap.jScrollPane().data('jsp');
        //dialoguesPane.scrollToBottom();
    })
</script>
<div class="panel">
    <div class="panel-body messages">
        <h5 class="title border h5"><?=Yii::t("messagesModule","Messages");?></h5>
        <div class="scroll-wrap">
            <div class="scroll-pane" id="dialogues_scroll_pane">
                <ul class="list-group">
                    <?php foreach($dialogues as $dialog):?>
                        <?php $user_id = Yii::app()->user->getId();?>
                        <?php if($user_id == $dialog->sender->id):?>
                            <?php $currentSender = $dialog->sender;?>
                            <?php $currentReceiver = $dialog->receiver;?>
                            <?php $currentNewMessagesCount = $dialog->sender_new_messages;?>
                        <?php else:?>
                            <?php $currentSender = $dialog->receiver;?>
                            <?php $currentReceiver = $dialog->sender;?>
                            <?php $currentNewMessagesCount = $dialog->receiver_new_messages;?>
                        <?php endif;?>
                        <li class="list-group-item" id="dialog_item_container_<?=$dialog->id;?>">
                            <a href="<?=Yii::app()->createUrl("/messages/user/dialogues/dialog", array('receiver_id' => $currentReceiver->id));?>">
                                <img src="<?=$currentReceiver->getSmallAvatar();?>" alt="<?=$currentReceiver->username;?>" />
                                <?php if((int)$currentNewMessagesCount>0):?>
                                    <span class="badge" data-value="<?=$currentNewMessagesCount;?>" id="dialog_badge_<?=$dialog->id;?>"><?=$currentNewMessagesCount;?></span>
                                <?php endif;?>
                                <span class="name"><?=$currentReceiver->username;?></span>
                            </a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</div>