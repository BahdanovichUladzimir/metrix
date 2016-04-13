<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 23.03.2015
 * @var $deal Deals
 * @var $userCurrency Currencies
 */
$longitude = 0;
$latitude = 0;
$isShowCalendar = false;
;?>
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="title section-title"><?=Yii::t('dealsModule','Contacts and information');?></h2>
            <table class="table table-striped table-contacts deal-params-table">
                <?php $listParams = array();?>

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
                                <td>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <?=$paramValue->param->label;?>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                            <?=($paramValue->value == 0) ? '<img src="/images/No.png" alt="No">' : '<img src="/images/Yes.png" alt="Yes">';?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'list'):?>
                            <?php $listParams[$paramValue->param->label][] = ListItems::model()->find(':value=value AND :list_id=list_id', array(':list_id'=>$paramValue->param->list_id,':value'=>$paramValue->value))->name;?>
                        <?php elseif($paramValue->param->type->name == 'url'):?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <?=$paramValue->param->label;?>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                            <?=CHtml::link($paramValue->value, DealCategoriesParams::getFormattedUrl($paramValue->value), array('rel' => 'nofollow', 'target' => "_blank"));?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'email'):?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <?=$paramValue->param->label;?>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                            <?=CHtml::link($paramValue->value,"mailto:".$paramValue->value);?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'phone'):?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <?=$paramValue->param->label;?>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                            <?php $this->widget('modules.deals.widgets.dealPhone.DealPhoneWidget', array(
                                                'deal'=>$deal,
                                                'phone' => $paramValue->value,
                                                'dealParamName' => $paramValue->param->name,
                                                'template' => 'paramsWidget'
                                            ));?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php elseif($paramValue->param->type->name == 'price'):?>
                            <?php
                            if($paramValue->value>0){
                                $priceInRUR = $paramValue->value*$deal->currency->rate;
                                $userPrice = $priceInRUR/$userCurrency->rate;
                            }
                            ;?>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <?=$paramValue->param->label;?>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                            <span><?=$paramValue->value;?> <?=(isset($deal->currency)) ? $deal->currency->key : $userCurrency->key;?></span>
                                            <?php if($paramValue->value>0 && $userCurrency->key != $deal->currency->key):?>
                                                <span><?=ceil($userPrice);?> <?=(isset($deal->currency)) ? $userCurrency->key : $userCurrency->key;?></span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php elseif($paramValue->param->type->name == 'calendar'):?>
                            <?php $isShowCalendar = true;?>
                        <?php else:?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <?=$paramValue->param->label;?>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                            <?=$paramValue->value;?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif;?>

                    <?php endif;?>
                <?php endforeach;?>
                <?php if(sizeof($listParams)>0):?>
                    <?php foreach($listParams as $k => $v):?>
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                        <?=$k;?>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
                                        <?=implode(", ", $v);?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
            </table>
        </div>
    </div>
<?php if($deal->isShowPublicCalendar):?>
    <?php $this->widget('modules.deals.widgets.dealCalendar.DealCalendarWidget', array(
        'deal'=>$deal,
    ));?>
<?php else:?>
    <?php if($deal->isShowCalendar && ($deal->user_id == Yii::app()->user->getId() || Yii::app()->getModule("user")->isModerator())):?>
        <?php $this->widget('modules.deals.widgets.dealCalendar.DealCalendarWidget', array(
            'deal'=>$deal,
        ));?>
    <?php endif;?>
<?php endif;?>
