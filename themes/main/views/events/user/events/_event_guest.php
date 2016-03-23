<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.10.2015
 * @var EventsGuests $data
 */
;?>

<tr>
    <td class="checkbox-td">
        <label class="checkbox"><input type="checkbox" class="checkb" data-guest_id="<?=$data->id;?>" ><span class="a-spr"></span></label>
    </td>
    <td class="ws-nw ta-l">
        <div class="edit-wrap">
            <a href="#" class="edit b-spr"></a>
            <ul class="dropdown-menu">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#edit_guest_link_<?=$data->id;?>").click(function(){
                            $("#editGuest_<?=$data->id;?>").modal('show');
                        });
                    });
                </script>
                <li><?=CHtml::link(
                        Yii::t('ses','Edit'),
                        Yii::app()->createUrl(
                            '/events/user/eventsGuests/update',
                            array('id'=>$data->id)
                        ),
                        array(
                            "class"=>"edit-guest-link",
                            "data-toggle" => "modal",
                            "data-target" => "#addGuest_".$data->id,
                            "id" => "edit_guest_link_".$data->id
                        )
                    );?>
                </li>
                <li>
                    <?=CHtml::ajaxLink(
                        Yii::t('ses','Delete'),
                        array(
                            '/events/user/eventsGuests/delete',
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
        <div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="editGuest" aria-hidden="true" id="editGuest_<?=$data->id;?>">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                        <span class="title h3"><?=Yii::t("eventsModule","Edit");?></span>
                    </div>
                    <div class="modal-body guest-form">
                        <?php $this->renderPartial('_event_guest_form',array("model" => $data, 'event' => Events::model()->findByPk($data->event_id)));?>
                    </div>
                </div>
            </div>
        </div>

    </td>
    <td>
        <div class="change-select">

            <select class="guest-party-select" id="guest_party_select_<?=$data->id;?>" data-guest_id="<?=$data->id;?>">
                <?php foreach(EventsGuests::getEventsGuestsParties() as $key => $value):?>
                    <option <?=($data->party_id == $key) ? 'selected="selected" ' : '';?>value="<?=$key;?>"><?=$value;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </td>
    <td class="ta-l"><?=$data->note;?>
    </td>
    <td>
        <div class="change-select">
            <select class="guest-status-select" id="guest_status_select_<?=$data->id;?>" data-guest_id="<?=$data->id;?>">
                <?php foreach(EventsGuests::getEventsGuestsStatuses() as $k => $v):?>
                    <option <?=($data->status_id == $k) ? 'selected="selected" ' : '';?>value="<?=$k;?>"><?=$v;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </td>
</tr>
