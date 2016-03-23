<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.10.2015
 * @var EventsDoings $data
 */
;?>

<tr>
    <td class="checkbox-td">
        <label class="checkbox"><input type="checkbox" class="checkb" data-doing_id="<?=$data->id;?>" ><span class="a-spr"></span></label>
    </td>
    <td class="ws-nw ta-l">
        <div class="edit-wrap">
            <a href="#" class="edit b-spr"></a>
            <ul class="dropdown-menu">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#edit_doing_link_<?=$data->id;?>").click(function(){
                            $("#editDoing_<?=$data->id;?>").modal('show');
                        });
                    });
                </script>
                <li><?=CHtml::link(
                        Yii::t('ses','Edit'),
                        Yii::app()->createUrl(
                            '/events/user/eventsDoings/update',
                            array('id'=>$data->id)
                        ),
                        array(
                            "class"=>"edit-doing-link",
                            "data-toggle" => "modal",
                            "data-target" => "#addDoing_".$data->id,
                            "id" => "edit_doing_link_".$data->id
                        )
                    );?>
                </li>
                <li>
                    <?=CHtml::ajaxLink(
                        Yii::t('ses','Delete'),
                        array(
                            '/events/user/eventsDoings/delete',
                            'id'=>$data->id,
                        ),
                        array(
                            'type'=>'POST',
                            'dataType'=> 'json',
                            'success'=>'js:function(data){
                                                        updatePage();
                                                    }',
                        ),
                        array(
                            'class' => 'delete',
                            'confirm'=>Yii::t('userModule','Are you sure?')
                        )
                    );?>
                </li>
            </ul>
        </div>
        <span><?=$data->name;?></span>
        <div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="editDoing" aria-hidden="true" id="editDoing_<?=$data->id;?>">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                        <span class="title h3"><?=Yii::t("eventsModule","Edit");?></span>
                    </div>
                    <div class="modal-body doing-form">
                        <?php $this->renderPartial('_event_doing_form',array("model" => $data, 'event' => Events::model()->findByPk($data->event_id)));?>
                    </div>
                </div>
            </div>
        </div>

    </td>
    <td>
        <div class="change-select">

            <select class="doing-category-select" id="doing_category_select_<?=$data->id;?>" data-doing_id="<?=$data->id;?>">
                <?php foreach(CHtml::listData(EventsDoingsCategories::model()->findAll(),"id","name") as $key => $value):?>
                    <option <?=($data->category_id == $key) ? 'selected="selected" ' : '';?>value="<?=$key;?>"><?=$value;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </td>
    <td class="ta-l">
        <?=$data->comment;?>
    </td>
    <td class="ta-l">
        <?=$data->price;?>
    </td>
    <td class="ta-l">
        <div class="change-select">
            <select class="doing-status-select" id="doing_status_select_<?=$data->id;?>" data-doing_id="<?=$data->id;?>">
                <?php foreach(EventsDoings::$statuses as $k => $v):?>
                    <option <?=($data->status == $k) ? 'selected="selected" ' : '';?>value="<?=$k;?>"><?=$v;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </td>
</tr>
