<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 02.02.2015
 * @var $model Deals
 * @var $paramsModel DealCategoriesParams
 * @var array $currenciesList
 * @var array $categories
 * @var bool $ajaxLoad
 */
$xs = "12";
$sm = "12";
$lg = "4";
$md = "9";
CHtml::$afterRequiredLabel = "<span class='required'>*</span>";
;?>
<script>
    $(document).ready(function(){
        $("#coordinate_picker_clear").click(function(){
            $("#DealCategoriesParams_longitude").val("0");
            $("#DealCategoriesParams_latitude").val("0");
            return false;
        });


        var attributes = [];
        <?php foreach($paramsModel->getCurrentCategoriesParams() as $categoriesParam):?>
            attributes.push({
                <?php if($categoriesParam->required):?>
                clientValidation: function (value, messages, attribute) {
                    if(jQuery.trim(value) == ''){
                        //messages.push("Необходимо заполнить поле \""+attribute.label+"\".");
                        messages.push("<?=Yii::t('dealsModule','Field {name} is required.', array('{name}' => $categoriesParam->label));?>");
                    }
                },
                <?php endif;?>
                enableAjaxValidation : true,
                validateOnChange : true,
                id:'DealCategoriesParams_<?=$categoriesParam->name;?>',
                inputID:'DealCategoriesParams_<?=$categoriesParam->name;?>',
                errorID:'DealCategoriesParams_<?=$categoriesParam->name;?>_em_',
                model:'Deals',
                name:'<?=$categoriesParam->name;?>',
                label: '<?=$categoriesParam->label;?>',
                status : 1,
                errorCssClass : "has-error",
                hideErrorMessage : false,
                inputContainer:"div.form-group",
                successCssClass:"has-success",
                validateOnType:true,
                validatingCssClass:"validating",
                validationDelay:200
            });
        <?php endforeach;?>
        var data = {};
        data.attributes = attributes;
        <?php if($ajaxLoad):?>
            $("#deals-form").trigger('update_deal_categories_params',data);
        <?php else:?>
            $(window).data('deal_categories_params',data);
        <?php endif;?>
    });

</script>
<?php foreach($categories as $category):?>
    <?=CHtml::hiddenField('Deals[categories][]',$category->id);?>
<?php endforeach;?>

