<?php
/**
 * @var $model FeedbackQuestions
 * @var $form TbActiveForm
 * @var array $categoriesList
 * @var array $statusesList
*/
;?><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'feedback-questions-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->textAreaGroup(
        $model,
        'question',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'rows'=>6,
                    'cols'=>50,
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-9 col-xs-9 col-md-9 col-lg-9',
                ),
            )
    ); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $form->ckEditorGroup(
                $model,
                'reply',
                array(
                    'widgetOptions' => array(
                        'editorOptions' => array(
                            'fullpage' => 'js:true',
                            'width' => '625',
                            'resize_maxWidth' => '640',
                            'resize_minWidth' => '320'
                        )
                    )
                )
            ); ?>
        </div>
    </div>
    <?php echo $form->dropDownListGroup(
        $model,
        'category_id',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
            ),
            'widgetOptions' => array(
                'data' => $categoriesList,
            )
        )
    ); ?>
    <?php echo $form->dropDownListGroup(
        $model,
        'status_id',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
            ),
            'widgetOptions' => array(
                'data' => $statusesList,
            )
        )
    ); ?>


<div class="form-actions">
	<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'reset',
			'context'=>'danger',
			'label'=>Yii::t('core','Reset'),
		)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
