<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>11)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'type_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>11)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'field_size',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>3)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'field_size_min',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>3)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'required',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>1)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'match',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'range',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'error_message',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textAreaGroup($model,'other_validator', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'default',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'position',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'visible',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'widget',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textAreaGroup($model,'widget_params', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>50)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'label',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>50)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
