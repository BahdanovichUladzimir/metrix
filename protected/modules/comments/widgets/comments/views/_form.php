<?php

/**
 * @var $this CommentsController
 * @var $model Comments
 * @var $form CActiveForm
 * @var int $appCategoryId
 * @var int $appCategoryItemId
 * @var int $parentId
 */
?>
<!--<div class="review-wrap">
    <input type="email" placeholder="E-mail"/>
    <input type="text" placeholder="Ваше имя"/>
    <textarea placeholder="Напишите свой отзыв"></textarea>
    <div class="captcha">
        <img src="/images/content/captcha.png" alt="" />
    </div>
    <input type="text" placeholder="Введите надпись с картинки"/>
</div>
<input type="submit" class="btn btn-primary pull-right" value="Оставить отзыв"/>-->
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comments-form',
    'action' => Yii::app()->createUrl('/comments/frontend/comments/create'),
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validationUrl' => Yii::app()->createUrl("/comments/frontend/comments/create" ),
        'errorCssClass' => 'has-error',
        'successCssClass' => 'has-success',
        'errorMessageCssClass' => 'text-danger',
    ),
    'htmlOptions' => array(
        'class' => 'form',
    ),
)); ?>
<div class="review-wrap">

    <?php echo $form->hiddenField($model,'parent_id', array('value' => $parentId)); ?>
    <?php echo $form->error($model,'parent_id'); ?>

    <?php echo $form->hiddenField($model,'app_category_id',array('value' => $appCategoryId)); ?>
    <?php echo $form->error($model,'app_category_id'); ?>

    <?php echo $form->hiddenField($model,'app_category_item_id',array('value' => $appCategoryItemId)); ?>
    <?php echo $form->error($model,'app_category_item_id'); ?>

    <div class="form-group">
        <?php echo $form->textArea(
            $model,
            'description',
            array(
                'rows'=>6,
                'cols'=>50,
                'placeholder' => Yii::t('commentsWidget','Add your comment'),
                'class' => 'form-control'
            )
        ); ?>
        <?php echo $form->error($model,'description', array('class' => 'text-danger')); ?>
    </div>
</div>
<?php echo CHtml::ajaxSubmitButton(
            Yii::t('commentsWidget','Add comment'),
            Yii::app()->createUrl('/comments/frontend/comments/create'),
            array(
                'beforeSend' => 'js:function(){
                    $("#Comments_Description").attr("disabled","disabled");
                    $("#comment_submit_btn").attr("disabled","disabled").val("'.Yii::t('commentsModule','Loading....').'");
                }',
                'success' => 'js:function(data){
                    $("#Comments_description").removeAttr("disabled");
                    $("#comment_submit_btn").removeAttr("disabled").val("'.Yii::t('commentsWidget','Add comment').'");
                    var result = jQuery.parseJSON(data);
                    if(result.status === "success")
                    {
                        $(window).trigger("comment.create");
                        var comment_count = $("#comment_count").attr("data-value");
                        $("#comment_count").text(comment_count-0+1);// отнимаем 0, что-бы преобразовать в число
                        $("#comment_count").attr("data-value",comment_count-0+1);
                        if(result.html)
                        {
                            $("#comments_container").append(result.html);
                            $(".no-comments-found").remove();
                            $("#Comments_description").val("");
                        }
                    }
                    else
                    {
                        $.each(result, function(key, val)
                        {
                            $("#comments-form #"+key+"_em_").text(val);
                            $("#comments-form #"+key+"_em_").show();
                            $("#comments-form #Comments_description").parent(".form-group").addClass("has-error");

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
                'class' => 'btn btn-primary pull-right',
                'id' => 'comment_submit_btn'
            )
        ); ?>


<?php $this->endWidget(); ?>
