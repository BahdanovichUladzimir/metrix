<?php
/**
 * @var $model Cities
 * @var $form TbActiveForm
 */
;?>
<?php Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyAtc_4SE2BhMel6_WVpSBAjAeF1iczXUow&sensor=false");?>

<?php if( Yii::app()->user->hasFlash('adminCitiesSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('adminCitiesSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('adminCitiesError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('adminCitiesError'); ?>
	</div>
<?php endif; ?>

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'cities-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal'
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->textFieldGroup(
		$model,
		'name',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'col-xs-5 col-sm-5',
					'maxlength'=>100
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>
	<?php echo $form->dropDownListGroup(
		$model,
		'country_id',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'data' => CHtml::listData(Countries::model()->findAll(array('order'=>'Name ASC')),'id','name'),
			)
		)
	); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'key',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'col-xs-5 col-sm-5',
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
		'priority',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'col-xs-5 col-sm-5'
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'seo_title',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'col-xs-5 col-sm-5'
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
		)
	); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'noindex',
    array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-6 col-xs-6',
        ),
        'widgetOptions' => array(
            'data' => Cities::getNoIndexListData(),
        )
    )
); ?>

<div class="form-group">
	<label class="col-sm-3 control-label"><?=Yii::t('adminModule', 'City coordinates');?></label>
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
<div class="cities-container">
    <?php echo $form->checkBoxListGroup(
        $model,
        'geoipCitiesArray',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
                'style'=>'height:300px;overflow:scroll;border:1px solid #cccccc',
            ),
            'widgetOptions' => array(
                'data' => GeoipCities::getListData(),
                'htmlOptions' => array(
                    'style' => "margin:0 5px 0 0;position: relative;"
                )
            )
        )
    ); ?>

</div>
<?php if(sizeof($model->undergrounds)>0):?>
	<div class="row">
		<div class="col-sm-3 col-xs-3 col-lg-3 col-md-3">
			<p class="text-right"><strong><?=Yii::t('adminModule',"Undergrounds");?></strong></p>
		</div>
		<div class="col-sm-9 col-xs-9 col-lg-9 col-md-9">
			<ul class="list-unstyled">
				<?php foreach($model->undergrounds as $underground):?>
					<li>
						<?=CHtml::link($underground->name,$underground->getAdminUrl());?>
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
