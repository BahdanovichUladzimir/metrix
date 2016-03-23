<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 26.06.2015
 * @var $model Deals
 * @var $form TbActiveForm
 * @var string $query
 * @var int $widgetId
 */
;?>
<?php $form=$this->beginWidget('CActiveForm',array(
    'id'=>'main_menu_search_string_form',
    'action'=>Yii::app()->createUrl('/deals/frontend/search/index'),
    'method'=>'get',
    'enableAjaxValidation'=>true,
    'htmlOptions' => array(
        'role' => 'search',
    )
)); ?>

<?php echo $form->textField(
    $model,
    'sphinxQuery',
    array(
        //'class'=>'form-control search-string',
        'id' => "main_menu_search_string_input",
        'maxlength' => 70,//@todo в конфиг повыносить
        'value' => (isset($query) && !is_null($query)) ? $query : NULL,
        'name' => 'query',
        'placeholder' => Yii::t('dealsModule', "Enter query"),
    )
); ?>
<input type="submit" name="search" value="">

<?php /*$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'label'=>Yii::t('core', 'Search'),
    'htmlOptions' => array(
        //'class' => 'search-submit btn',
        'name' => 'search',
        'value' => 'yes'
    )
)); */?>


<?php $this->endWidget();?>
<!--<form>
    <input type="text" name="" id="" placeholder="Поиск">
    <input type="submit" value="">
</form>-->