<div class="row">
    <div class="col-xs-<?=$xs;?> col-sm-<?=$sm;?> col-md-<?=$md;?> col-lg-<?=$lg;?>">
        <?php $priceParams = array();?>
        <?php foreach($paramsModel->getCurrentCategoriesParams() as $categoriesParam):?>
            <?php $fieldType = $categoriesParam->type->name;?>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group<?=(sizeof($paramsModel->getErrors($categoriesParam->name))>0) ? ' has-error' : '';?>">
                        <?php if($fieldType == 'list'):?>
                            <?php $list = NULL;?>
                            <?php if(!is_null($categoriesParam->list_id)):?>
                                <?php $list = Lists::model()->findByPk($categoriesParam->list_id);?>
                                <?php $data = CHtml::listData(ListItems::model()->findAll(':list_id=list_id',array(':list_id' => $categoriesParam->list_id)),'value','name');?>
                            <?php elseif($categoriesParam->range):?>
                                <?php $data = DealCategoriesParams::range($categoriesParam->range);?>
                            <?php else:?>
                                <?php $data = array(0=>'List items not found');?>
                            <?php endif;?>
                            <?php echo CHtml::activeLabel($paramsModel, $categoriesParam->label, array('required'=>$categoriesParam->required,'class' => 'control-label'));?>
                            <?php $htmlOptions = array(
                                'selected' => $categoriesParam->default,
                                'empty' => Yii::t('dealsModule', 'Empty'),
                            );?>
                            <?php if(!is_null($list) && $list->type == 'multiple'):?>
                                <?php $htmlOptions['multiple'] = 'multiple';?>
                            <?php endif;?>
                            <?php echo CHtml::activeDropDownList(
                                $paramsModel,
                                $categoriesParam->name,
                                $data,
                                $htmlOptions
                            );?>
                        <?php elseif($fieldType == 'bool'):?>
                            <input type="hidden" name="DealCategoriesParams[<?=$categoriesParam->name;?>]" value="0" id="ytDealCategoriesParams_<?=$categoriesParam->name;?>">
                            <label class="checkbox">
                                <input type="checkbox" value="1" <?=($paramsModel->{$categoriesParam->name}=='1' ? 'checked=checked' : '');?> id="DealCategoriesParams_<?=$categoriesParam->name;?>" name="DealCategoriesParams[<?=$categoriesParam->name;?>]" class="form-control">
                                <span class="a-spr"></span> <?=Yii::t('dealsModule',$categoriesParam->label);?>
                            </label>
                        <?php elseif($fieldType == 'coordinates_widget'):?>
							<div class="form-group<?=(sizeof($paramsModel->getErrors('coordinates'))>0) ? ' has-error' : '';?>">
                                <label class="control-label"><?=Yii::t('adminModule', 'Coordinates');?></label>
                                <div class="coordinate-picker">
                                    <script type="text/javascript" charset="utf-8">
                                        jQuery(function($) {
                                            $('#coordinate_picker').coordinate_picker({
                                                'lat_selector':  '#DealCategoriesParams_latitude',
                                                'long_selector': '#DealCategoriesParams_longitude',
                                                'lat': <?=(sizeof($paramsModel->getErrors('latitude'))>0) ? 'null' : $paramsModel->latitude;?>,
                                                'long': <?=(sizeof($paramsModel->getErrors('longitude'))>0) ? 'null' : $paramsModel->longitude;?>
                                            });
                                        });
                                    </script>
                                    <div class="form-group<?=(sizeof($paramsModel->getErrors('latitude'))>0) ? ' has-error' : '';?>">
                                        <?=CHtml::activeHiddenField($paramsModel, 'latitude', array('value' => $paramsModel->latitude, 'class' => 'form-control'));?>
                                        <div style="<?=(sizeof($paramsModel->getErrors('latitude'))>0) ? 'display:block' : 'display:none';?>" id="DealCategoriesParams_latitude_em_" class="help-block error"><?=$paramsModel->getError('latitude');?></div>
                                    </div>
                                    <div class="form-group<?=(sizeof($paramsModel->getErrors('longitude'))>0) ? ' has-error' : '';?>">
                                        <?=CHtml::activeHiddenField($paramsModel, 'longitude', array('value' => $paramsModel->longitude, 'class' => 'form-control'));?>
                                        <div style="<?=(sizeof($paramsModel->getErrors('longitude'))>0) ? 'display:block' : 'display:none';?>" id="DealCategoriesParams_longitude_em_" class="help-block error"><?=$paramsModel->getError('longitude');?></div>
                                    </div>
                                    <a href="" id="coordinate_picker"><?=Yii::t('dealsModule','Coordinate Picker');?></a>
                                    <a href="" id="coordinate_picker_clear" class="btn btn-success"><?=Yii::t('dealsModule','Clear coordinates');?></a>
                                </div>
                            </div>
                            <?php /*if(sizeof($paramsModel->getAroundUndergrounds())>0):?>
                                <div class="row">
                                    <div class="col-sm-<?=$sm;?> col-xs-<?=$xs;?> col-lg-<?=$lg;?> col-md-<?=$md;?>">
                                        <p><strong><?=Yii::t('adminModule',"Around Underground stations");?></strong></p>
                                    </div>
                                    <div class="col-sm-<?=$sm;?> col-xs-<?=$xs;?> col-lg-<?=$lg;?> col-md-<?=$md;?>">
                                        <ul>
                                            <?php foreach($paramsModel->getAroundUndergrounds() as $underground):?>
                                                <li>
                                                    <?=CHtml::link($underground->name,$underground->getAdminUrl());?>
                                                </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif;*/?>
                        <?php elseif($fieldType == 'text'):?>
                            <?php echo CHtml::activeLabel(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'required'=>$categoriesParam->required,
                                    'class' => 'control-label'
                                )
                            );?>
                            <?php echo CHtml::activeTextArea(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'required'=>$categoriesParam->required,
                                    'class' => 'form-control',
                                    'maxlength'=>$categoriesParam->field_size,
                                    'minlength'=>$categoriesParam->field_size_min,
                                )
                            );?>
                        <?php elseif($fieldType == 'price'):?>
                            <?php $priceParams[] = $categoriesParam;?>
                        <?php elseif($fieldType == 'calendar'):?>
                            <?php echo CHtml::activeHiddenField(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'class' => 'form-control',
                                    'value' => '1',
                                )
                            );?>
                        <?php else:?>
                            <?php echo CHtml::activeLabel(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'required'=>$categoriesParam->required,
                                    'class' => 'control-label'
                                )
                            );?>
                            <?php echo CHtml::activeTextField(
                                $paramsModel,
                                $categoriesParam->name,
                                array(
                                    'class' => 'form-control',
                                )
                            );?>
                        <?php endif;?>
                        <?php if($fieldType != 'price'):?>
                            <div style="<?=(sizeof($paramsModel->getErrors($categoriesParam->name))>0) ? 'display:block' : 'display:none';?>" id="DealCategoriesParams_<?=$categoriesParam->name;?>_em_" class="help-block error"><?=$paramsModel->getError($categoriesParam->name);?></div>
                        <?php endif;?>
                    </div>
                </div>
            </div>

        <?php endforeach;?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php foreach($priceParams as $priceParam):?>
                    <div class="form-group<?=(sizeof($paramsModel->getErrors($priceParam->name))>0) ? ' has-error' : '';?>">
                        <?php echo CHtml::activeLabel($paramsModel, $priceParam->name, array('required'=>$priceParam->required,'class' => 'control-label'));?>
                        <?php echo CHtml::activeTextField($paramsModel, $priceParam->name, array('class' => 'form-control'));?>
                        <div style="<?=(sizeof($paramsModel->getErrors($priceParam->name))>0) ? 'display:block' : 'display:none';?>" id="DealCategoriesParams_<?=$priceParam->name;?>_em_" class="help-block error"><?=$paramsModel->getError($priceParam->name);?></div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>

    </div>
