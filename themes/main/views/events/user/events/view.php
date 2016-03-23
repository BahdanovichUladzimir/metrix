<?php

/**
 * @var $model Events
 */
$vodkaBottleVolume = Yii::app()->config->get("EVENTS_MODULE.VODKA_BOTTLE_VOLUME");
$wineBottleVolume = Yii::app()->config->get("EVENTS_MODULE.WINE_BOTTLE_VOLUME");
$champagneBottleVolume = Yii::app()->config->get("EVENTS_MODULE.CHAMPAGNE_BOTTLE_VOLUME");
$vodkaPrice = Yii::app()->config->get("EVENTS_MODULE.VODKA_BOTTLE_PRICE");
$winePrice = Yii::app()->config->get("EVENTS_MODULE.WINE_BOTTLE_PRICE");
$champagnePrice = Yii::app()->config->get("EVENTS_MODULE.CHAMPAGNE_BOTTLE_PRICE");
if(!Yii::app()->user->isGuest && $model->user_id == Yii::app()->user->getId()){
    $this->breadcrumbs=array(
        Yii::t('userModule','Events')=>$this->user->getPrivateUrl(),
        Yii::t('eventsModule','My events')=>$this->user->getPrivateUrl()."#events",
        $model->name,
    );
}
else{
    $this->breadcrumbs=array(
        Yii::t('userModule','Events'),
        $model->name,
    );
}
?>
<script>
    function updatePage(){
        window.location.href = "<?=Yii::app()->request->requestUri;?>";
    }
    function privateProfileRedirect(){
        window.location.href = "<?=Yii::app()->createUrl("/user/profile/privateProfile");?>";
    }
