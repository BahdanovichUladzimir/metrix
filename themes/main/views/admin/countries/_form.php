<?php
/**
 * @var $model Countries
 * @var $form TbActiveForm
 */
;?>
<?php if( Yii::app()->user->hasFlash('adminCountriesSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('adminCountriesSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminCountriesError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('adminCountriesError'); ?>
	</div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'countries-form',
	'enableAjaxValidation'=>true,
	'type'=>'horizontal',
)); ?>

<p class="help-block"><?=Yii::t('adminModule','Fields with <span class="required">*</span> are required.</p>');?>

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
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'key',
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
		'priority',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>
	<?php echo $form->dropDownListGroup(
		$model,
		'default_language',
		array(
			'widgetOptions' => array(
				'data' => Countries::getLanguagesListData(),
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>
    <?php echo $form->dropDownListGroup(
		$model,
		'currency_id',
		array(
			'widgetOptions' => array(
				'data' => Currencies::getCurrenciesListData(),
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>
	<?php if(sizeof($model->cities)>0):?>

		<div class="row">
			<div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
				<p class="text-right"><strong><?=Yii::t('adminModule',"Cities");?></strong></p>
			</div>
			<div class="col-sm-9 col-xs-9 col-lg-9 col-md-9">
				<ul class="list-unstyled">
					<?php foreach($model->cities as $city):?>
						<li>
							<?=CHtml::link($city->name,$city->getAdminUrl());?>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	<?php endif;?>

	<div class="form-actions">
		<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>
		<?php $this->widget(
			'bootstrap.widgets.TbButton',
			array(
				'buttonType' => 'reset',
				'context' => 'danger',
				'label' => Yii::t('core','Reset')
			)
		);?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'success',
			'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
