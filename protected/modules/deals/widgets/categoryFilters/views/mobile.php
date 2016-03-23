<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 16.06.2015
 * @var $category DealsCategories
 * @var NULL|array $currentFilters
 * @var bool $isShowSubCategories
 */
;?>
<?php $filterParams = DealsCategories::getCategoryFilterParamsWithParentCategoryFilterParamsRecursively($category);?>
<?php $sizeOfChildren = sizeof($category->getChildren());?>
<div class="filter-m">
    <a href="#" class="btn btn-default a filter-toggle"><?=Yii::t('dealsModule','Filter');?></a>
    <div class="panel filter-m-wrap">
        <div class="panel-body filter-form">
            <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                'id'=>'countries-form',
                'action' => array('/deals/frontend/catalog/index/','urlSegment' => $category->url_segment, 'city' => $this->userCityKey),
                'enableAjaxValidation'=>true,
                'method' => 'GET',
                //'type'=>'horizontal',
            )); ?>
            <?php if($isShowSubCategories):?>
                <div class="form-group">
                    <div class="sub-cat">
                        <span><?=Yii::t('dealsModule','Select sub category');?></span>
                        <ul>
                            <?php if($sizeOfChildren>0):?>
                                <?php $counter = 1;?>
                                <?php $items = $category->getChildrenDropdownListData(false, true);?>
                                <?php foreach($items as $k=>$v):?>
                                    <?php $sizeOfItems = sizeof($category->getChildrenDropdownListData(false, true));?>
                                    <?php if($counter<8):?>
                                        <li><a href="<?=DealsCategories::getPublicUrlByCatId($k,$this->userCityKey);?>"><?=$v;?></a></li>
                                    <?php else:?>
                                        <li class="hidden-subcat-menu-item"><a href="<?=DealsCategories::getPublicUrlByCatId($k,$this->userCityKey);?>"><?=$v;?></a></li>
                                    <?php endif;?>
                                    <?php $counter++;?>
                                <?php endforeach;?>
                            <?php elseif($category->hasParent()):?>
                                <?php $counter = 1;?>
                                <?php $items = $category->getParent()->getChildrenDropdownListData(false, true);?>
                                <?php foreach($items as $k=>$v):?>
                                    <?php if($counter<8):?>
                                        <li><a <?=($k==$category->id) ? 'class="act"' : '';?> href="<?=DealsCategories::getPublicUrlByCatId($k,$this->userCityKey);?>"><?=$v;?></a></li>
                                    <?php else:?>
                                        <li class="hidden-subcat-menu-item"><a <?=($k==$category->id) ? 'class="act"' : '';?> href="<?=DealsCategories::getPublicUrlByCatId($k,$this->userCityKey);?>"><?=$v;?></a></li>
                                    <?php endif;?>
                                    <?php $counter++;?>
                                <?php endforeach;?>
                            <?php else:?>
                                <?php $counter = 1;?>
                                <?php $items = CHtml::listData(DealsCategories::getRootCategories(false),'id','name');?>
                                <?php foreach($items as $k=>$v):?>
                                    <?php if($counter<8):?>
                                        <li><a <?=($k==$category->id) ? 'class="act"' : '';?> href="<?=DealsCategories::getPublicUrlByCatId($k,$this->userCityKey);?>"><?=$v;?></a></li>
                                    <?php else:?>
                                        <li class="hidden-subcat-menu-item"><a <?=($k==$category->id) ? 'class="act"' : '';?> href="<?=DealsCategories::getPublicUrlByCatId($k,$this->userCityKey);?>"><?=$v;?></a></li>
                                    <?php endif;?>
                                    <?php $counter++;?>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                        <?php if(sizeof($items)>7):?>
                            <a class="show"><?=Yii::t('dealsModule','Show all');?></a>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
            <?php if(sizeof($filterParams>0)):?>
                <?php $boolParams = array();?>
                <?php foreach($filterParams as $filterParam):?>
                    <?php if($filterParam->type->name == 'bool'):?>
                        <?php $boolParams[] = $filterParam;?>
                    <?php elseif($filterParam->type->name == 'list'):?>
                        <?php if($filterParam->list->type == 'single'):?>
                            <?php $selected = '';?>
                            <?php if(sizeof($currentFilters)>0):?>
                                <?php foreach($currentFilters as $currentFilterName => $currentFilterValues):?>
                                    <?php if($filterParam->name == $currentFilterName):?>
                                        <?php if(is_array($currentFilterValues) && (sizeof($currentFilterValues)>0)):?>
                                            <?php foreach($currentFilterValues as $currentFilterValue):?>
                                                <?php $selected = $currentFilterValue;?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif;?>
                            <div class="form-group">
                                <label><?=$filterParam->label;?></label>
                                <?=CHtml::dropDownList('Deals[filter]['.$filterParam->name.'][]',$selected,$filterParam->list->getListItemsListData(),array('empty' => Yii::t('dealsModule', 'Empty')));?>
                            </div>

                        <?php else:?>
                            <div class="form-group">
                                <div class="ch-box-wrap">
                                        <span class="pr-type">
											<span class="a"><?=$filterParam->label;?></span>
										</span>
                                    <?php foreach ($filterParam->list->getListItemsListData() as $item => $value):?>
                                        <?php $checked = false;?>
                                        <?php $class = '';?>
                                        <?php if(sizeof($currentFilters)>0):?>
                                            <?php foreach($currentFilters as $currentFilterName => $currentFilterValues):?>
                                                <?php if($filterParam->name == $currentFilterName):?>
                                                    <?php if(is_array($currentFilterValues) && (sizeof($currentFilterValues)>0)):?>
                                                        <?php foreach($currentFilterValues as $currentFilterValue):?>
                                                            <?php if($currentFilterValue == $item):?>
                                                                <?php $checked = true;?>
                                                                <?php $class = 'act';?>
                                                            <?php endif;?>
                                                        <?php endforeach;?>
                                                    <?php endif;?>
                                                <?php endif;?>
                                            <?php endforeach;?>
                                        <?php endif;?>
                                        <label class="checkbox <?=$class;?>">
                                            <?=CHtml::checkBox('Deals[filter]['.$filterParam->name.'][]',$checked, array('value' => $item));?>
                                            <span class="a-spr"></span>
                                            <?=$value;?>
                                        </label>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        <?php endif;?>
                    <?php elseif($filterParam->type->name == 'integer' || $filterParam->type->name == 'float' || $filterParam->type->name == 'price'):?>
                        <label><?=$filterParam->label;?></label>
                        <?php $minValue = '';?>
                        <?php $maxValue = '';?>
                        <?php if(sizeof($currentFilters)>0):?>
                            <?php foreach($currentFilters as $currentFilterName => $currentFilterValues):?>
                                <?php if($filterParam->name == $currentFilterName):?>
                                    <?php $minValue = isset($currentFilterValues['min']) ? $currentFilterValues['min'] : '';?>
                                    <?php $maxValue = isset($currentFilterValues['max']) ? $currentFilterValues['max'] : '';?>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                        <div class="price-choice cf">
                            <div>
                                <span><?=Yii::t("dealsModule",'From');?></span>
                                <?=CHtml::textField('Deals[filter]['.$filterParam->name.'][min]',$minValue);?>
                            </div>
                            <div>
                                <span><?=Yii::t("dealsModule",'To');?></span>
                                <?=CHtml::textField('Deals[filter]['.$filterParam->name.'][max]',$maxValue);?>
                            </div>
                        </div>
                    <?php elseif($filterParam->type->name == 'calendar'):?>
                        <div class="form-group">
                            <label><?=Yii::t('dealsModule','Select date');?></label>
                            <div>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <?php
                                    $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                                        'model' => false,
                                        'form' => $form,
                                        'id' => 'Deals_filter_calendarDate_mobile',
                                        'name' => 'Deals[filter][calendarDate]',
                                        'options' => array(
                                            'timepicker'=>false,
                                            'format'=>' d.m.Y',
                                            'lang'=>'ru',
                                            'value' => isset($currentFilters['calendarDate']) ? trim($currentFilters['calendarDate']) : '',
                                        ), //DateTimePicker options
                                        'htmlOptions' => array(
                                            'class' => 'filter-calendar-date-input form-control ct-form-control',
                                            'value' => isset($currentFilters['calendarDate']) ? trim($currentFilters['calendarDate']) : '',
                                            'placeholder' => Yii::t('dealsModule','Select date'),
                                            //'id' => $model->isNewRecord ? 'Calendar_end' : 'Calendar_end_'.$model->id,
                                        ),
                                    ));
                                    ;?>
                                </div>
                            </div>
                        </div>
                        <?php /**<div class="form-group">
                        <label><?=Yii::t('dealsModule','Select time');?></label>
                        <div>
                        <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                        <?php
                        $this->widget('ext.YiiDateTimePicker.jqueryDateTime', array(
                        'model' => false,
                        'form' => $form,
                        'name' => 'Deals[filter][calendarTime]',
                        'options' => array(
                        'datepicker'=>false,
                        'format'=>'H:i',
                        'lang'=>'ru',
                        'value' => isset($currentFilters['calendarTime']) ? trim($currentFilters['calendarTime']) : '',
                        ), //DateTimePicker options
                        'htmlOptions' => array(
                        'class' => 'filter-calendar-date-input form-control ct-form-control',
                        'value' => isset($currentFilters['calendarTime']) ? trim($currentFilters['calendarTime']) : '',
                        'placeholder' => Yii::t('dealsModule','Select time'),
                        //'id' => $model->isNewRecord ? 'Calendar_end' : 'Calendar_end_'.$model->id,
                        ),
                        ));
                        ;?>
                        </div>
                        </div>
                        </div>**/ ;?>

                    <?php endif;?>
                <?php endforeach;?>
                <?php if(sizeof($boolParams)>0):?>
                    <?php foreach($boolParams as $boolParam):?>
                        <?php $checked = false;?>
                        <?php if(sizeof($currentFilters)>0):?>
                            <?php foreach($currentFilters as $currentFilterName => $currentFilterValue):?>
                                <?php if($boolParam->name == $currentFilterName):?>
                                    <?php if($currentFilterValue = '1'):?>
                                        <?php $checked = true;?>
                                    <?php endif;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                        <div class="form-group">
                            <label class="checkbox">
                                <?=CHtml::checkBox('Deals[filter]['.$boolParam->name.'][]',$checked, array('value' => '1'));?>
                                <span class="a-spr"></span>
                                <?=$boolParam->label;?>
                            </label>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <input type="submit" class="btn btn-big btn-success" value="<?=Yii::t('dealsModule','Find');?>" />

            <?php endif;?>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>