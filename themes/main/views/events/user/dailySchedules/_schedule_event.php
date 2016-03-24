<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 06.10.2015
 * @var DailySchedulesEvents $model
 * @var DailySchedules $scheduleModel
 */
;?>

<tr>
    <td class="checkbox-td">
        <label class="checkbox"><input type="checkbox" class="checkb" data-doing_id="<?=$model->id;?>" ><span class="a-spr"></span></label>
    </td>
    <td class="ws-nw ta-l">
        <div class="edit-wrap">
            <a href="#" class="edit b-spr"></a>
            <ul class="dropdown-menu">
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#edit_doing_link_<?=$model->id;?>").click(function(){
                            $("#editDoing_<?=$model->id;?>").modal('show');
                        });
                    });
                </script>
                <li>
                    <?=CHtml::link(
                        Yii::t('ses','Edit'),
                        Yii::app()->createUrl(
                            '/events/user/dailySchedulesEvents/update',
                            array('id'=>$model->id)
                        ),
                        array(
                            "class"=>"edit-doing-link",
                            "data-toggle" => "modal",
                            "data-target" => "#addDoing_".$model->id,
                            "id" => "edit_doing_link_".$model->id
                        )
                    );?>
                </li>
                <li>
                    <?=CHtml::ajaxLink(
                        Yii::t('ses','Delete'),
                        array(
                            '/events/user/dailySchedulesEvents/delete',
                            'id'=>$model->id,
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
        <span><?=$model->name;?></span>
        <div class="modal fade bs-example-modal-sm" role="dialog" aria-labelledby="editDoing" aria-hidden="true" id="editDoing_<?=$model->id;?>">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                        <span class="title h3"><?=Yii::t("eventsModule","Edit");?></span>
                    </div>
                    <div class="modal-body doing-form">
                        <?php $this->renderPartial('_event_form',array("model" => $model,'scheduleModel' => $scheduleModel));?>
                    </div>
                </div>
            </div>
        </div>

    </td>
    <td class="ta-l">
        <?=$model->description;?>
    </td>
    <td class="ta-l">
        <?=$model->publicStart;?>
    </td>
    <td class="ta-l">
        <?=$model->publicEnd;?>
    </td>
</tr>
