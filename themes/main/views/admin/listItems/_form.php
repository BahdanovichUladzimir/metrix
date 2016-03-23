<?php
/**
 * @var $model ListItems
 * @var $form TbActiveForm
 * @var array $listsListData
*/
;?>
<?php if( Yii::app()->user->hasFlash('adminModule.ListItems.Success')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminModule.ListItems.Success'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminModule.ListItems.Error')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminModule.ListItems.Error'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'list-items-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

    <?php echo $form->dropDownListGroup(
        $model,
        'list_id',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-12 col-xs-12 col-md-6 col-lg-6',
            ),
            'widgetOptions' => array(
                'data' => $listsListData,
            )
        )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'name',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'maxlength'=>50
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-12 col-xs-12 col-md-6 col-lg-6',
            ),
        )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'value',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'maxlength'=>50
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-12 col-xs-12 col-md-6 col-lg-6',
            ),
        )
    ); ?>

	<?php echo $form->textFieldGroup(
        $model,
        'sort',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'maxlength'=>10
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-12 col-xs-12 col-md-6 col-lg-6',
            ),
        )
    ); ?>

<div class="form-actions">
	<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>
    <?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'reset',
			'context'=>'danger',
			'label'=>Yii::t('core','Reset'),
		)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
		)); ?>
    <?php if(!$model->isNewRecord):?>
        <?=CHtml::link(Yii::t('core','Delete'), Yii::app()->createUrl('/admin/listItems/delete', array('id' => $model->id)),array('class'=>'btn btn-danger'));?>
    <?php endif;?>
</div>

<?php $this->endWidget(); ?>
