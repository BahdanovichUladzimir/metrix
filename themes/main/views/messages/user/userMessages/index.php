<?php

/**
 * @var $dialog Dialogues
 * @var array $dialogues
 */
$this->breadcrumbs=array(
	Yii::t('messagesModule','User') => '',
	Yii::t('messagesModule','Messages'),
);?>
<section>
    <div class="row">
        <div class="col-lg-3 col-lg-offset-1">
            <div class="panel">
                <div class="panel-body messages">
                    <h5 class="title border h5"><?=Yii::t("messagesModule","Messages");?></h5>
                    <div class="scroll-wrap">
                        <div class="scroll-pane">
                            <ul class="list-group">
                                <?php foreach($dialogues as $dialog):?>
                                    <li class="list-group-item">
                                        <a href="<?=Yii::app()->createUrl("/messages/user/userMessages/dialog", array('dialog_id' => $dialog->id));?>">
                                            <img src="<?=$dialog->receiver->getSmallAvatar();?>" alt="<?=$dialog->receiver->username;?>" />
                                            <?php if(sizeof($dialog->sender_new_messages)>0):?>
                                                <span class="badge"><?=$dialog->sender_new_messages;?></span>
                                            <?php endif;?>
                                            <span class="name"><?=$dialog->receiver->username;?></span>
                                        </a>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="panel">
            </div>
        </div>
    </div>
</section>
