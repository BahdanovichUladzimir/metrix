<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 17.07.14
 * @var $comment Comments
 * @property $user User
 * @var $rUser User
 * @var $form CActiveForm
 */
;?>
<div class="wgt-CommentsWidget-_comment" id="wgt_CommentsWidget-_comment_<?=$comment->id;?>">
    <div class="review">
        <div class="user-pic">
            <div class="img">
                <img src="<?=$comment->user->getSmallAvatar();?>" alt="<?=$comment->user->username;?>" />
            </div>
        </div>
        <div class="review-wrap">
            <span class="title">
                <?=CHtml::link($comment->user->getCommentUserName(), Yii::app()->createUrl('/user/profile/publicProfile', array('id'=>$comment->user->id)));?>
            </span>
            <time><?=$comment->formattedCreatedDate;?></time>
            <div class="comment">
                <p><?=$comment->description;?></p>
            </div>
        </div>
        <div class="col-xs-12 comment-edit-form-container" style="display:none;" id="comment_edit_form_container_<?=$comment->id;?>">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'comment_edit_form_'.$comment->id,
                'action' => Yii::app()->createUrl("/comments/frontend/comments/update",array('id'=>$comment->id)),
                //'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
                'clientOptions' => array(
                    'validationUrl' => Yii::app()->createUrl("/comments/update",array('id'=>$comment->id)),
                    'errorCssClass' => 'has-error',
                    'successCssClass' => 'has-success',
                    'errorMessageCssClass' => 'text-danger',
                    'validateOnSubmit' => false,
                ),
                'htmlOptions' => array(
                    'role' => 'form',
                ),
            )); ?>

            <div class="form-group">
                <?php echo $form->labelEx($comment,'description'); ?>
                <?php echo $form->textArea($comment,'description',array('rows'=>6, 'cols'=>50, 'class'=>"form-control",'id'=>'comment_edit_textarea_'.$comment->id)); ?>
                <?php echo $form->error($comment,'description',array('inputID'=>'comment_edit_textarea_'.$comment->id, 'class' => 'text-danger')); ?>
            </div>

            <div class="buttons">
                <?php echo CHtml::ajaxSubmitButton(
                    Yii::t('commentsModule','Submit'),
                    Yii::app()->createUrl('/comments/frontend/comments/update',array('id'=>$comment->id)),
                    array(
                        'success' => 'js:function(data){
                        var result = jQuery.parseJSON(data);
                        if(result.status === "success")
                        {
                            $(window).trigger("comment.update");
                            if(result.html)
                            {
                                $("#wgt_CommentsWidget-_comment_'.$comment->id.'").replaceWith(result.html);
                            }
                        }
                        else
                        {
                            $.each(result, function(key, val)
                            {
                                $("#comment_edit_form_'.$comment->id.' #comment_edit_textarea_'.$comment->id.'_em_").text(val);
                                $("#comment_edit_form_'.$comment->id.' #comment_edit_textarea_'.$comment->id.'_em_").show();
                                $("#comment_edit_form_'.$comment->id.' #comment_edit_textarea_'.$comment->id.'").parent(".form-group").addClass("has-error");
                            });
                        }
                        if(result.message){
                            $.notify(result.message,result.status,{
                                autoHide: false,
                            });
                        }
                    }'
                    ),
                    array(
                        'class' => 'btn btn-success',
                        'name' => 'comment-submit-button',
                        'id' => 'comment_submit_button_'.$comment->id
                    )
                ); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div>
        <div class="text-right">
            <?php if(!Yii::app()->user->isGuest && $comment->user_id == Yii::app()->user->getId()):?>
                <span class="edit-comment" rel="comment_edit_form_container_<?=$comment->id;?>" id="comment_edit_link_<?=$comment->id;?>"><?=Yii::t("commentsModule","Edit");?></span>
                &nbsp;
                &nbsp;
                <?=CHtml::ajaxLink(
                    Yii::t("commentsModule","Delete"),
                    Yii::app()->createUrl('/comments/frontend/comments/delete', array('id'=>$comment->id)),
                    array(
                        'type' => 'POST',
                        'beforeSend' => 'js:function(){
                        if(!confirm("'.Yii::t("commentsModule",'Are you sure you want to delete this comment?').'")){
                            return false;
                        }
                    }',
                        'success' => 'js:function(data){
                        var result = jQuery.parseJSON(data);
                        if(result.status === "success")
                        {
                            var comment_count = $("#comment_count").attr("data-value");
                            $("#comment_count").text(comment_count-1);
                            $("#comment_count").attr("data-value",comment_count-1);

                            $(window).trigger("comment.delete");
                            $("#wgt_CommentsWidget-_comment_"+'.$comment->id.').remove();
                        }
                        if(result.message){
                            $.notify(result.message,result.status,{
                                autoHide: false,
                            });
                        }
                    }'
                    ),
                    array(
                        'class'=>'delete-comment',
                        'rel'=> "comment_edit_form_container_".$comment->id,
                        'id'=> "comment_delete_link_".$comment->id
                    )
                );?>
            <?php endif;?>
        </div>

    </div>
    <div class="col-xs-12">
        <div class="hr"></div>
    </div>
</div>
