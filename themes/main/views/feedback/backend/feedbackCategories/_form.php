<?php
/**
 * @var $model FeedbackCategories
 * @var $form TbActiveForm
 * @var array $categoriesList
 * @var array $statusesList
 */
;?><?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'feedback-categories-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>
    <?php echo $form->textFieldGroup(
        $model,
        'name',
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
    <?php echo $form->dropDownListGroup(
        $model,
        'parent_id',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
            ),
            'widgetOptions' => array(
                'data' => $categoriesList,
            )
        )
    ); ?>
    <?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

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
