<?php echo $form->textFieldGroup($model,'name'); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'parentId',
    array(
        'wrapperHtmlOptions' => array(
            //'class' => 'col-sm-5 col-md-5 col-xs-12',
        ),
        'widgetOptions' => array(
            'data' => $model->getParentOptionTree(),
            'htmlOptions' => array(),
        )
    )
); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'type',
    array(
        'wrapperHtmlOptions' => array(
            //'class' => 'col-sm-5 col-md-5 col-xs-12',
        ),
        'widgetOptions' => array(
            'data' => $model->getTypeOptions(),
            'htmlOptions' => array(),
        )
    )
); ?>
<?php echo $form->checkboxGroup($model,'published') ?>