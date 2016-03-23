<?php
/**
 * @var $model Comments
 * @var $form TbActiveForm
*/
;?>
<?php if( Yii::app()->user->hasFlash('commentsBackendCommentsUpdateSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('commentsBackendCommentsUpdateSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('commentsBackendCommentsUpdateError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('commentsBackendCommentsUpdateError'); ?>
    </div>
<?php endif; ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php /*echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); */?>

	<?php /*echo $form->textFieldGroup($model,'parent_id',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>11)))); */?>

	<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50)))); ?>

    <?php echo $form->checkboxGroup(
        $model,
        'approve',
        array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'value'=>1, 'uncheckValue'=>0
                )
            )
        ));
    ?>
<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
        <?php $this->widget('booster.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                //'title',
                'parent_id',
                array(
                    'label'=>'App category',
                    'type'=>'raw',
                    'value'=>CHtml::link(CHtml::encode($model->appCategory->name), array('/admin/appCategories/update','id'=>$model->appCategory->id)),
                ),
                'app_category_item_id',
                array(
                    'label'=>'User',
                    'type'=>'raw',
                    'value'=>CHtml::link(CHtml::encode($model->user->username), $model->user->getAdminUrl()),
                ),
                array(
                    'label'=>'Created date',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->formattedCreatedDate),
                ),
                array(
                    'label'=>'Published date',
                    'type'=>'raw',
                    'value'=>CHtml::encode($model->formattedPublishedDate),
                ),
            ),
        )); ?>
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
