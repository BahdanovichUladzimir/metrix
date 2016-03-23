<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.10.2015
 * @var Calendar $data
 */
;?>

<tr>
    <td class="checkbox-td">
        <label class="checkbox"><input type="checkbox" class="checkb" data-event_id="<?=$data->id;?>" ><span class="a-spr"></span></label>
    </td>
    <td class="ws-nw">
        <div class="edit-wrap">
            <a href="#" class="edit b-spr"></a>
            <ul class="dropdown-menu">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#edit_calendar_event_link_<?=$data->id;?>").click(function(){
                            $("#editCalendarEvent_<?=$data->id;?>").modal('show');
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
                            "class"=>"edit-calendar-event-link",
                            "data-toggle" => "modal",
                            "data-target" => "#addDoing_".$data->id,
                            "id" => "edit_calendar_event_link_".$data->id
                        )
                    );?>
                </li>
                <li>
                    <?=CHtml::ajaxLink(
                        Yii::t('ses','Delete'),
                        array(
                            '/deals/user/calendar/delete',
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
        <span><?=$data->title;?></span>
        <div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="editCalendarEvent" aria-hidden="true" id="editCalendarEvent_<?=$data->id;?>">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                        <span class="title h3"><?=Yii::t("dealsModule","Edit");?></span>
                    </div>
                    <div class="modal-body doing-form">
                        <?php $this->renderPartial('_form',array("model" => $data, 'deal' => Deals::model()->findByPk($data->deal_id)));?>
                    </div>
                </div>
            </div>
        </div>
    </td>
    <td>
        <span class="text-left">
            <?=$data->description;?>
        </span>
    </td>
    <td class="ta-l">
        <?=$data->formattedStart;?>
    </td>
    <td>
        <?=$data->formattedEnd;?>
    </td>
    <td class="ta-l">
        <div class="change-select">
            <select class="calendar-event-type-select" id="calendar_event_type_select_<?=$data->id;?>" data-event_id="<?=$data->id;?>">
                <?php foreach(Calendar::$types as $k => $v):?>
                    <option <?=($data->type == $k) ? 'selected="selected" ' : '';?>value="<?=$k;?>"><?=Yii::t("dealsModule",$v);?></option>
                <?php endforeach;?>
            </select>
        </div>
    </td>
</tr>
