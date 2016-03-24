<?php
/**
 * @var $model User
 * @var $profile Profile
 * @var $form TbActiveForm
 */
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo Yii::t('userModule','Fields with <span class="required">*</span> are required.'); ?></p>
<?php echo $form->textFieldGroup(
	$model,
	'username',
	array(
		'maxlength'=>20,
		'size'=>20,
		//'class'=> 'text-field',
		'wrapperHtmlOptions' =>
			array(
				'class' => 'col-sm-6 col-xs-6',
			),
	)
); ?>
<?php echo $form->passwordFieldGroup(
	$model,
	'password',
	array(
		'wrapperHtmlOptions' =>
			array(
				'class' => 'col-sm-6 col-xs-6',
			),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'maxlength'=>128,
				'size'=>60,
			),
		),
	)
); ?>
<?php echo $form->textFieldGroup(
	$model,
	'email',
	array(
		'wrapperHtmlOptions' =>
			array(
				'class' => 'col-sm-6 col-xs-6',
			),
		'widgetOptions' => array(
			'htmlOptions' => array(
				'maxlength'=>128,
				'size'=>60,
			),
		),

	)
); ?>
<?php /*echo $form->dropDownListGroup(
	$model,
	'superuser',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => User::itemAlias('AdminStatus'),
		)
	)
); */?>
<?php echo $form->dropDownListGroup(
	$model,
	'status',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => User::itemAlias('UserStatus'),
		)
	)
); ?>
<?php echo $form->textFieldGroup(
    $model,
    'ballance',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'value' => $model->ballance,
            ),
        )
    )
); ?>
<?php echo $form->textFieldGroup(
    $model,
    'full_name',
    array(
        'maxlength'=>20,
        'size'=>20,
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<div class="row">
    <div class="col-sm-3 col-xs-3"></div>
    <div class="col-sm-9 col-xs-9"><h3><?=Yii::t('userModule','Profile');?></h3></div>
</div>

<?php echo $form->textFieldGroup(
    $profile,
    'first_name',
    array(
        'maxlength'=>20,
        'size'=>20,
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'last_name',
    array(
        'maxlength'=>20,
        'size'=>20,
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->dropDownListGroup(
    $profile,
    'type',
    array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6 col-xs-6',
        ),
        'widgetOptions' => array(
            'data' => Profile::getUserTypes(),
        )
    )
); ?>
<?php echo $form->dropDownListGroup(
    $profile,
    'city_id',
    array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6 col-xs-6',
        ),
        'widgetOptions' => array(
            'data' => Cities::getAllCitiesListData(),
        )
    )
); ?>

<?php echo $form->textFieldGroup(
    $profile,
    'email',
    array(
        'maxlength'=>20,
        'size'=>20,
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textAreaGroup(
    $profile,
    'description',
    array(
        'widgetOptions' => array(
            'data' => Cities::getAllCitiesListData(),
            'htmlOptions' => array(
                'rows' => 8
            ),
        )
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'phone',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'skype',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'facebook',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'twitter',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'vimeo',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'youtube',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'linkedin',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'vk',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>
<?php echo $form->textFieldGroup(
    $profile,
    'ok',
    array(
        //'class'=> 'text-field',
        'wrapperHtmlOptions' =>
            array(
                'class' => 'col-sm-6 col-xs-6',
            ),
    )
); ?>



<?php $this->widget('booster.widgets.TbButton',
	array(
		'buttonType' => 'submit',
		'context' => 'success',
		'label' => $model->isNewRecord ? Yii::t('userModule','Create') : Yii::t('userModule','Save')
	)
);?>
<?php $this->endWidget(); ?>

