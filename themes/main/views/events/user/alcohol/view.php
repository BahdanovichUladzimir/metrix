<?php

/**
 * @var $model Alcohol
 * @var int $menVodkaCount
 * @var int $menWineCount
 * @var int $menChampagneCount
 * @var int $womenVodkaCount
 * @var int $womenWineCount
 * @var int $womenChampagneCount
 */
$vodkaBottleVolume = Yii::app()->config->get("EVENTS_MODULE.VODKA_BOTTLE_VOLUME");
$wineBottleVolume = Yii::app()->config->get("EVENTS_MODULE.WINE_BOTTLE_VOLUME");
$champagneBottleVolume = Yii::app()->config->get("EVENTS_MODULE.CHAMPAGNE_BOTTLE_VOLUME");
$vodkaPrice = Yii::app()->config->get("EVENTS_MODULE.VODKA_BOTTLE_PRICE");
$winePrice = Yii::app()->config->get("EVENTS_MODULE.WINE_BOTTLE_PRICE");
$champagnePrice = Yii::app()->config->get("EVENTS_MODULE.CHAMPAGNE_BOTTLE_PRICE");
$this->breadcrumbs=array(
	Yii::t('eventsModule','My events')=>array('/user/profile/privateProfile#events'),
	$model->event->name=>Yii::app()->createUrl('/events/user/events/view', array("id" => $model->event_id)),
	Yii::t('eventsModule','Alcohol calculation'),
);?>

