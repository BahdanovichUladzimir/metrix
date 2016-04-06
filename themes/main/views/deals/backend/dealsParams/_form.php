<?php
/**
 * @var $model DealsParams
 * @var $form TbActiveForm
 * @var array $typesListData
 * @var array $requiredListData
 * @var array $visibleListData
 */

;?>
<?php if( Yii::app()->user->hasFlash('dealsParamsSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('dealsParamsSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('dealsParamsError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('dealsParamsError'); ?>
	</div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'deals-params-form',
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
				'class'=>'col-xs-5 col-sm-5',
				'maxlength'=>50,
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
			),
		)
); ?>

<?php echo $form->textFieldGroup(
	$model,
	'label',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'class'=>'col-xs-5 col-sm-5',
				'maxlength'=>50,
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
			),
		)
); ?>
<?php echo $form->dropDownListGroup(
	$model,
	'type_id',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => $typesListData,
            'htmlOptions' => array(
                'multiple' => false,
                //'style' => 'height: 200px;',
                /*'ajax' => array(
                    'type' => 'POST', //request type
                    'url' => Yii::app()->createUrl('/deals/backend/dealsParams/getDealCategoriesParams'), //url to call.
                    'update' => '#deal_categories_params',
                    'data'=> $model->isNewRecord ? array('categories' => 'js:$(this).val()') : array('deal_id' => $model->id, 'categories' => 'js:$(this).val()'),
                ),*/
            ),
		),
	)
); ?>

<?php echo $form->textFieldGroup(
	$model,
	'field_size',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'maxlength'=>5
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
			),
		)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'field_size_min',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'maxlength'=>3
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
			),
		)
); ?>

<?php echo $form->dropDownListGroup(
	$model,
	'required',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => $requiredListData,
		),
	)
); ?>
<?php echo
$form->textFieldGroup(
	$model,
	'match',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'maxlength'=>255
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6'
		),
		'hint' => Yii::t("dealsModule","Regular expression (example: '/^[A-Za-z0-9\s,]+$/u').")
	)
); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'list_id',
    array(
        'widgetOptions' => array(
            'data' => Lists::getListData(),
			'htmlOptions' => array(
				'empty' => 'Empty'
			)
        ),
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6 col-xs-6',
        )
    )
); ?>

<?php echo $form->textFieldGroup(
	$model,
	'range',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'maxlength'=>255,
			),
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'hint' => Yii::t("dealsModule",'Predefined values (example: 1;2;3;4;5 or 1==One;2==Two;3==Three;4==Four;5==Five).')
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'error_message',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'maxlength'=>255,
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'hint' => Yii::t("dealsModule",'Error message when you validate the form.')
	)
); ?>
<?php echo $form->textAreaGroup(
	$model,
	'other_validator',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'rows'=>6,
				'cols'=>50,
				'class'=>'span8'
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6'
		),
		'hint' => Yii::t("dealsModule",'JSON string (example: {example}).',array('{example}'=>CJavaScript::jsonEncode(array('file'=>array('types'=>'jpg, gif, png')))))
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'default',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'maxlength'=>255
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6'
		),
		'hint' => Yii::t("dealsModule",'The value of the default field (database).')
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'position',
	array(
		'widgetOptions'=>array(
			'htmlOptions'=>array(
				'class'=>'col-xs-5 col-sm-5'
			)
		),
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6'
		),
		'hint' => Yii::t("dealsModule",'Display order of fields.')
	)
); ?>

<?php echo $form->dropDownListGroup(
	$model,
	'visible',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => $visibleListData,
		),
	)
); ?>
<?php echo $form->checkboxGroup(
    $model,
    'filter',
    array(
        'widgetOptions' => array(
            'htmlOptions' => array(
                'value'=>1, 'uncheckValue'=>0
            )
        )
    )); ?>
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