</script>
<div class="panel">
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-12">
				<div class="edit-wrap actions ta-r">
                    <?php if(Yii::app()->user->getId() == $model->user_id || Yii::app()->getModule("user")->isAdmin()):?>
                        <a href="#" class="gr-btn edit arr a"><?=Yii::t('eventsModule',"Actions");?></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=Yii::app()->createUrl("/events/user/events/update", array("id" => $model->id));?>" class="ed-opt it-1 b-spr"><?=Yii::t('core',"Edit");?></a></li>
                            <?php /**<li><a href="#" class="ed-opt it-2 b-spr"><?=Yii::t('core',"Save");?></a></li>
                            <li><a href="#" class="ed-opt it-3 b-spr"><?=Yii::t('eventsModule',"Print");?></a></li>
                            <li><a href="#" class="ed-opt it-4 b-spr"><?=Yii::t('eventsModule',"Share");?></a></li>**/;?>
                            <li>
                                <?=CHtml::ajaxLink(
                                    Yii::t('ses','Delete'),
                                    array(
                                        '/events/user/events/delete',
                                        'id'=>$model->id,
                                    ),
                                    array(
                                        'type'=>'POST',
                                        'dataType'=> 'json',
                                        'success'=>'js:function(data){
                                                                privateProfileRedirect();
                                                            }',
                                    ),
                                    array(
                                        'class' => 'ed-opt it-5 b-spr delete',
                                        'confirm'=>Yii::t('userModule','Are you sure?')
                                    )
                                );?>
                            </li>
                        </ul>
                        <!--<span class="note">Последние изменения 15 октября 2015</span>-->
                    <?php endif;?>
				</div>
				<div class="padding-wrap">
					<span class="title icon-ttl b-spr it-1"><?=$model->name;?></span>
					<table class="table table-striped g-total">
                        <?php if(!is_null($model->formattedDate)):?>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Date and time');?></td>
                                <td><?=$model->formattedDate;?>
                                    <?php if(!is_null($model->time)):?>
                                        <?=$model->time;?>
                                    <?php endif;?>
                                </td>
                            </tr>
                        <?php endif;?>

                        <tr>
                            <td class="tt-u"><?=Yii::t('eventsModule','Venue');?></td>
                            <td><?=CHtml::encode($model->venue);?></td>
                        </tr>

						<?php /*<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Status');?></td>
							<td><?=Events::getStatusesListData()[$model->status_id];?></td>
						</tr>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Public status');?></td>
							<td><?=Events::getPublicStatusesListData()[$model->public_status_id];?></td>
						</tr>*/;?>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Description');?></td>
							<td><?=CHtml::encode($model->description);?></td>
						</tr>
                        <tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Type');?></td>
							<td><?=CHtml::encode($model->type->label);?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(sizeof($model->eventsGuests)>0):?>
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edit-wrap actions ta-r">
                        <?php if(Yii::app()->user->getId() == $model->user_id || Yii::app()->getModule("user")->isAdmin()):?>
                            <a href="#" class="gr-btn edit arr a"><?=Yii::t('eventsModule',"Actions");?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Yii::app()->createUrl("/events/user/events/guestsList", array("id" => $model->id));?>" class="ed-opt it-1 b-spr"><?=Yii::t('core',"Edit");?></a></li>
                                <?php /**<li><a href="#" class="ed-opt it-2 b-spr"><?=Yii::t('core',"Save");?></a></li>
                                <li><a href="#" class="ed-opt it-3 b-spr"><?=Yii::t('eventsModule',"Print");?></a></li>
                                <li><a href="#" class="ed-opt it-4 b-spr"><?=Yii::t('eventsModule',"Share");?></a></li>**/;?>
                                <?php /*<li>
                                    <?=CHtml::ajaxLink(
                                        Yii::t('ses','Delete'),
                                        array(
                                            '/events/user/events/deleteGuestsList',
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
                                            'class' => 'ed-opt it-5 b-spr delete',
                                            'confirm'=>Yii::t('userModule','Are you sure?')
                                        )
                                    );?>
                                </li>*/;?>
                            </ul>
                        <?php endif;?>
                    </div>
                    <div class="padding-wrap">
                        <span class="title icon-ttl b-spr it-2"><?=Yii::t('eventsModule','Table of guests at the event');?></span>
                        <table class="table table-striped table-contacts g-total">
                            <tr>
                                <th colspan="2"><?=Yii::t('eventsModule','Data based on the table');?>:</th>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Total number of guests');?>:</td>
                                <td><?=sizeof($model->eventsGuests);?> <?=Yii::t('eventsModule','pers');?>.</td>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Submitted');?>:</td>
                                <td><?=$model->getSizeOfSubmittedGuests();?> <?=Yii::t('eventsModule','pers');?>.</td>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Not submitted');?>:</td>
                                <td><?=$model->getSizeOfNotSubmittedGuests();?> <?=Yii::t('eventsModule','pers');?>.</td>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Confirmed');?>:</td>
                                <td><?=$model->getSizeOfConfirmedGuests();?> <?=Yii::t('eventsModule','pers');?>.</td>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Refused');?>:</td>
                                <td><?=$model->getSizeOfRefusedGuests();?> <?=Yii::t('eventsModule','pers');?>.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php if(sizeof($model->eventsDoings)>0):?>
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edit-wrap actions ta-r">
                        <?php if(Yii::app()->user->getId() == $model->user_id || Yii::app()->getModule("user")->isAdmin()):?>
                            <a href="#" class="gr-btn edit arr a"><?=Yii::t('eventsModule',"Actions");?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Yii::app()->createUrl("/events/user/eventsDoings/index", array("event_id" => $model->id));?>" class="ed-opt it-1 b-spr"><?=Yii::t('core',"Edit");?></a></li>
                                <?php /**<li><a href="#" class="ed-opt it-2 b-spr"><?=Yii::t('core',"Save");?></a></li>
                                <li><a href="#" class="ed-opt it-3 b-spr"><?=Yii::t('eventsModule',"Print");?></a></li>
                                <li><a href="#" class="ed-opt it-4 b-spr"><?=Yii::t('eventsModule',"Share");?></a></li>**/;?>
                            </ul>
                            <!--<span class="note">Последние изменения 15 октября 2015</span>-->
                        <?php endif;?>
                    </div>
                    <div class="padding-wrap">
                        <span class="title icon-ttl b-spr it-2"><?=Yii::t('eventsModule','To-do list for the event');?></span>
                        <table class="table table-striped table-contacts g-total">
                            <tr>
                                <th colspan="2"><?=Yii::t('eventsModule','Data based on the table');?>:</th>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Total number of to-do\'s');?>:</td>
                                <td><?=sizeof($model->eventsDoings);?></td>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=Yii::t('eventsModule','Ready');?>:</td>
                                <td><?=$model->getSizeOfReadyDoings();?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php if(!is_null($model->alcohol)):?>
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edit-wrap actions ta-r">
                        <?php if(Yii::app()->user->getId() == $model->user_id || Yii::app()->getModule("user")->isAdmin()):?>
                            <a href="#" class="gr-btn edit arr a"><?=Yii::t('eventsModule',"Actions");?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Yii::app()->createUrl("/events/user/alcohol/update", array("id" => $model->alcohol->id));?>" class="ed-opt it-1 b-spr"><?=Yii::t('core',"Edit");?></a></li>
                                <?php /**<li><a href="#" class="ed-opt it-2 b-spr"><?=Yii::t('core',"Save");?></a></li>
                                <li><a href="#" class="ed-opt it-3 b-spr"><?=Yii::t('eventsModule',"Print");?></a></li>
                                <li><a href="#" class="ed-opt it-4 b-spr"><?=Yii::t('eventsModule',"Share");?></a></li>**/;?>
                                <li>
                                    <?=CHtml::ajaxLink(
                                        Yii::t('ses','Delete'),
                                        array(
                                            '/events/user/alcohol/delete',
                                            'id'=>$model->alcohol->id,
                                        ),
                                        array(
                                            'type'=>'POST',
                                            'dataType'=> 'json',
                                            'success'=>'js:function(data){
                                                                updatePage();
                                                            }',
                                        ),
                                        array(
                                            'class' => 'ed-opt it-5 b-spr delete',
                                            'confirm'=>Yii::t('userModule','Are you sure?')
                                        )
                                    );?>
                                </li>
                            </ul>
                            <!--<span class="note">Последние изменения 15 октября 2015</span>-->

                        <?php endif;?>
                    </div>
                    <div class="padding-wrap">
                        <span class="title icon-ttl b-spr it-3"><?=Yii::t('eventsModule','The calculation of the amount of alcohol and drinks to the event.');?></span>
                        <span class="title h4"><?=Yii::t('eventsModule','Initial data');?>:</span>
                        <table class="table table-striped table-contacts alc-tab g-total">
                            <tr>
                                <th colspan="2"><?=Yii::t("eventsModule","Guests count");?>:</th>
                                <th colspan="2"><?=Yii::t("eventsModule","Non-drinking guests");?>:</th>
                                <th colspan="2"><?=Yii::t("eventsModule","Extra options");?>:</th>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=$model->alcohol->getAttributeLabel("men");?></td>
                                <td><?=$model->alcohol->men;?> <?=Yii::t('eventsModule','pers');?>.</td>
                                <td class="tt-u"><?=$model->alcohol->getAttributeLabel("men");?></td>
                                <td><?=$model->alcohol->not_drinking_men;?> <?=Yii::t('eventsModule','pers');?>.</td>
                                <td class="tt-u"><?=$model->alcohol->getAttributeLabel("alcohol_consumption");?></td>
                                <td><?=Alcohol::getAlcoholConsumptionDegrees()[$model->alcohol->alcohol_consumption];?></td>
                            </tr>
                            <tr>
                                <td class="tt-u"><?=$model->alcohol->getAttributeLabel("women");?></td>
                                <td><?=$model->alcohol->women;?> <?=Yii::t('eventsModule','pers');?>.</td>
                                <td class="tt-u"><?=$model->alcohol->getAttributeLabel("women");?></td>
                                <td><?=$model->alcohol->not_drinking_women;?> <?=Yii::t('eventsModule','pers');?>.</td>
                                <td class="tt-u"><?=$model->alcohol->getAttributeLabel("season");?></td>
                                <td><?=Alcohol::getSeasons()[$model->alcohol->season];?></td>
                            </tr>
                        </table>
                        <span class="title h4"><?=Yii::t('eventsModule','Calculation results');?>:</span>
                        <table class="table table-striped table-contacts alc-tab g-total">
                            <tr>
                                <th colspan="2"><?=Yii::t('eventsModule','In liters');?></th>
                                <th colspan="2"><?=Yii::t('eventsModule','Bottled');?></th>
                            </tr>
                            <tr>
                                <td><?=Yii::t('eventsModule','Vodka and other strong drinks');?>:</td>
                                <td><?=$model->alcohol->menVodkaCount+$model->alcohol->womenVodkaCount;?> <?=Yii::t('eventsModule','l');?>.</td>
                                <td><?=Yii::t('eventsModule','Vodka and other strong drinks');?>:</td>
                                <td><?=ceil(ceil($model->alcohol->menVodkaCount+$model->alcohol->womenVodkaCount)/$vodkaBottleVolume);?> <?=Yii::t('eventsModule','bottles');?>. <?=Yii::t('eventsModule','of');?> <?=$vodkaBottleVolume;?> <?=Yii::t('eventsModule','liters');?></td>
                            </tr>
                            <tr>
                                <td><?=Yii::t('eventsModule','Wine');?>:</td>
                                <td><?=$model->alcohol->menWineCount+$model->alcohol->womenWineCount;?> <?=Yii::t('eventsModule','l');?>.</td>
                                <td><?=Yii::t('eventsModule','Wine');?>:</td>
                                <td><?=ceil(ceil($model->alcohol->menWineCount+$model->alcohol->womenWineCount)/$wineBottleVolume);?> <?=Yii::t('eventsModule','bottles');?>. <?=Yii::t('eventsModule','of');?> <?=$wineBottleVolume;?> <?=Yii::t('eventsModule','liters');?></td>
                            </tr>
                            <tr>
                                <td><?=Yii::t('eventsModule','Champagne');?>:</td>
                                <td><?=$model->alcohol->menChampagneCount+$model->alcohol->womenChampagneCount;?> <?=Yii::t('eventsModule','l');?>.</td>
                                <td><?=Yii::t('eventsModule','Champagne');?>:</td>
                                <td><?=ceil(ceil($model->alcohol->menChampagneCount+$model->alcohol->womenChampagneCount)/$champagneBottleVolume);?> <?=Yii::t('eventsModule','bottles');?>. <?=Yii::t('eventsModule','of');?> <?=$champagneBottleVolume;?> <?=Yii::t('eventsModule','liters');?></td>
                            </tr>
                        </table>
                        <span class="title h4"><?=Yii::t('eventsModule','The minimum cost of drinks');?>:</span>
                        <table class="table table-striped table-contacts alc-tab g-total">

                            <tr>
                                <td><?=Yii::t('eventsModule','Vodka and other strong drinks');?>:</td>
                                <td><?=ceil(ceil($model->alcohol->menVodkaCount+$model->alcohol->womenVodkaCount)/$vodkaBottleVolume)*$vodkaPrice;?> <?=Yii::t('eventsModule','rub');?>.</td>
                            </tr>
                            <tr>
                                <td><?=Yii::t('eventsModule','Wine');?>:</td>
                                <td><?=ceil(ceil($model->alcohol->menWineCount+$model->alcohol->womenWineCount)/$wineBottleVolume)*$winePrice;?> <?=Yii::t('eventsModule','rub');?>.</td>
                            </tr>
                            <tr>
                                <td><?=Yii::t('eventsModule','Champagne');?>:</td>
                                <td><?=ceil(ceil($model->alcohol->menChampagneCount+$model->alcohol->womenChampagneCount)/$champagneBottleVolume)*$champagnePrice;?> <?=Yii::t('eventsModule','rub');?>.</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<?php if(Yii::app()->user->getId() == $model->user_id || Yii::app()->getModule("user")->isAdmin()):?>
    <?php if(sizeof($model->eventsGuests)==0):?>
        <div class="panel">
            <div class="panel-body">
                <a href="<?=Yii::app()->createUrl('/events/user/events/guestsList', array('id' => $model->id));?>" class="add-g b-spr"><?=Yii::t('eventsModule','Table of guests at the event');?></a>
            </div>
        </div>
    <?php endif;?>
    <?php if(is_null($model->alcohol)):?>
        <div class="panel">
            <div class="panel-body">
                <a href="<?=Yii::app()->createUrl('/events/user/alcohol/create', array('event_id' => $model->id));?>" class="add-g b-spr"><?=Yii::t("eventsModule","Alcohol calculator");?></a>
            </div>
        </div>
    <?php endif;?>
    <?php if(sizeof($model->eventsDoings)==0):?>
        <div class="panel">
            <div class="panel-body">
                <a href="<?=Yii::app()->createUrl('/events/user/eventsDoings/index', array('event_id' => $model->id));?>" class="add-g b-spr"><?=Yii::t("eventsModule","To-do list for the event");?></a>
            </div>
        </div>
    <?php endif;?>
<?php endif;?>

