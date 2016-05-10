<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 26.03.2015
 * @var array $comments
 * @var $comment Comments
 * @var $user RWebUser
 * @var $rUser User
 * @var $model Comments
 * @var int $appCategoryId
 * @var int $appCategoryItemId
 * @var int $parentId
 */
Yii::app()->clientScript->registerScript('editCommentButton','
    $(document).ready(function(){
        $("body").on("click",".edit-comment", function(){
            var rel = $(this).attr("rel");
            var button = this;
            $("#"+rel).slideToggle("fast",function(){
                if($(this).is(":visible"))
                {
                    $(button).text("'.Yii::t("commentsModule","Close").'");
                }
                else
                {
                    $(button).text("'.Yii::t("commentsModule","Edit").'");
                }
            });
        });
    });
');
;?>

<div class="panel panel-default">
    <div class="panel-body">
        <a href="#" class="btn btn-primary pull-right add-review a-spr"><?=Yii::t("commentsWidget","Add review");?></a>
        <h2 class="title section-title"><?=Yii::t("commentsWidget","Reviews");?> (<span class="comment-count" id="comment_count" data-value="<?=sizeof($comments);?>"><?=sizeof($comments);?></span>)</h2>
        <?php if($user->getIsCanAddComment($appCategoryItemId)):?>
            <div class="review dnone">
                <div class="review-form cf">
                    <div class="pic-upload user-pic">
                        <input type="file" />
                        <div class="img">
                            <img src="/images/user-blank.png" alt="" />
                        </div>
                    </div>
                        <?php $this->render("_form",array(
                            'model' => $model,
                            'appCategoryId' => $appCategoryId,
                            'appCategoryItemId' => $appCategoryItemId,
                            'parentId' => $parentId,
                        ));?>
                </div>
            </div>
        <?php else:?>
            <h4 class="text-danger"><?=Yii::t('commentsWidget','You can\'t add a comment to this deal.');?></h4>
        <?php endif;?>

        <div class="comments-container" id="comments_container">
            <?php $counter = 0;?>
            <?php if(sizeof($comments)>0):?>
                <?php foreach($comments as $comment):?>
                    <?php if($counter == 3):?>
                        <div class="unvisible" id="unvisible-comments">
                    <?php endif;?>
                    <?php $this->render("_comment", array('comment' => $comment, 'user' => $user, 'rUser' => $rUser));?>
                    <?php $counter++;?>
                <?php endforeach;?>
                <?php if($counter>3):?>
                    </div>
                <?php endif;?>
            <?php else:?>
                <p class="no-comments-found"><?=Yii::t('commentsWidget','No comments found.');?></p>
            <?php endif;?>
        </div>
        <?php if($counter>4):?>
            <a href="#" class="show-all" data-name="comments"><?= Yii::t('commentsWidget','All comments');?></a>
        <?php endif;?>
    </div>
</div>