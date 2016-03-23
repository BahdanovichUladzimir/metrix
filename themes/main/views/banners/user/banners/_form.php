<?php
/**
 * @var $model Banners
 * @var $form TbActiveForm
*/
$xs = "12";
$sm = "12";
$lg = "4";
$md = "9";
;?>
<?php if( Yii::app()->user->hasFlash('bannersUserBannersSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('bannersUserBannersSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('bannersUserBannersError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('bannersUserBannersError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'banners-form',
	'enableAjaxValidation'=>false,
	'type' => 'vertical',
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    )


)); ?>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6 col-md-<?=$md;?> col-sm-<?=$sm;?> col-xs-<?=$xs;?>">
				<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

                <?=CHtml::image($model->getImageUrl(),$model->name);?>

                <?php /*echo $form->fileFieldGroup($model,'file',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); */?>
                <div class="form-group">
                    <?php if($model->isNewRecord):?>
                        <?php echo $form->fileField($model,'file', array('class' => 'form-control')); ?>
                        <?php echo $form->error($model,'file', array('class'=> 'text-danger')); ?>
                        <span class="note"><?=Yii::t('bannersModule','The width of 265-300 pixels. The height of 300-500 pixels.');?></span>
                    <?php endif;?>

                </div>

                <?php echo $form->textFieldGroup(
                    $model,
                    'name',
                    array(
                        'widgetOptions'=>array(
                            'htmlOptions'=>array(
                                //'class'=>'col-xs-5 col-sm-5',
                                'maxlength'=>255,
                                'placeholder' => Yii::t('bannersModule',"For example: Photographer in Moscow"),
                            )
                        ),
                    )
                ); ?>

                <?php echo $form->dropDownListGroup(
                    $model,
                    'categories',
                    array(
                        'widgetOptions' => array(
                            'data' => CHtml::listData(DealsCategories::getRootCategories(false,false), 'id', 'name'),
                            'htmlOptions' => array(
                                'multiple' => true,
                            ),
                        ),
                    )
                ); ?>
                <?php echo $form->dropDownListGroup(
                    $model,
                    'cities',
                    array(
                        'widgetOptions' => array(
                            'data' => CHtml::listData(Cities::model()->findAll(), 'id', 'name'),
                            'htmlOptions' => array(
                                'multiple' => true
                            ),
                        )
                    )
                ); ?>


                <?php echo $form->textFieldGroup($model,'link',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
                <input type="hidden" name="Banners[published]" value="0" id="ytBanners_published">
                <label class="checkbox">
                    <input type="checkbox" value="1" checked='checked' id="Banners_published" name="Banners[published]" class="form-control">
                    <span class="a-spr"></span> <?=$model->getAttributeLabel('published');?>
                </label>
			</div>
		</div>

		<div class="add-bottom-nav">
			<?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer);?>
			<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType'=>'submit',
				'context'=>'success',
				'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
				'htmlOptions' => array(
					'class' => 'go a-spr'
				)
			)); ?>
		</div>
	</div>
</div>


<?php $this->endWidget(); ?>