</div>
<?php if($paramsModel->isShowCurrenciesSelect):?>
    <div class="row">
        <div class="col-xs-<?=$xs;?> col-sm-<?=$sm;?> col-md-<?=$md;?> col-lg-<?=$lg;?>">
            <div class="form-group<?=(sizeof($model->getErrors('currency_id'))>0) ? ' has-error' : '';?>">
                <?php echo CHtml::activeLabel($model, 'currency_id', array('class' => 'control-label'));?>
                <?php echo CHtml::activeDropDownList($model, 'currency_id', $currenciesList, array('class' => 'form-control'));?>
                <div style="<?=(sizeof($model->getErrors('currency_id'))>0) ? 'display:block' : 'display:none';?>" id="Deals_currency_id_em_" class="help-block error"><?=$model->getError('currency_id');?></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-<?=$xs;?> col-sm-<?=$sm;?> col-md-<?=$md;?> col-lg-<?=$lg;?>">
            <div class="form-group<?=(sizeof($model->getErrors('negotiable'))>0) ? ' has-error' : '';?>">
                <input type="hidden" name="Deals[negotiable]" value="0" id="ytDeals_negotiable">
                <label class="checkbox">
                    <input id="Deals_negotiable" type="checkbox" name="Deals[negotiable]" value="1" <?=($model->negotiable=='1' ? 'checked=checked' : '');?>>
                    <span class="a-spr"></span> <?=Yii::t('dealsModule','Negotiable');?>
                </label>
                <div style="<?=(sizeof($model->getErrors('negotiable'))>0) ? 'display:block' : 'display:none';?>" id="Deals_negotiable_em_" class="help-block error"><?=$model->getError('negotiable');?></div>
            </div>
        </div>
    </div>
<?php endif;?>



