<?php
/**
 * @var $model DealLinks
 * @var $deal Deals
 * @var $form TbActiveForm
*/
;?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'deal-links-form',
    'action' => Yii::app()->createUrl('deals/user/dealLinks/create'),
	'enableAjaxValidation'=>true,
	//'type' => 'horizontal',
)); ?>
<div class="success" id="add_link_messages_container">

</div>
<?php echo $form->textFieldGroup($model,'link',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>255)))); ?>
<?php echo $form->hiddenField($model,'deal_id',array('maxlength'=>11, "value"=>$deal->id)); ?>
<div class="form-group">
    <?=CHtml::ajaxSubmitButton(
        Yii::t('core','Add video link'),
        Yii::app()->createUrl('/deals/user/dealLinks/create'),
        array(
            'success' => 'js:function(data){
                data = $.parseJSON(data);
                if(data.status == "success"){
                    $.fn.yiiListView.update("user_youtube_links_list");
                    $("#DealLinks_link").val("");
                    $("#add_link_messages_container").append(data.html);
                }
                else{
                    console.log(data.message)
                }
            }'
        ),
        array('class' => 'btn btn-success')
    )
    ;?>
</div>

<?php $this->endWidget(); ?>
