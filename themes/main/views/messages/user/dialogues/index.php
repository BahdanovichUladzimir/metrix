<?php

/**
 * @var $dialog Dialogues
 * @var array $dialogues
 */
$this->breadcrumbs=array(
	//Yii::t('messagesModule','User') => '',
	Yii::t('messagesModule','Messages'),
);?>
<section>
    <div class="row">
        <div class="col-lg-3 col-lg-offset-1">
            <?php $this->renderPartial('_dialogues_list', array('dialogues' => $dialogues)); ?>
        </div>
        <div class="col-lg-7">
            <div class="panel">
            </div>
        </div>
    </div>
</section>
