<!-- The file upload form used as target for the file upload widget -->
<?php if ($this->showForm) echo CHtml::beginForm($this -> url, 'post', $this -> htmlOptions);?>
<div class="add-file video">
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
            <!--<span class="col-info pull-right">Загруженно <span data-count="<?/*=sizeof($deal->dealsVideos);*/?>" id="files_count"><?/*=sizeof($deal->dealsVideos);*/?></span> файлов</span>-->
            <ul>
                <li><a href="#" id="check_all_link"><?=Yii::t('dealsModule', 'Check all');?></a></li>
                <li><a href="#" id="uncheck_all_link"><?=Yii::t('dealsModule', 'Uncheck all');?></a></li>
                <li><a href="#" id="delete_checked_link"><?=Yii::t('dealsModule', 'Delete checked');?></a></li>
            </ul>
        </div>
        <?php $counter = 1;?>
        <?php foreach($deal->dealsVideos as $video):?>
            <div class="add-element template-download" id="deal_video_<?=$video->id;?>">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="image-wrap">
                            <label class="checkbox">
                                <input type="checkbox" name="delete" data-video_id="<?=$video->id;?>" value="1">
                                <span class="a-spr"></span>
                            </label>
                            <a href="<?=Yii::app()->request->baseUrl."/js/uppod.swf?file=".CHtml::encode($video->url);?>" class="thumbnail fancybox-video deal-video-thumb img" rel="videos-group" title="<?=$video->name;?>">
                                <img src="<?=$video->getSmallThumbUrl();?>" alt="<?=$video->name;?>" />
                            </a>
                        </div>
                    </div>
                    <div class="element-info col-lg-6">

                        <div class="form-group">
                            <?php echo CHtml::activeLabel($video,'alias');?>
                            <?php echo CHtml::activeTextField(
                                $video,
                                'alias',
                                array(
                                    'value' => $video->alias,
                                    'class'=>"edit-video-alias-textfield",
                                    'id' => "edit_video_alias_textfield_".$video->id
                                )
                            );?>
                            <span class="help-block" style="display:none"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_video_desc_textarea_<?=$video->id;?>"><?=Yii::t('dealsModule','video description');?></label>
                            <textarea class="form-control edit-video-desc-textarea" data-value="<?=$video->description;?>" placeholder="<?=Yii::t('dealsModule','Enter comment');?>" id="edit_video_desc_textarea_<?=$video->id;?>" rows="3"></textarea>
                            <span class="help-block" style="display:none"></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="" class="delete btn btn-danger delete-video" data-video="<?=$video->id;?>"><?=Yii::t('dealsModule',"Delete");?></a>
                        <?php /*echo CHtml::ajaxLink(
                            $text = Yii::t('dealsModule',"Delete"),
                            $url = Yii::app()->createUrl('/deals/user/userDeals/deletevideo', array(
                                "_method" => "delete",
                                "video_id" => $video->id,
                            )),
                            $ajaxOptions=array (
                                'type'=>'POST',
                                'dataType'=>'json',
                                'success'=>'function(data){
                                            $("#deal_video_'.$video->id.'").remove()
                                        }',
                            ),
                            $htmlOptions=array(
                                'class' => 'btn btn-danger delete delete-video',
                                'data-toggle'=>"tooltip",
                                'data-original-title'=>Yii::t("core","Delete"),
                            )
                        );*/?>
                    </div>
                </div>
            </div>
            <?php $counter++;?>
        <?php endforeach;?>
        <!-- The loading indicator is shown during video processing -->
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
            <a href="<?=Yii::app()->createUrl("/deals/user/userDeals/socialMediaVideo",array('id'=>$deal->id));?>" class="btn btn-success"><?=Yii::t('dealsModule',"Add Youtybe/Vimeo video");?></a>
        </div>
    </div>
</div>









