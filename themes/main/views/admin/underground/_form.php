<?php
/**
 * @var $model Underground
 */
;?>
<?php Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true&language=ru");?>

<?php if( Yii::app()->user->hasFlash('adminUndergroundSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('adminUndergroundSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminUndergroundError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('adminUndergroundError'); ?>
	</div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'underground-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t('adminModule','Fields with <span class="required">*</span> are required.');?></p>

	<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>
	<?php echo $form->dropDownListGroup(
		$model,
		'city_id',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'data' => CHtml::listData(Cities::model()->findAll(array('order'=>'Name ASC')),'id','name'),
			)
		)
	); ?>
	<?php echo $form->textFieldGroup($model,'priority',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>
<div class="form-group">
	<label class="col-sm-3 control-label"><?=Yii::t('adminModule', 'Underground coordinates');?></label>
	<div class="col-xs-12 col-md-6 col-sm-10 coordinate-picker">
		<?php
		$this->widget('widgets.locationpicker.LocationPicker', array(
			'model' => $model,
			'latId' => "latitude", //can be replaced using your own attribute
			'lonId' => "longitude", //can be replaced using your own attribute
			'ltnCenter' => $model->latitude,
			'lngCenter' => $model->longitude,
			'searchLabel' =>Yii::t('core',"Search"),
		));
		?>
	</div>

</div>
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
