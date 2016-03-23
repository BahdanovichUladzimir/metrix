<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 28.08.2015
 * @var $userModel User
 * @var $model CmsPage
 * @var $form TbActiveForm
 * @var string $returnUrl
 */

;?>
<h1><?=$model->heading;?></h1>
<div class="agreement-container well">
    <?=$model->render();?>
</div>
<?php $form = $this->beginWidget(
    'booster.widgets.TbActiveForm',
    array(
        'id' => 'agreement_form',
        //'enableAjaxValidation'=>true,
        //'enableClientValidation'=>true,
        //'type' => 'horizontal',
        //'htmlOptions' => array('class' => 'well'), // for inset effect
        //'clientOptions'=>array(
            //'successCssClass'=> 'has-success',
            //'errorCssClass'=> 'has-error',
            //'validateOnSubmit'=>true,
            //'validationUrl'=>Yii::app()->createUrl('/user/login/validate'),
        //),
        //'errorMessageCssClass' => 'text-danger small',
    )
);?>

<?php echo $form->checkboxGroup(
    $userModel,
    'agreement',
    array(
        'label' => Yii::t('userModule','I agree'),
        'widgetOptions' => array(
            'htmlOptions' => array(
                'checked' => ($userModel->agreement == '1') ? 'checked' : '',
            )
        ),
    )
); ?>

<?php echo $form->hiddenField(
    $userModel,
    'returnUrl',
    array(
        'value' => $returnUrl,
    )
); ?>
<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>

<?php $this->widget('booster.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context' => 'success',
        'label' => Yii::t('userModule',"Continue")
    )
);?>
<?php $this->endWidget();?>
<?php unset($form);?>
