<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 24.04.2015
 * @var $data UserMessages
 */
;?>
<div class="message-wrap <?=($data->is_read == 1) ? 'read-message' : 'unread-message';?> <?=($data->sender_id == Yii::app()->user->getId()) ? 'sender-message' : 'receiver-message';?>" id="user_message_<?=$data->id;?>">
    <a href="<?=$data->sender->getPublicUrl();?>"><img src="<?=$data->sender->getSmallAvatar();?>" alt="<?=$data->sender->username;?>" /></a>
    <div class="message">
        <span class="title"><a href="<?=$data->sender->getPublicUrl();?>"><?=$data->sender->username;?></a></span>
        <?=$data->body;?>
        <time><?=$data->getFormattedCreatedAt();?></time>
        <span class="delete delete-message-link" data-message="<?=$data->id;?>">&times;</span>
    </div>
</div>