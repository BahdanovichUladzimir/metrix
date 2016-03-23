<?php
/**
 * @var $model SocialMediaPosting
 * @var $form TbActiveForm
*/

;?>

<?php if( Yii::app()->user->hasFlash('cmsPostingSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('cmsPostingSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('cmsPostingError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('cmsPostingError'); ?>
    </div>
<?php endif; ?>

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'social-media-posting-form',
	'enableAjaxValidation'=>true,
	'type' => 'horizontal',
)); ?>

<p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>

	<?php echo $form->textFieldGroup($model,'title',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
	<?php echo $form->textFieldGroup($model,'link'); ?>
	<?php echo $form->textAreaGroup($model,'description'); ?>

    <?php /*echo $form->ckEditorGroup(
        $model,
        'description',
        array(
            'widgetOptions' => array(
                'editorOptions' => array(
                    'fullpage' => 'js:true',
                    'width' => '100%',
                    'resize_maxWidth' => '100%',
                    'resize_minWidth' => '320',
                )
            )
        )
    ); */?>
	<?php /*echo $form->textFieldGroup($model,'poste_date_time',array('widgetOptions'=>array('htmlOptions'=>array()))); */?>
    <!--<div class="form-group">
        <label for="SocialMediaPosting_posted_date_time" class="control-label col-sm-3"><?/*=$model->getAttributeLabel('posted_date_time');*/?></label>
        <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                <?php
/*                $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'posted_date_time',
                    'options' => array(
                        //'datepicker'=>false,
                        'format'=>'Y-m-d H:i:s'
                    ), //DateTimePicker options
                    'htmlOptions' => array(
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel('posted_date_time')
                    ),
                ));
                ;*/?>
            </div>
            <div style="display:none" id="SocialMediaPosting_posted_date_time_em_" class="help-block error"></div>
        </div>
    </div>-->

    <div class="form-group">
        <label for="SocialMediaPosting_post_date_time" class="control-label col-sm-3"><?=$model->getAttributeLabel('post_date_time');?></label>
        <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                <?php
                $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                    'model' => $model,
                    'attribute' => 'post_date_time',
                    'options' => array(
                        //'datepicker'=>false,
                        'format'=>'Y-m-d H:i:s',
                        'value' => (isset($model->post_date_time) && strlen(trim($model->post_date_time))) ? $model->post_date_time : date('Y-m-d H:i:s',time()),
                    ), //DateTimePicker options
                    'htmlOptions' => array(
                        'class' => 'form-control',
                        'placeholder' => $model->getAttributeLabel('post_date_time'),
                        'value' => (isset($model->post_date_time) && strlen(trim($model->post_date_time))) ? $model->post_date_time : date('Y-m-d H:i:s',time()),
                    ),
                ));
                ;?>
            </div>
            <div style="display:none" id="SocialMediaPosting_post_date_time_em_" class="help-block error"></div>
        </div>
    </div>

	<?php echo $form->dropDownListGroup(
			$model,
			'status',
			array(
                'widgetOptions' => array(
                    'data' => SocialMediaPosting::$statuses,
                    'htmlOptions' => array(
                        'class' => "col-xs-9 col-sm-9 col-md-9 col-lg-9"
                    )
                ),
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-12 col-xs-12 col-md-4 col-lg-4'
                ),
			)
	); ?>
	<?php echo $form->dropDownListGroup(
			$model,
			'type',
			array(
                'widgetOptions' => array(
                    'data' => SocialMediaPosting::$types,
                    'htmlOptions' => array(
                        'class' => "col-xs-9 col-sm-9 col-md-9 col-lg-9"
                    )
                ),
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-12 col-xs-12 col-md-4 col-lg-4'
                ),

			)
	); ?>
	<?php echo $form->dropDownListGroup(
			$model,
			'network',
			array(
                'widgetOptions' => array(
                    'data' => SocialMediaPosting::$networks,
                    'htmlOptions' => array(
                        'class' => "col-xs-9 col-sm-9 col-md-9 col-lg-9"
                    )
                ),
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-12 col-xs-12 col-md-4 col-lg-4'
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
