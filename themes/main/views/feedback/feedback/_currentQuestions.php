<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 01.03.2013
 * @var array $questions
 */
;?>
<?php if(sizeof($questions)>0):?>
    <div class="row">
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3">
        </div>
        <div class="col-sm-9 col-xs-9 col-md-9 col-lg-9">
            <h5><?=Yii::t("feedbackModule","Возможно вы найдёте ответ на свой вопрос тут:");?></h5>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php foreach($questions as $question):?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse_<?=$question->id;?>" aria-expanded="true" aria-controls="collapse_<?=$question->id;?>">
                                    <?=$question->title;?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse_<?=$question->id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <?=$question->reply;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endif;?>
