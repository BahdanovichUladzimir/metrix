<?php
/**
 * @var $model Doings
 * @var $form TbActiveForm
*/
;?>
<?php if( Yii::app()->user->hasFlash('doingsSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('doingsSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('doingsError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('doingsError'); ?>
	</div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'doings-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>
<div class="form-group">
    <label class="col-sm-3 control-label" for="Doings_eventsTypes"><?=Yii::t("eventsModule",'Events types');?></label>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <?php $this->widget(
            'bootstrap.widgets.TbSelect2',
            array(
                'model' => $model,
                'attribute' => 'eventsTypes',
                'data' => CHtml::listData(EventsTypes::model()->findAll(),'id', 'label'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                ),
            )
        );?>
    </div>
</div>
<?php echo $form->dropDownListGroup(
    $model,
    'category_id',
    array(
        'widgetOptions' => array(
            'data' => CHtml::listData(EventsDoingsCategories::model()->findAll(),"id","name"),
            'htmlOptions' => array(
                'class' => "col-xs-9 col-sm-9 col-md-9 col-lg-9"
            )
        ),
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-12 col-xs-12 col-md-4 col-lg-4',
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
			'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
