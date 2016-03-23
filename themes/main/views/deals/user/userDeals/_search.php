<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>11)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textAreaGroup($model,'intro', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'is_published',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textAreaGroup($model,'description', array('widgetOptions'=>array('htmlOptions'=>array('rows'=>6, 'cols'=>50, 'class'=>'span8')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'price',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'user_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'status_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>3)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'created_date',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>12)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'published_date',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>12)),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

		<?php echo $form->textFieldGroup($model,'priority',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5')),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),)); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
