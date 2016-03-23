<?php
/**
 * @var $model Lists
 * @var $form TbActiveForm
*/
;?>
<?php if( Yii::app()->user->hasFlash('adminListsSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminListsSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminListsError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('adminListsError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'lists-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>50)))); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'type',
    array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6 col-xs-6',
        ),
        'widgetOptions' => array(
            'data' => Lists::getListsTypes(),
        )
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
		)
    );?>
    <?php echo CHtml::link(Yii::t('adminModule', 'Add list item'),Yii::app()->createUrl('/admin/listItems/create', array('list_id' => $model->id)),array('class' => 'btn btn-success'));?>
</div>
<br>
<div class="form-actions">
<?php if(sizeof($model->listItems)>0):?>
    <h4><?=Yii::t('adminModule', 'List items:');?></h4>
    <ul>
        <?php foreach ($model->listItems as $item):?>
            <li>
                <?=CHtml::link($item->name.' ('.$item->value.')', Yii::app()->createUrl('/admin/listItems/update', array('id' => $item->id)));?>
                <?=CHtml::link('<i class="glyphicon glyphicon-remove"></i>', Yii::app()->createUrl('/admin/listItems/delete', array('id' => $item->id)),array('class'=>'btn btn-danger btn-xs'));?>
            </li>
        <?php endforeach;?>
    </ul>
<?php endif;?>
</div>

<?php $this->endWidget(); ?>
