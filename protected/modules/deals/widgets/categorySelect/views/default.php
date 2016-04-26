<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 29.07.2015
 * @var string $selects
 * @var $model Deals
 */
if($model->hasErrors('categories')){
    $errorsString = implode(' ',$model->getErrors('categories'));
}
;?>
<script>
    $('document').ready(function(){
        $('.categories-select-container').on('change',".categories-select", function(){
            var selected_value = $(this).val();
            var wrapper = $(this).closest('.select-wrap');
            var subcats_container = wrapper.find('.subcats');
            $.ajax({
                url: "<?=Yii::app()->createUrl('/deals/user/userDeals/getDealCategoriesParams');?>",
                type: "get",
                dataType: 'json',
                <?php if($model->isNewRecord):?>
                data: {'categories[]':selected_value},
                <?php else:?>
                data: {'categories[]':selected_value,'deal_id':"<?=$model->id;?>"},
                <?php endif;?>
                success: function(data){
                    if(typeof data.status !== "undefined"){
                        if(data.status === 'continue'){
                            $("#deal_categories_params").empty();
                            subcats_container.html(data.html);
                            wrapper.find('.form-group').addClass("has-success").removeClass('has-error');
                            $(".categories-select-help-block").text('').hide();
                        }
                        else if(data.status === 'end'){
                            $("#deal_categories_params").html(data.html);
                            subcats_container.empty();
                            wrapper.find('.form-group').addClass("has-success").removeClass('has-error');
                            $(".categories-select-help-block").text('').hide();

                        }
                        else if(data.status === 'empty'){
                            subcats_container.html(data.html);
                            $("#deal_categories_params").html(data.html);
                            wrapper.find('.form-group').addClass("has-error");
                            $(".categories-select-help-block").text(data.message).show();
                        }
                    }
                    $("select").selectpicker();
                }
            });
        });
    })
</script>
<div class="select-wrap">
    <div class="form-group <?=($model->hasErrors('categories')) ? 'has-error':'';?>">
        <label for="Deals_categories" class="control-label required"><?=Yii::t('dealsModule',"Select category");?><span class="required">*</span></label>
        <?=$selects;?>
        <div class="help-block error categories-select-help-block" <?=($model->hasErrors('categories')) ? 'style="display:block;"':'';?>><?=($model->hasErrors('categories')) ? $errorsString:'';?></div>

    </div>
</div>