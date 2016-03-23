<?php
/**
 * @var $deal Deals
 */
;?>
<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="add-file photo">
    <?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
    <a href="#" class="btn btn-default b-spr"><?php echo $this->t('1#Add files|0#Choose file', $this->multiple); ?></a>
    <?php
    if ($this -> hasModel()) :
        echo CHtml::activeFileField($this -> model, $this -> attribute, $htmlOptions) . "\n";
    else :
        echo CHtml::fileField($name, $this -> value, $htmlOptions) . "\n";
    endif;
    ?>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div  class="functions cf fileupload-buttonbar">
            <!--<span class="col-info pull-right">Загруженно <span data-count="<?/*=sizeof($deal->dealsImages);*/?>" id="files_count"><?/*=sizeof($deal->dealsImages);*/?></span> файлов</span>-->
            <ul>
                <li><a href="#" id="check_all_link"><?=Yii::t('dealsModule', 'Check all');?></a></li>
                <li><a href="#" id="uncheck_all_link"><?=Yii::t('dealsModule', 'Uncheck all');?></a></li>
                <li><a href="#" id="delete_checked_link"><?=Yii::t('dealsModule', 'Delete checked');?></a></li>
            </ul>
        </div>
        <?php $counter = 1;?>
        <?php foreach($deal->dealsImages as $image):?>
            <div class="add-element template-download" id="deal_image_<?=$image->id;?>">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="image-wrap">
                            <label class="checkbox">
                                <input type="checkbox" name="delete" data-image_id="<?=$image->id;?>" value="1">
                                <span class="a-spr"></span>
                            </label>
                            <a href="<?=$image->getLargeThumbUrl();?>" class="thumbnail fancybox deal-image-thumb img" rel="images-group">
                                <img src="<?=$image->getSmallThumbUrl();?>" alt="<?=$image->name;?>" />
                            </a>
                        </div>
                    </div>
                    <div class="element-info col-lg-6">

                        <div class="form-group">
                            <?php echo CHtml::activeLabel($image,'alias');?>
                            <?php echo CHtml::activeTextField(
                                $image,
                                'alias',
                                array(
                                    'value' => $image->alias,
                                    'class'=>"edit-image-alias-textfield",
                                    'id' => "edit_image_alias_textfield_".$image->id
                                )
                            );?>
                            <span class="help-block" style="display:none"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_image_desc_textarea_<?=$image->id;?>"><?=Yii::t('dealsModule','Image description');?></label>
                            <textarea class="form-control edit-image-desc-textarea" data-value="<?=$image->description;?>" placeholder="<?=Yii::t('dealsModule','Enter comment');?>" id="edit_image_desc_textarea_<?=$image->id;?>" rows="3"></textarea>
                            <span class="help-block" style="display:none"></span>

                        </div>
                        <div class="form-group">
                            <label for="image_preview_checkbox_<?=$image->id;?>" class="checkbox image-preview-checkbox-label">
                                <input type="checkbox" <?=$image->preview == "1" ? "checked='checked' " : " ";?>id="image_preview_checkbox_<?=$image->id;?>" <?=DealsImages::getSizeOfPreviews($image->deal_id)>2 && $image->preview == "0" ? "disabled='disabled' " : " ";?>class="image-preview-checkbox">
                                <span class="a-spr"></span> <?=Yii::t('dealsModule','Preview');?>
                            </label>
                            <br>
                            <span class="help-block" style="display:none"></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="" class="delete btn btn-danger delete-image" data-image="<?=$image->id;?>"><?=Yii::t('dealsModule',"Delete");?></a>
                        <?php /*echo CHtml::ajaxLink(
                            $text = Yii::t('dealsModule',"Delete"),
                            $url = Yii::app()->createUrl('/deals/user/userDeals/deleteImage', array(
                                "_method" => "delete",
                                "image_id" => $image->id,
                            )),
                            $ajaxOptions=array (
                                'type'=>'POST',
                                'dataType'=>'json',
                                'success'=>'function(data){
                                            $("#deal_image_'.$image->id.'").remove()
                                        }',
                            ),
                            $htmlOptions=array(
                                'class' => 'btn btn-danger delete delete-image',
                                'data-toggle'=>"tooltip",
                                'data-original-title'=>Yii::t("core","Delete"),
                            )
                        );*/?>
                    </div>
                </div>
            </div>
            <?php $counter++;?>
        <?php endforeach;?>
        <!-- The loading indicator is shown during image processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <!--<div class="table table-striped">-->
            <div class="files">

            </div>
        <!--</div>-->
        <div class="add-bottom-nav">
            <!--<a href="#">Отмена</a>-->
            <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer,array('class' => 'btn btn-default back b'));?>
            <a href="<?=Yii::app()->createUrl("/deals/frontend/catalog/deal",array('id'=>$deal->id));?>" class="btn btn-default"><?=Yii::t('dealsModule',"View");?></a>
            <a href="<?=Yii::app()->createUrl("/deals/user/userDeals/video",array('id'=>$deal->id));?>" class="btn btn-success"><?=Yii::t('dealsModule',"Add video");?></a>
        </div>
    </div>
</div>