<div class="panel">
	<div class="panel-body">
		<!--<div class="ta-r options ta-r">
			<a href="#" class="btn btn-primary b-spr print"><?/*=Yii::t('eventsModule','Print');*/?></a>
		</div>-->
		<div class="padding-wrap">
            <span class="title icon-ttl b-spr it-2"><?=Yii::t('eventsModule','The calculation of the amount of alcohol and drinks to the event');?></span>
			<div class="row">
				<div class="col-lg-12">
					<span class="title h4"><?=Yii::t('eventsModule','Initial data');?>:</span>
					<table class="table table-striped table-contacts alc-tab g-total">
						<tr>
							<th colspan="2"><?=Yii::t("eventsModule","Guests count");?>:</th>
							<th colspan="2"><?=Yii::t("eventsModule","Non-drinking guests");?>:</th>
							<th colspan="2"><?=Yii::t("eventsModule","Extra options");?>:</th>
						</tr>
						<tr>
							<td class="tt-u"><?=$model->getAttributeLabel("men");?></td>
							<td><?=$model->men;?> <?=Yii::t('eventsModule','pers');?>.</td>
							<td class="tt-u"><?=$model->getAttributeLabel("not_drinking_men");?></td>
							<td><?=$model->not_drinking_men;?> <?=Yii::t('eventsModule','pers');?>.</td>
							<td class="tt-u"><?=$model->getAttributeLabel("alcohol_consumption");?></td>
							<td><?=Alcohol::getAlcoholConsumptionDegrees()[$model->alcohol_consumption];?></td>
						</tr>
						<tr>
							<td class="tt-u"><?=$model->getAttributeLabel("women");?></td>
							<td><?=$model->women;?> <?=Yii::t('eventsModule','pers');?>.</td>
							<td class="tt-u"><?=$model->getAttributeLabel("not_drinking_women");?></td>
							<td><?=$model->not_drinking_women;?> <?=Yii::t('eventsModule','pers');?>.</td>
							<td class="tt-u"><?=$model->getAttributeLabel("season");?></td>
							<td><?=Alcohol::getSeasons()[$model->season];?></td>
						</tr>
						<tr>
							<td class="tt-u"><?=$model->getAttributeLabel("children");?></td>
							<td><?=$model->children;?> <?=Yii::t('eventsModule','pers');?>.</td>
							<td class="tt-u"></td>
							<td></td>
							<td class="tt-u"><?=$model->getAttributeLabel("event_duration");?></td>
							<td><?=$model->event_duration;?></td>
						</tr>
					</table>
					<span class="title h4"><?=Yii::t('eventsModule','Calculation results');?>:</span>
					<table class="table table-striped table-contacts alc-tab g-total">
						<tr>
							<th colspan="2"><?=Yii::t('eventsModule','In liters');?></th>
							<th colspan="2"><?=Yii::t('eventsModule','Bottled');?></th>
						</tr>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Vodka and other strong drinks');?>:</td>
							<td><?=$menVodkaCount+$womenVodkaCount;?> <?=Yii::t('eventsModule','l');?>.</td>
							<td class="tt-u"><?=Yii::t('eventsModule','Vodka and other strong drinks');?>:</td>
							<td><?=ceil(ceil($menVodkaCount+$womenVodkaCount)/$vodkaBottleVolume);?> <?=Yii::t('eventsModule','bottles');?>. <?=Yii::t('eventsModule','of');?> <?=$vodkaBottleVolume;?> <?=Yii::t('eventsModule','liters');?></td>
						</tr>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Wine');?>:</td>
							<td><?=$menWineCount+$womenWineCount;?> <?=Yii::t('eventsModule','l');?>.</td>
							<td class="tt-u"><?=Yii::t('eventsModule','Wine');?>:</td>
							<td><?=ceil(ceil($menWineCount+$womenWineCount)/$wineBottleVolume);?> <?=Yii::t('eventsModule','bottles');?>. <?=Yii::t('eventsModule','of');?> <?=$wineBottleVolume;?> <?=Yii::t('eventsModule','liters');?></td>
						</tr>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Champagne');?>:</td>
							<td><?=$menChampagneCount+$womenChampagneCount;?> <?=Yii::t('eventsModule','l');?>.</td>
							<td class="tt-u"><?=Yii::t('eventsModule','Champagne');?>:</td>
							<td><?=ceil(ceil($menChampagneCount+$womenChampagneCount)/$champagneBottleVolume);?> <?=Yii::t('eventsModule','bottles');?>. <?=Yii::t('eventsModule','of');?> <?=$champagneBottleVolume;?> <?=Yii::t('eventsModule','liters');?></td>
						</tr>
					</table>
					<span class="title h4"><?=Yii::t('eventsModule','The minimum cost of drinks');?>:</span>
					<table class="table table-striped table-contacts alc-tab g-total">

						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Vodka and other strong drinks');?>:</td>
							<td><?=ceil(ceil($menVodkaCount+$womenVodkaCount)/$vodkaBottleVolume)*$vodkaPrice;?> <?=Yii::t('eventsModule','rub');?>.</td>
						</tr>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Wine');?>:</td>
							<td><?=ceil(ceil($menWineCount+$womenWineCount)/$wineBottleVolume)*$winePrice;?> <?=Yii::t('eventsModule','rub');?>.</td>
						</tr>
						<tr>
							<td class="tt-u"><?=Yii::t('eventsModule','Champagne');?>:</td>
							<td><?=ceil(ceil($menChampagneCount+$womenChampagneCount)/$champagneBottleVolume)*$champagnePrice;?> <?=Yii::t('eventsModule','rub');?>.</td>
						</tr>
					</table>
					<?php echo CHtml::link(
							Yii::t('eventsModule', 'Repeat calculation'),
							array(
									'update', 'id'=>$model->id
							),
							array(
									'class'=>'recalc',
							)
					);?>
					<div class="terms">
						<span>Условия использования сервиса:</span>
						<p>Все расчеты выполняются на основе усредненных норм потребления напитков, имеющихся в открытом доступе. Сервис предназначен только для ориентировочной оценки требуемого количества напитков для проведения свадебного банкета или другого мероприятия. Каждая конкретная ситуация индивидуальна. Поэтому в каждом частном случае состав и точное количество необходимых напитков свое и зависит от состава и предпочтения гостей. Учитывайте это. </p>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>