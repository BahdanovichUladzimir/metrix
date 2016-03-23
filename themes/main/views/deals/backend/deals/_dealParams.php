<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 02.02.2015
 * @var $model Deals
 * @var $paramsModel DealCategoriesParams
 * @var array $currenciesList
 */
CHtml::$afterRequiredLabel = "<span class='required'>*</span>";
;?>
<script>
    $("#deals-form").trigger('update_deal_categories_params');
</script>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php $priceParams = array();?>
        <?php foreach($paramsModel->getCurrentCategoriesParams() as $categoriesParam):?>
            <?php $fieldType = $categoriesParam->type->name;?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group<?=(sizeof($paramsModel->getErrors($categoriesParam->name))>0) ? ' has-error' : '';?>">
                        <?php if($fieldType == 'list'):?>

                            <?php if(!is_null($categoriesParam->list_id)):?>
                                <?php $data = CHtml::listData(ListItems::model()->findAll(':list_id=list_id',array(':list_id' => $categoriesParam->list_id)),'value','name');?>
                            <?php elseif($categoriesParam->range):?>
                                <?php $data = DealCategoriesParams::range($categoriesParam->range);?>
                            <?php else:?>
                                <?php $data = array(0=>'List items not found');?>
                            <?php endif;?>
                            <label class="control-label"><?=Yii::t('adminModule', $categoriesParam->label);?></label>
                            <?php echo CHtml::activeDropDownList($paramsModel, $categoriesParam->name, $data, array(
                                'selected' => $categoriesParam->default
                            ));?>
                        <?php elseif($fieldType == 'bool'):?>
                            <label class="checkbox">
                                <input type="hidden" name="DealCategoriesParams[<?=$categoriesParam->name;?>]" value="0" id="ytDealCategoriesParams_<?=$categoriesParam->name;?>">
                                <input type="checkbox" value="<?$paramsModel->{$categoriesParam->name};?>" id="DealCategoriesParams_<?=$categoriesParam->name;?>" name="DealCategoriesParams[<?=$categoriesParam->name;?>]" class="form-control">
                                <span class="a-spr"></span> <?=Yii::t('dealsModule',$categoriesParam->label);?>
                            </label>
                        <?php elseif($fieldType == 'coordinates_widget'):?>
							<div class="form-group<?=(sizeof($paramsModel->getErrors('coordinates'))>0) ? ' has-error' : '';?>">
                                <label class="control-label"><?=Yii::t('adminModule', 'Coordinates');?></label>
                                <div class="coordinate-picker">
                                    <?php
                                        $this->widget('widgets.locationpicker.LocationPicker', array(
                                            'model' => $paramsModel,
                                            'latId' => "latitude", //can be replaced using your own attribute
                                            'lonId' => "longitude", //can be replaced using your own attribute
                                            'ltnCenter' => $paramsModel->latitude,
                                            'lngCenter' => $paramsModel->longitude,
                                            'searchLabel' =>Yii::t('core',"Search"),
                                        ));
                                    ?>
                                </div>
                            </div>
                            <?php if(sizeof($paramsModel->getAroundUndergrounds())>0):?>
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
                                        <p><strong><?=Yii::t('adminModule',"Around Underground stations");?></strong></p>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
                                        <ul>
                                            <?php foreach($paramsModel->getAroundUndergrounds() as $underground):?>
                                                <li>
                                                    <?=CHtml::link($underground->name,$underground->getAdminUrl());?>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php elseif($fieldType == 'text'):?>
                            <?php echo CHtml::activeLabel(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'class' => 'control-label'
                                )
                            );?>
                            <?php echo CHtml::activeTextArea(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'class' => 'form-control',
                                    'maxlength'=>$categoriesParam->field_size,
                                    'minlength'=>$categoriesParam->field_size_min,
                                )
                            );?>
                        <?php elseif($fieldType == 'price'):?>
                            <?php $priceParams[] = $categoriesParam;?>
                        <?php else:?>
                            <?php echo CHtml::activeLabel($paramsModel, $categoriesParam->name, array('class' => 'control-label'));?>
                            <?php echo CHtml::activeTextField($paramsModel, $categoriesParam->name, array('class' => 'form-control'));?>
                        <?php endif;?>
                        <div style="display:none" id="DealCategoriesParams_<?=$categoriesParam->name;?>_em_" class="help-block error"></div>
                    </div>
                </div>
            </div>

        <?php endforeach;?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <?php foreach($priceParams as $priceParam):?>
                    <?php echo CHtml::activeLabel($paramsModel, $priceParam->name, array('class' => 'control-label'));?>
                    <?php echo CHtml::activeTextField($paramsModel, $priceParam->name, array('class' => 'form-control'));?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php if($paramsModel->isShowCurrenciesSelect):?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <?php echo CHtml::activeLabel($model, 'currency_id', array('class' => 'control-label'));?>
                <?php echo CHtml::activeDropDownList($model, 'currency_id', $currenciesList, array('class' => 'form-control'));?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

            <div class="form-group">
                <?php echo CHtml::activeLabel($model, 'negotiable', array('class' => 'control-label'));?>
                <?php echo CHtml::activeCheckBox($model, 'negotiable', array('value'=>1, 'uncheckValue'=>0));?>
            </div>
        </div>
    </div>
<?php endif;?>