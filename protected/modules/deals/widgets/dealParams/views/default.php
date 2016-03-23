<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.03.2015
 * @var $deal Deals
 */
$longitude = 0;
$latitude = 0;
$isShowCalendar = false;
;?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="title section-title"><?=Yii::t('dealsModule','Contacts and information');?></h2>
            <table class="table table-striped table-contacts">
                <?php foreach($deal->dealsParamsValues as $paramValue):?>
                    <?php if(strlen($paramValue->value)>0):?>
                        <?php if($paramValue->param->type->name == 'coordinates_widget'):?>
                            <?php $longitude = explode(':',$paramValue->value)[0];?>
                            <?php $latitude = explode(':',$paramValue->value)[1];?>
                            <?php if($deal->getIsShowPublicMap()):?>
                                <?php $this->widget('ext.YandexMap.YandexMap', array(
                                    'id' => 'map',
                                    'width' => 100,
                                    'height' => 300,
                                    'zoom' => 15,
                                    'center' => array($latitude, $longitude),
                                    'controls' => array(
                                        'zoomControl' => true,
                                        'typeSelector' => true,
                                        'mapTools' => false,
                                        'smallZoomControl' => false,
                                        'miniMap' => false,
                                        'scaleLine' => false,
                                        'searchControl' => false,
                                        'trafficControl' => false
                                    ),
                                    'placemark' => array(
                                        array(
                                            'lat' => $latitude,
                                            'lon' => $longitude,
                                            'properties' => array(
                                                'balloonContentHeader' => $deal->name,
                                                //'balloonContent' => '<img alt="' . $deal->name . '" src="https://all4holidays.com/images/logo2.png" title="' . $deal->name . '"/>',
                                                'balloonContentFooter' => $deal->intro,
                                            ),
                                            'options' => array(
                                                'draggable' => true
                                            )
                                        )
                                    ),
                                ));?>
                            <?php endif;?>

                        <?php elseif($paramValue->param->type->name == 'bool'):?>
                            <tr>
                                <td><?=$paramValue->param->label;?></td>
                                <td><?=($paramValue->value == 0) ? '<img src="/images/No.png" alt="No">' : '<img src="/images/Yes.png" alt="Yes">';?></td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'list'):?>
                            <tr>
                                <td><?=$paramValue->param->label;?></td>
                                <td><?=ListItems::model()->find(':value=value AND :list_id=list_id', array(':list_id'=>$paramValue->param->list_id,':value'=>$paramValue->value))->name;?></td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'url'):?>
                            <tr>
                                <td><?=$paramValue->param->label;?></td>
                                <td><?=CHtml::link($paramValue->value, DealCategoriesParams::getFormattedUrl($paramValue->value), array('rel' => 'nofollow', 'target' => "_blank"));?></td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'email'):?>
                            <tr>
                                <td><?=$paramValue->param->label;?></td>
                                <td><?=CHtml::link($paramValue->value,"mailto:".$paramValue->value);?></td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'phone'):?>
                            <tr>
                                <td><?=$paramValue->param->label;?></td>
                                <td>
                                    <?php $this->widget('modules.deals.widgets.dealPhone.DealPhoneWidget', array(
                                        'deal'=>$deal,
                                        'phone' => $paramValue->value,
                                        'dealParamName' => $paramValue->param->name,
                                        'template' => 'paramsWidget'
                                    ));?>
                                </td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'price'):?>

                            <?php $this->widget('modules.deals.widgets.dealPrice.DealPriceWidget', array(
                                'deal'=>$deal,
                                'template' => 'dealParamsWidget'
                            ));?>

                        <?php elseif($paramValue->param->type->name == 'calendar'):?>

                            <?php $isShowCalendar = true;?>

                        <?php else:?>
                            <tr>
                                <td><?=$paramValue->param->label;?></td>
                                <td><?=$paramValue->value;?></td>
                            </tr>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach;?>
            </table>
        </div>
    </div>
<?php if($deal->isShowPublicCalendar):?>
    <?php $this->widget('modules.deals.widgets.dealCalendar.DealCalendarWidget', array(
        'deal'=>$deal,
    ));?>
<?php else:?>
    <?php if($deal->isShowCalendar && ($deal->user_id == Yii::app()->user->getId() || Yii::app()->getModule("user")->isAdmin())):?>
        <?php $this->widget('modules.deals.widgets.dealCalendar.DealCalendarWidget', array(
            'deal'=>$deal,
        ));?>
    <?php endif;?>
<?php endif;?>
