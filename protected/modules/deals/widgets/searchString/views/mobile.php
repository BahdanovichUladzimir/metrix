<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 10.07.2015
 * @var $model Deals
 * @var $form TbActiveForm
 * @var string $query
 * @var int $widgetId
 */
;?>
<div id="wgt_search_string_<?=$widgetId;?>">
    <?php $form=$this->beginWidget('CActiveForm',array(
        'id'=>'mobile_search_string_form',
        'action'=>Yii::app()->createUrl('/deals/frontend/search/index'),
        'method'=>'get',
        'enableAjaxValidation'=>true,
        'htmlOptions' => array(
            'role' => 'search',
            'class' => ''
        )
    )); ?>

    <?php echo $form->textField(
        $model,
        'sphinxQuery',
        array(
            //'class'=>'form-control search-string',
            'id' => "search_string_input",
            'maxlength' => 70,//@todo в конфиг повыносить
            'value' => (isset($query) && !is_null($query)) ? $query : NULL,
            'name' => 'query',
            'placeholder' => Yii::t('dealsModule', "Enter query"),
        )
    ); ?>
    <?php /*$this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        //'label'=>Yii::t('core', 'Search'),
        'htmlOptions' => array(
            //'class' => 'search-submit btn',
            'name' => 'search',
            'value' => 'yes'
        )
    )); */?>
    <?=CHtml::submitButton('',array('name' => 'search', 'value'=>'yes'));?>


    <?php $this->endWidget();?>
</div>