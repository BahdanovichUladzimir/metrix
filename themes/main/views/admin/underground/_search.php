<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldGroup($model,'id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>11))),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),); ?>

		<?php echo $form->textFieldGroup($model,'city_id',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>11))),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),); ?>

		<?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5','maxlength'=>255))),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),); ?>

		<?php echo $form->textFieldGroup($model,'longitude',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5'))),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),); ?>

		<?php echo $form->textFieldGroup($model,'latitude',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5'))),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),); ?>

		<?php echo $form->textFieldGroup($model,'priority',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'col-xs-5 col-sm-5'))),'wrapperHtmlOptions' => array('class' => 'col-sm-6 col-xs-6',),); ?>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
