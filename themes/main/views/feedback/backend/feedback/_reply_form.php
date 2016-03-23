<?php
/**
 * @var $model Feedback
 * @var $form TbActiveForm
*/
;?><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'feedback-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup(
        $model,
        'title',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-5 col-sm-5',
                    'maxlength'=>255,
                    'disabled' => true
                ),
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
            )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'user_email',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-5 col-sm-5',
                    'maxlength'=>255,
                    'disabled' => true
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
            )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'user_name',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-5 col-sm-5',
                    'maxlength'=>255,
                    'disabled' => true
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
            )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'user_id',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-5 col-sm-5',
                    'disabled' => true
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
            )
    ); ?>

	<?php echo $form->textAreaGroup(
        $model,
        'message',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'rows'=>6,
                    'cols'=>50,
                    'class'=>'span8',
                    'disabled' => true
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
            )
    ); ?>

	<?php echo $form->textAreaGroup(
        $model,
        'reply',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'rows'=>6,
                    'cols'=>50,
                    'class'=>'span8'
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
            )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'created_date',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-5 col-sm-5',
                    'maxlength'=>12,
                    'disabled' => true,
                    'value' => $model->formattedCreatedDate
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                ),
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
			'label'=>Yii::t('core','Submit'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
