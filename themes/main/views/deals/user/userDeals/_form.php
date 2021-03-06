<?php
/**
 * @var $this DealsController
 * @var $model Deals
 * @var $paramsModel DealCategoriesParams
 * @var $imagesModel DealsImages
 * @var array $categoriesList All categories list
 * @var array $statusesList User statuses list
 * @var array $approveList Admin approves list
 * @var array $archiveList Admin archives list
 * @var array $usersList Admin users list
 * @var array $citiesList Admin cities list
 * @var array $currenciesList Admin currencies list
 * @var array $priorityList Priority values list
 * @var $form TbActiveForm
 * @var $categoriesParam DealsParams
 * @var array $postData
 * @var DealsCategories $currentCategory
*/
$xs = "12";
$sm = "12";
$lg = "4";
$md = "9";
;?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/coordinate-picker/coordinate_picker/jquery.coordinate_picker.js');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/coordinate-picker/coordinate_picker/styles/smodal/shadow.css');?>

<!--<script type="text/javascript" charset="utf-8">
    jQuery(function($) {
        $('#coordinate_picker').coordinate_picker({
            'lat_selector':  '#DealCategoriesParams_latitude',
            'long_selector': '#DealCategoriesParams_longitude',
        });
    });
</script>-->
<?php Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?sensor=true&language=ru");?>
<?php if( Yii::app()->user->hasFlash('backendDealsSuccess')):?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('backendDealsSuccess'); ?>
    </div>
<?php endif; ?>

<?php if( Yii::app()->user->hasFlash('backendDealsError')):?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo Yii::app()->user->getFlash('backendDealsError'); ?>
    </div>
<?php endif; ?>
<div class="cf">
    <ul class="nav nav-tabs navbar-left">
        <li class="active"><a href="#add-info" data-toggle="tab">1. <?=Yii::t('dealsModule','Information');?></a></li>
        <?php if($model->isNewRecord):?>
            <li><a href="#">2. <?=Yii::t('dealsModule','Photo');?></a></li>
            <li><a href="#">3. <?=Yii::t('dealsModule','Video');?></a></li>
            <li><a href="#">4. <?=Yii::t('dealsModule','Youtube/Vimeo video');?></a></li>
        <?php else:?>
            <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/photo', array('id'=>$model->id));?>">2. <?=Yii::t('dealsModule','Photo');?></a></li>
            <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/video', array('id'=>$model->id));?>">3. <?=Yii::t('dealsModule','Video');?></a></li>
            <li><a href="<?=Yii::app()->createUrl('/deals/user/userDeals/socialMediaVideo', array('id'=> $model->id));?>">4. <?=Yii::t('dealsModule','Youtube/Vimeo video');?></a></li>
        <?php endif;?>
    </ul>
