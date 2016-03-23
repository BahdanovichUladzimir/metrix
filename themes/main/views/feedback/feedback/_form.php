<?php
/**
 * @var $model Feedback
 * @var $form TbActiveForm
 * @var array $categoriesList
 * @var $user User
 * @var bool $showFormLabel
*/
;?>
<?php if( Yii::app()->user->hasFlash('feedbackSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('feedbackSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('feedbackError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('feedbackError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'feedback-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>
<script>
    $(document).ready(function(){
        <?php if(!$showFormLabel):?>
            $("#feedback_form").hide();
        <?php endif;?>
        $("#show_feedback_form").click(function(){
            $("#feedback_form").slideToggle();
            return false;
        });
    });
</script>

    <?php echo $form->dropDownListGroup(
        $model,
        'category_id',
        array(
            'widgetOptions' => array(
                'data' => $categoriesList,
                'htmlOptions' => array(
                    'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                    'ajax' => array(
                        'type' => 'POST', //request type
                        'url' => Yii::app()->createUrl('/feedback/feedback/getCurrentQuestions'), //url to call.
                        'update' => '#current_questions',
                        'data'=> array('category_id' => 'js:$(this).val()'),
                    ),
                ),
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
            ),
        )
    ); ?>
    <div id="current_questions">

    </div>

    <div id="feedback_form">
        <p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

        <?php echo $form->textAreaGroup(
            $model,
            'title',
            array(
                'widgetOptions'=>array(
                    'htmlOptions'=>array(
                        'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                        'maxlength'=>255
                    )
                ),
                'wrapperHtmlOptions' => array(
                    'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
                ),
            )
        ); ?>

        <?php if(is_null($user)):?>
            <?php echo $form->textFieldGroup(
                $model,
                'user_name',
                array(
                    'widgetOptions'=>array(
                        'htmlOptions'=>array(
                            'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                            'maxlength'=>255,
                        )
                    ),
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
                    ),
                )
            ); ?>

            <?php echo $form->textFieldGroup(
                $model,
                'user_email',
                array(
                    'widgetOptions'=>array(
                        'htmlOptions'=>array(
                            'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                            'maxlength'=>255,

                        )
                    ),
                    'wrapperHtmlOptions' => array(
                        'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
                    ),
                )
            ); ?>
        <?php endif;?>


        <?php echo $form->textAreaGroup(
            $model,
            'message',
            array(
                'widgetOptions'=>array(
                    'htmlOptions'=>array(
                        'rows'=>8,
                        'cols'=>50,
                        'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                        'style'=>'height:140px'
                    )
                ),
                'wrapperHtmlOptions' => array(
                    'class' => 'col-xs-12 col-sm-9 col-md-9 col-lg-9',

                ),
            )
        ); ?>


    <div class="row">
        <div class="col-sm-3 col-xs-3 col-md-3 col-lg-3 col-md-offset-3">
            <div class="form-actions">

                <?if(CCaptcha::checkRequirements() && Yii::app()->user->isGuest):?>
                    <?php $this->widget(
                        'CCaptcha',
                        array(
                            'buttonLabel' => Yii::t('feedbackModule','Get new code'),
                            'clickableImage' => true
                        )
                    )?>
                    <br>
                    <br>
                    <?=CHtml::activeLabelEx($model, 'verifyCode')?>
                    <?=CHtml::activeTextField($model, 'verifyCode')?>
                <?endif?>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-9 col-xs-9 col-md-9 col-lg-9 col-md-offset-3">
            <div class="form-actions">

                <?php $this->widget('booster.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'context'=>'success',
                    'label'=>Yii::t('core','Submit'),
                )); ?>

            </div>
        </div>

    </div>

    </div>
    <?=CHtml::link(Yii::t("feedbackModule","Ask your question"),"#", array('id'=>"show_feedback_form", "class" => 'btn btn-success'));?>

<?php $this->endWidget(); ?>
