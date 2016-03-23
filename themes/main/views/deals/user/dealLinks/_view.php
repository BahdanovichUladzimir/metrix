<?php
/**
 * @var $data DealLinks
 */
;?>
<div class="add-element template-download" id="deal_social_link_<?=$data->id;?>">
    <div class="row">
        <div class="col-lg-3">
            <div class="image-wrap">
                <label class="checkbox">
                    <input type="checkbox" name="delete" data-link_id="<?=$data->id;?>" value="1">
                    <span class="a-spr"></span>
                </label>
                <?php if($data->link_type == 'youtube'):?>
                    <a href="<?=Yii::app()->request->baseUrl."/js/uppod.swf?file=".$data->link;?>&https=1" class="thumbnail deal-link-thumb img fancybox-video" data-type="<?=$data->link_type;?>" rel="deal_<?=$data->deal_id;?>_videos_group">
                        <img class="fancy-video" src="<?=$data->getSmallThumbUrl();?>" alt="<?=$data->link;?>" />
                    </a>
                <?php elseif($data->link_type == 'vimeo'):?>
                    <a href='<?=$data->link;?>' class="thumbnail deal-link-thumb img fancybox-video-vimeo fancybox.iframe">
                        <img class="fancy-video" src="<?=$data->getSmallThumbUrl();?>" alt="<?=$data->link;?>" />
                    </a>
                <?php else:?>
                    <a href="<?=Yii::app()->request->baseUrl."/js/uppod.swf?file=".$data->link;?>" class="fancybox-video" rel="deal_<?=$data->deal_id;?>_videos_group">
                        <img class="fancy-video" src="<?=$data->getSmallThumbUrl();?>" alt="<?=$data->link;?>" />
                    </a>
                <?php endif;?>
                <!--<a href="<?/*=$data->link;*/?>" class="thumbnail fancybox deal-link-thumb img" rel="images-group">
                    <img src="<?/*=$data->getSmallThumbUrl();*/?>" alt="<?/*=$data->link;*/?>" />
                </a>-->
            </div>
        </div>
        <div class="element-info col-lg-6">

            <div class="form-group">
                <?php echo CHtml::activeLabel($data,'alias');?>
                <?php echo CHtml::activeTextField(
                    $data,
                    'alias',
                    array(
                        'value' => $data->alias,
                        'class'=>"edit-link-alias-textfield",
                        'id' => "edit_link_alias_textfield_".$data->id,
                        'placeholder' => Yii::t("dealsModule",'Enter title')
                    )
                );?>
                <span class="help-block" style="display:none"></span>
            </div>
            <div class="form-group">
                <?php echo CHtml::activeLabel($data,'description');?>
                <?php echo CHtml::activeTextArea(
                    $data,
                    'description',
                    array(
                        'value' => $data->description,
                        'class'=>"form-control edit-link-desc-textarea",
                        'id' => "edit_link_desc_textarea_".$data->id,
                        'placeholder' => Yii::t("dealsModule",'Enter description')
                    )
                );?>
                <span class="help-block" style="display:none"></span>
                <!--<label for="edit_link_desc_textarea_<?/*=$data->id;*/?>"><?/*=Yii::t('dealsModule','Description');*/?></label>
                <textarea class="form-control edit-link-desc-textarea" data-value="<?/*=$data->description;*/?>" placeholder="<?/*=Yii::t('dealsModule','Enter comment');*/?>" id="edit_link_desc_textarea_<?/*=$data->id;*/?>" rows="3"></textarea>
                <span class="help-block" style="display:none"></span>-->
            </div>
        </div>
        <div class="col-lg-3">
            <?php echo CHtml::ajaxLink(
                $text = Yii::t('dealsModule',"Delete"),
                $url = Yii::app()->createUrl('/deals/user/dealLinks/delete', array('id' => $data->id)),
                $ajaxOptions=array (
                    'type'=>'POST',
                    'data' => array(
                        "_method" => "delete",
                        "link_id" => $data->id,
                        "deal_id" => $data->deal->id,
                    ),
                    'dataType'=>'json',
                    'success'=>'function(data){
                        if(data.status == "success"){
                            $("#deal_social_link_'.$data->id.'").remove()
                        }
                        else{
                            console.log(data.message);
                        }
					}',
                ),
                $htmlOptions=array(
                    'class' => 'delete btn btn-danger delete-link',
                    'data-toggle'=>"tooltip",
                    'data-original-title'=>Yii::t("core","Delete"),
                )
            );?>
        </div>
    </div>
</div>
