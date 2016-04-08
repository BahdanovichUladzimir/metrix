<?php
/**
 * @var $model Deals
 * @var $paramsModel DealCategoriesParams
 * @var $imagesModel DealsImages
 * @var array $categoriesList All categories list
 * @var array $statusesList User statuses list
 * @var array $approveList Admin approves list
 * @var array $archiveList Admin archives list
 * @var array $usersList Admin users list
 * @var array $citiesList Admin cities list
 * @var array $currenciesList Admin currencies list
 * @var array $priorityList Priority values list
 * @var $form TbActiveForm
*/
;?>

<?php Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true&language=ru");?>
<?php if( Yii::app()->user->hasFlash('backendDealsSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('backendDealsSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('backendDealsError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('backendDealsError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'deals-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'type' => 'vertical',
	'clientOptions'=>array(
		"validateOnSubmit"=> true,
		'validateOnChange' => true,
		'validateOnType' => true,
	)
)); ?>
<?php if(!$model->isNewRecord):?>
    <?php echo CHtml::link(Yii::t('core', 'View Deal on Site'),$model->getPublicUrl(), array('class' => 'btn btn-info'));?>

    <?php echo CHtml::link(Yii::t('core', 'View Deal in admin panel'),$model->getAdminUrl(), array('class' => 'btn btn-info'));?>
    <?php echo CHtml::ajaxLink(
        Yii::t('core', 'Sent back for revision'),
        Yii::app()->createUrl("/deals/backend/deals/sentBackForRevision", array('id' => $model->id)),
        array(
            //'data' => array('id' => $model->id),
            'type' => 'post',
            'dataType' => 'json'
        ),
        array('class' => 'btn btn-warning')
    );?>
<?php endif;?>
<hr>
<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<?php echo $form->textFieldGroup(
			$model,
			'name',
			array(
				'widgetOptions'=>array(
					'htmlOptions'=>array(
						//'class'=>'col-xs-5 col-sm-5',
						'maxlength'=>255
					)
				),
			)
		); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
		<?php echo $form->textAreaGroup(
			$model,
			'intro',
			array(
				'widgetOptions'=>array(
					'htmlOptions'=>array(
						'rows'=>6,
						'cols'=>50,
						'class'=>'span8',
					)
				),
			)
		); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo $form->ckEditorGroup(
			$model,
			'description',
			array(
				'widgetOptions' => array(
					'editorOptions' => array(
						'fullpage' => 'js:true',
						'width' => '640',
						'resize_maxWidth' => '640',
						'resize_minWidth' => '320'
					)
				)
			)
		); ?>
	</div>
</div>


<?php if($model->city_id === NULL):?>
    <?php $model->city_id = (is_null(Yii::app()->request->cookies['cityId'])) ? (int)Yii::app()->config->get("ADMIN_MODULE.DEFAULT_CITY_ID") : (int)Yii::app()->request->cookies['cityId']->value;?>
<?php endif;?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<?php echo $form->dropDownListGroup(
			$model,
			'city_id',
			array(
				'widgetOptions' => array(
					'data' => $citiesList,
				)
			)
		); ?>
	</div>
</div>
<?php if(!$model->isNewRecord):?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php echo $form->textFieldGroup(
                $model,
                'created_date',
                array(
                    'widgetOptions'=>array(
                        'htmlOptions'=>array(
                            'maxlength'=>12,
                            'disabled' => true,
                            'value' => $model->formattedCreatedDate
                        )
                    ),
                )
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php echo $form->textFieldGroup(
                $model,
                'published_date',
                array(
                    'widgetOptions'=>array(
                        'htmlOptions'=>array(
                            'maxlength'=>12,
                            'disabled' => true,
                            'value' => $model->formattedPublishedDate
                        )
                    ),
                )
            ); ?>
        </div>
    </div>
<?php endif;?>
<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
		<?php echo $form->dropDownListGroup(
			$model,
			'priority',
			array(
				'widgetOptions' => array(
					'data' => $priorityList,
				)
			)
		); ?>

	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<?php echo $form->dropDownListGroup(
			$model,
			'categories',
			array(
				'widgetOptions' => array(
					'data' => $categoriesList,
					'htmlOptions' => array(
						'multiple' => false,
                        'empty' => Yii::t('dealsModule', 'Select category'),
						//'style' => 'height: 200px;',
						'ajax' => array(
							'type' => 'POST', //request type
							'url' => Yii::app()->createUrl('/deals/backend/deals/getDealCategoriesParams'), //url to call.
							'update' => '#deal_categories_params',
							'data'=> $model->isNewRecord ? array('categories' => 'js:$(this).val()') : array('deal_id' => $model->id, 'categories' => 'js:$(this).val()'),
						),
					),
				)
			)
		); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<?php echo $form->dropDownListGroup(
			$model,
			'approve',
			array(
				'widgetOptions' => array(
					'data' => $approveList,
				)
			)
		); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<?php echo $form->dropDownListGroup(
			$model,
			'archive',
			array(
				'widgetOptions' => array(
					'data' => $archiveList,
				)
			)
		); ?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
		<?php echo $form->dropDownListGroup(
			$model,
			'status_id',
			array(
				'widgetOptions' => array(
					'data' => $statusesList,
				)
			)
		); ?>
	</div>
</div>
<div id="deal_categories_params">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php $priceParams = array();?>
			<?php foreach($paramsModel->getCurrentCategoriesParams() as $categoriesParam):?>
				<?php $fieldType = $categoriesParam->type->name;?>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<?php if($fieldType == 'list'):?>
                            <?php if(!is_null($categoriesParam->list_id)):?>
                                <?php $data = CHtml::listData(ListItems::model()->findAll(':list_id=list_id',array(':list_id' => $categoriesParam->list_id)),'value','name');?>
                            <?php elseif($categoriesParam->range):?>
                                <?php $data = DealCategoriesParams::range($categoriesParam->range);?>
                            <?php else:?>
                                <?php $data = array(0=>'List items not found');?>
                            <?php endif;?>
							<?php echo $form->dropDownListGroup(
								$paramsModel,
								$categoriesParam->name,
								array(
									'widgetOptions' => array(
										'data' => $data,
										'htmlOptions' => array(
											'selected' => $categoriesParam->default
										),
									)
								)
							);?>
						<?php elseif($fieldType == 'bool'):?>
                            <?php echo $form->checkboxGroup(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'widgetOptions' => array(
                                        'htmlOptions' => array(
                                            'uncheckValue'=>0
                                        )
                                    )
                                )); ?>
						<?php elseif($fieldType == 'coordinates_widget'):?>
							<div class="form-group<?=(sizeof($paramsModel->getErrors('coordinates'))>0) ? ' has-error' : '';?>">
								<label class="control-label"><?=Yii::t('adminModule', 'Coordinates');?></label>
								<div class="coordinate-picker">
									<?php
									$this->widget('widgets.locationpicker.LocationPicker', array(
										'model' => $paramsModel,
										'latId' => "latitude", //can be replaced using your own attribute
										'lonId' => "longitude", //can be replaced using your own attribute
										'ltnCenter' => $paramsModel->latitude,
										'lngCenter' => $paramsModel->longitude,
										'searchLabel' => Yii::t('core',"Search"),
									));
									?>
								</div>
								<?php echo $form->error($paramsModel,'coordinates'); ?>
							</div>
							<?php if(sizeof($paramsModel->getAroundUndergrounds())>0):?>
								<div class="row">
									<div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
										<p><strong><?=Yii::t('adminModule',"Around Underground stations");?></strong></p>
									</div>
									<div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
										<ul>
											<?php foreach($paramsModel->getAroundUndergrounds() as $underground):?>
												<li>
													<?=CHtml::link($underground->name,$underground->getAdminUrl());?>
												</li>
											<?php endforeach;?>
										</ul>
									</div>
								</div>
							<?php endif;?>
						<?php elseif($fieldType == 'text'):?>
							<?php echo $form->textAreaGroup(
								$paramsModel,
								$categoriesParam->name,
								array(
									'widgetOptions'=>array(
										'htmlOptions'=>array(
											'maxlength'=>$categoriesParam->field_size,
											'minlength'=>$categoriesParam->field_size_min,
										)
									),
								)
							); ?>
						<?php elseif($fieldType == 'price'):?>
							<?php $priceParams[] = $categoriesParam;?>
						<?php else:?>
							<?php echo $form->textFieldGroup(
								$paramsModel,
								$categoriesParam->name,
								array(
									'widgetOptions'=>array(
										'htmlOptions'=>array(
											'maxlength'=>$categoriesParam->field_size,
											'minlength'=>$categoriesParam->field_size_min,
										)
									),
								)
							); ?>
						<?php endif;?>
						</div>
					</div>
			<?php endforeach;?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <?php foreach($priceParams as $priceParam):?>
                        <?php echo CHtml::activeLabel($paramsModel, $priceParam->name, array('class' => 'control-label'));?>
                        <?php echo CHtml::activeTextField($paramsModel, $priceParam->name, array('class' => 'form-control'));?>
                    <?php endforeach;?>
                </div>
            </div>
		</div>
	</div>
    <?php if($paramsModel->isShowCurrenciesSelect):?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'currency_id',
                    array(
                        'widgetOptions' => array(
                            'data' => $currenciesList,
                        )
                    )
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <?php echo $form->checkboxGroup(
                    $model,
                    'negotiable',
                    array(
                        'widgetOptions' => array(
                            'htmlOptions' => array(
                                'value'=>1, 'uncheckValue'=>0
                            )
                        )
                    )); ?>
            </div>
        </div>
    <?php endif;?>

</div>

<div class="form-actions">
	<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default'));?>
    <?php if(!$model->isNewRecord):?>
        <?php echo CHtml::link(Yii::t('core', 'View'),$model->getPublicUrl(), array('class' => 'btn btn-info'));?>
    <?php endif;?>
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
	<?php echo CHtml::ajaxLink(
		Yii::t('core', 'Sent back for revision'),
		Yii::app()->createUrl("/deals/backend/deals/sentBackForRevision", array('id' => $model->id)),
        array(
            //'data' => array('id' => $model->id),
            'type' => 'post',
            'dataType' => 'json'
        ),
		array('class' => 'btn btn-warning')
    );?>
</div>

<?php $this->endWidget(); ?>
