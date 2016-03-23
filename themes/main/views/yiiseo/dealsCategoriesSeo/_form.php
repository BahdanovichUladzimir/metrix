<?php
/**
 * @var $model DealsCategoriesSeo
 * @var $form TbActiveForm
 * @var array $categoriesList
 * @var array $citiesList
 * @var array $languagesList
*/
;?>
<?php if( Yii::app()->user->hasFlash('yiiseoModule.DealsCategoriesSeo.Success')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('yiiseoModule.DealsCategoriesSeo.Success'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('yiiseoModule.DealsCategoriesSeo.Error')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('yiiseoModule.DealsCategoriesSeo.Error'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'deals-categories-seo-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>
<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

    <?php echo $form->dropDownListGroup(
        $model,
        'category_id',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
            ),
            'widgetOptions' => array(
                'data' => $categoriesList,
            )
        )
    ); ?>
    <?php echo $form->dropDownListGroup(
        $model,
        'city_id',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
            ),
            'widgetOptions' => array(
                'data' => $citiesList,
            )
        )
    ); ?>

	<?php echo $form->textFieldGroup($model,'h1',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

    <?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>

    <?php echo $form->dropDownListGroup(
        $model,
        'language',
        array(
            'wrapperHtmlOptions' => array(
                'class' => 'col-sm-6 col-xs-6',
            ),
            'widgetOptions' => array(
                'data' => $languagesList,
                'htmlOptions' => array('empty'=>'Select'),
            )
        )
    ); ?>
	<?php echo $form->textFieldGroup($model,'description',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>1000)))); ?>

	<?php echo $form->textFieldGroup($model,'keywords',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>1000)))); ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $form->ckEditorGroup(
                $model,
                'seotext',
                array(
                    'widgetOptions' => array(
                        'editorOptions' => array(
                            'fullpage' => 'js:true',
                            'width' => '620',
                            'resize_maxWidth' => '620',
                            'resize_minWidth' => '320'
                        )
                    )
                )
            ); ?>
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
		));
    ?>
</div>

<?php $this->endWidget(); ?>
