<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5','maxlength'=>10)),'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5','maxlength'=>50)),'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'key',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-12 col-sm-5 col-md-5 col-lg-5','maxlength'=>10)),'wrapperHtmlOptions' => array('class' => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',),)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
