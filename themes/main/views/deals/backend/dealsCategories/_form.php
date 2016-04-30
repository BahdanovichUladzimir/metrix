<?php
/**
 * @var $model DealsCategories
 * @var $form TbActiveForm
 * @var array $categoriesList
 * @var array $statusesList
 */
;?>
<?php if( Yii::app()->user->hasFlash('dealsCategoriesSuccess')):?>
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('dealsCategoriesSuccess'); ?>
	</div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('dealsCategoriesError')):?>
	<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo Yii::app()->user->getFlash('dealsCategoriesError'); ?>
	</div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'deals-categories-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    )
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>
<?php if(!is_null($model->image)):?>
    <div class="form-group">
        <div class="col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <?=CHtml::image($model->getMediumThumbUrl(),$model->name);?>
        </div>
    </div>
<?php endif;?>
    <?php echo $form->fileFieldGroup($model, 'file',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
            ),
        )
    ); ?>
	<?php echo $form->textFieldGroup(
        $model,
        'name',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                    'maxlength'=>255
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
            ),
        )
    ); ?>
	<?php echo $form->textFieldGroup(
        $model,
        'priority',
        array(
            'widgetOptions'=>array(
                'htmlOptions'=>array(
                    'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
                    'maxlength'=>2
                )
            ),
            'wrapperHtmlOptions' => array(
                'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
            ),
        )
    ); ?>

	<?php echo $form->textFieldGroup(
		$model,
		'url_segment',
		array(
			'widgetOptions'=>array(
				'htmlOptions'=>array(
					'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
					'maxlength'=>255
				)
			),
			'wrapperHtmlOptions' => array(
				'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
			),
		)
	); ?>

<?php echo $form->textFieldGroup(
		$model,
		'page_count',
		array(
				'widgetOptions'=>array(
						'htmlOptions'=>array(
								'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
								'maxlength'=>255,
								'value' => 50
						)
				),
				'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
				),
		)
); ?>
<?php echo $form->textFieldGroup(
		$model,
		'free_deals_count',
		array(
				'widgetOptions'=>array(
						'htmlOptions'=>array(
								'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
								'maxlength'=>255,
								'value' => 50
						)
				),
				'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
				),
		)
); ?>
<?php echo $form->textFieldGroup(
		$model,
		'paid_placement_price',
		array(
				'widgetOptions'=>array(
						'htmlOptions'=>array(
								'class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5',
								'maxlength'=>255
						)
				),
				'wrapperHtmlOptions' => array(
						'class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
				),
		)
); ?>

<?php echo $form->dropDownListGroup(
		$model,
		'parent_id',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'data' => $categoriesList,
			)
		)
	); ?>

	<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<?php echo $form->dropDownListGroup(
		$model,
		'status_id',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-6 col-xs-6',
			),
			'widgetOptions' => array(
				'data' => $statusesList,
			)
		)
	); ?>

<div class="form-group">
	<label class="col-sm-3 control-label" for="DealsCategories_dealsCategoriesParams"><?=Yii::t("dealsModule",'Category params');?></label>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<?php $this->widget(
			'bootstrap.widgets.TbSelect2',
			array(
				'model' => $model,
				'attribute' => 'params',
				'data' => $model->getAvailableParamsListData(),
				'htmlOptions' => array(
					'multiple' => 'multiple',
				),
			)
		);?>
	</div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <strong><?=Yii::t('dealsModule',"Parent categories params:");?></strong>
        <ul>
            <?php foreach($model->getParentsParams() as $parentParam):?>
                <li><?=$parentParam->label;?> (<?=$parentParam->name;?>)</li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label" for="DealsCategories_dealsCategoriesParams"><?=Yii::t("dealsModule",'Category ratings');?></label>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<?php $this->widget(
			'bootstrap.widgets.TbSelect2',
			array(
				'model' => $model,
				'attribute' => 'ratings',
				'data' => CHtml::listData(Ratings::model()->findAll(array('order'=>'name ASC')),'id','label'),
				'htmlOptions' => array(
					'multiple' => 'multiple',
				),
			)
		);?>
	</div>
</div>
<?php echo $form->dropDownListGroup(
	$model,
	'no_index',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
		),
		'widgetOptions' => array(
			'data' => DealsCategories::getNoIndexListData(),
		)
	)
); ?><?php echo $form->checkboxGroup(
	$model,
	'for_adults',
	array(
		'wrapperHtmlOptions' => array(
			'class' => 'col-sm-6 col-xs-6',
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
</div>

<?php $this->endWidget(); ?>