</div>
<div class="tab-content">
    <div id="add-info" class="tab-pane active">
        <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
            'id'=>'deals-form',
            'enableAjaxValidation'=>true,
            'enableClientValidation'=>true,
            'type' => 'vertical',
            'clientOptions'=>array(
                "validateOnSubmit"=> false,
                'validateOnChange' => true,
                'validateOnType' => true,
            )
        )); ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6 col-md-<?=$md;?> col-sm-<?=$sm;?> col-xs-<?=$xs;?>">
                        <p class="help-block"><?=Yii::t("core","Fields with <span class='required'>*</span> are required.");?></p>
                        <?php echo $form->textFieldGroup(
                            $model,
                            'name',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=>array(
                                        //'class'=>'col-xs-5 col-sm-5',
                                        'maxlength'=>255,
                                        'placeholder' => Yii::t('dealsModule',"For example: Toastmaster"),
                                    )
                                ),
                            )
                        ); ?>
                        <?php echo $form->textAreaGroup(
                            $model,
                            'intro',
                            array(
                                'widgetOptions'=>array(
                                    'htmlOptions'=>array(
                                        'rows'=>6,
                                        'cols'=>50,
                                        'class'=>'',
                                        'placeholder' => Yii::t('dealsModule',"For example: Toastmaster in Moscow. I conduct weddings, holidays, corporate."),
                                    )
                                ),
                            )
                        ); ?>
                        <?php echo $form->ckEditorGroup(
                            $model,
                            'description',
                            array(
                                'widgetOptions' => array(
                                    'editorOptions' => array(
                                        'fullpage' => 'js:true',
                                        'width' => '100%',
                                        'resize_maxWidth' => '100%',
                                        'resize_minWidth' => '320',
                                        //'allowedContent' => 'p b i strong em; a[!href]',
                                        'disallowedContent' => '*[style]',
                                        'plugins' => 'basicstyles,toolbar,enterkey,entities,floatingspace,wysiwygarea,indentlist,link,list,dialog,dialogui,button,indent,fakeobjects',
                                    )
                                )
                            )
                        ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-<?=$lg;?> col-md-<?=$md;?> col-sm-<?=$sm;?> col-xs-<?=$xs;?>">
                        <div class="select-wrap">
                            <?php if($model->city_id === NULL):?>
                                <?php $model->city_id = (is_null(Yii::app()->request->cookies['cityId'])) ? (int)Yii::app()->config->get("ADMIN_MODULE.DEFAULT_CITY_ID") : (int)Yii::app()->request->cookies['cityId']->value;?>
                            <?php endif;?>
                            <?php echo $form->dropDownListGroup(
                                $model,
                                'city_id',
                                array(
                                    'widgetOptions' => array(
                                        'data' => $citiesList,
                                        'htmlOptions' => array(
                                            'multiple' => false,
                                            'empty' => Yii::t('dealsModule', 'Empty'),
                                        )
                                    )
                                )
                            ); ?>
                        </div>
                        <div class="categories-select-container">
                            <?php $this->widget('modules.deals.widgets.categorySelect.CategorySelectWidget', array(
                                'model'=>$model,
                            ));?>
                        </div>
                    </div>
                </div>
                <div id="deal_categories_params">
                    <?php if(isset($model->categories)):?>
                        <?php $this->renderPartial(
                            '_dealParams',
                            array(
                                'ajaxLoad' => false,
                                'model'=>$model,
                                'categories' => $model->categories,
                                'paramsModel'=>$paramsModel,
                                'currenciesList' => Currencies::getCurrenciesListData(),
                            ),
                            false,
                            false
                        );?>
                    <?php endif;?>

                </div>
                <div class="add-bottom-nav">
                    <?php echo CHtml::link(Yii::t('core', 'Back'),Yii::app()->request->urlReferrer);?>
                    <?php $this->widget('booster.widgets.TbButton', array(
                        'buttonType'=>'submit',
                        'context'=>'success',
                        'label'=>Yii::t('core','Continue'),
                        'htmlOptions' => array(
                            'class' => 'go a-spr'
                        )
                    )); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php $script = '       

    var form = $("#deals-form");
    var init_settings = form.data("settings");
    var init_attributes = init_settings.attributes;
    
    var deal_categories_params_data = $(window).data("deal_categories_params");
    if(deal_categories_params_data !== undefined){
        var init_params_attributes = deal_categories_params_data.attributes;
        var tmp = [];
        var result_attributes = tmp.concat(init_attributes, init_params_attributes);
        
        init_settings.attributes = result_attributes;

        $("#deals-form").yiiactiveform(init_settings);
    }
    
    $("#deals-form").on("update_deal_categories_params", function(event,data){
        var new_cat_attributes = data.attributes;
        var tmp = [];
        var result_attributes = tmp.concat(init_attributes, new_cat_attributes);
                       
        init_settings.attributes = result_attributes;
        
        $("#deals-form").yiiactiveform(init_settings);
     });
';?>
<?php Yii::app()->clientScript->registerScript("update-deals_form_params_data",$script, CClientScript::POS_LOAD);?>
