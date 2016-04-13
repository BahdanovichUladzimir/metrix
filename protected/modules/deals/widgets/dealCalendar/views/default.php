<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 28.11.2015
 * @var Deals $deal
 * @var int $widgetId
 */
;?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/css/calendar.min.css');?>
<?php /*Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/components/bootstrap3/css/bootstrap.min.css');*/?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/components/bootstrap3/css/bootstrap-theme.min.css');?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/components/underscore/underscore-min.js', CClientScript::POS_HEAD);?>
<?php /*Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/components/bootstrap3/js/bootstrap.min.js', CClientScript::POS_HEAD);*/?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/components/jstimezonedetect/jstz.min.js', CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/js/language/ru-RU.js', CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/js/calendar.min.js', CClientScript::POS_HEAD);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/js/language/ru-RU.js', CClientScript::POS_HEAD);?>

<?php /*Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/bootstrap-calendar/js/app.js', CClientScript::POS_HEAD);*/?>



<div class="panel panel-default" id="deal_calendar_widget_<?=$widgetId;?>">
    <div class="panel-body cf">
        <div class="service-info inner">
            <?php if((!is_null(Yii::app()->user->getId()) && Yii::app()->user->getId() == $deal->user_id) || Yii::app()->getModule('user')->isModerator()):?>
                <div class="dropdown pull-right">
                    <a href="#" class="gr-btn dropdown-toggle" data-toggle="dropdown"><?=Yii::t('core','Edit');?></a>
                    <ul class="dropdown-menu edit-func">
                        <li><?=CHtml::link(Yii::t('ses','Edit'),Yii::app()->createUrl('/deals/user/calendar/index', array('deal_id'=>$deal->id)),array('class' => 'change b-spr'));?></li>
                        <!--<li>
                                <?/*=CHtml::ajaxLink(
                                    Yii::t('ses','Update'),
                                    array(
                                        '/deals/user/userDeals/setDealUpdatedDate',
                                        'deal_id'=>$deal->id,
                                    ),
                                    array(
                                        'type'=>'POST',
                                        'success'=>'js:function(data){
                                                                console.log(data);
                                                            }'
                                    ),
                                    array(
                                        'class' => 'up b-spr'
                                    )
                                );*/?>
                            </li>-->
                        <!--<li id="set_deal_status_hide_item"<?/*=($deal->status_id == 2) ? ' style="display:none" ' : '';*/?>>
                            <?/*=CHtml::ajaxLink(
                                Yii::t('dealsModule','Hide'),
                                array(
                                    '/deals/user/userDeals/setDealStatus',
                                ),
                                array(
                                    'type'=>'POST',
                                    'data' => array(
                                        'deal_id'=>$deal->id,
                                        'status_id'=>2,
                                    ),
                                    'dataType' => 'json',
                                    'success'=>'js:function(data){
                                                                console.log(data);
                                                                if(data.status === "success" && data.dealStatus.name === "not_published"){
                                                                    $("#set_deal_status_hide_item").hide();
                                                                    $("#set_deal_status_publish_item").show();
                                                                }
                                                            }'
                                ),
                                array(
                                    'class' => 'hdn b-spr',
                                    'id' => 'set_deal_status_hide'
                                )
                            );*/?>
                        </li>-->
                        <!--<li id="set_deal_status_publish_item"<?/*=($deal->status_id == 1) ? ' style="display:none" ' : '';*/?>>
                            <?/*=CHtml::ajaxLink(
                                Yii::t('dealsModule','Publish'),
                                array(
                                    '/deals/user/userDeals/setDealStatus',
                                ),
                                array(
                                    'type'=>'POST',
                                    'data' => array(
                                        'deal_id'=>$deal->id,
                                        'status_id'=>1,
                                    ),
                                    'dataType' => 'json',
                                    'success'=>'js:function(data){
                                                            console.log(data);
                                                            if(data.status === "success" && data.dealStatus.name === "published"){
                                                                $("#set_deal_status_publish_item").hide();
                                                                $("#set_deal_status_hide_item").show();
                                                            }

                                                        }'
                                ),
                                array(
                                    'class' => 'up b-spr',
                                    'id' => 'set_deal_status_publish'
                                )
                            );*/?>
                        </li>-->
                        <!--<li>
                            <?/*=CHtml::ajaxLink(
                                Yii::t('ses','Delete'),
                                array(
                                    '/deals/user/userDeals/delete',
                                    'id'=>$deal->id,
                                ),
                                array(
                                    'type'=>'POST',
                                    'dataType'=> 'json',
                                    'success'=>'js:function(data){
                                                                if(data.status == "success"){
                                                                    window.location.href = "'.Yii::app()->createUrl("/user/profile/privateProfile/").'"
                                                                }
                                                            }',
                                ),
                                array(
                                    'class' => 'del b-spr',
                                    'confirm'=>Yii::t('dealsModule','Are you sure?')
                                )
                            );*/?>
                        </li>-->
                    </ul>
                </div>
            <?php endif;?>
            <h1 class="title section-title h1"><?=Yii::t("dealsModule","Calendar");?></h1>
            <div class="page-header">

                <div class="pull-right form-inline">
                    <div class="btn-group">
                        <button class="btn btn-primary" data-calendar-nav="prev"><< <?=Yii::t('dealsModule','Prev');?></button>
                        <button class="btn btn-default" data-calendar-nav="today"><?=Yii::t('dealsModule','Today');?></button>
                        <button class="btn btn-primary" data-calendar-nav="next"><?=Yii::t('dealsModule','Next');?> >></button>
                    </div>
                    <?php /*<div class="btn-group">
                        <button class="btn btn-warning" data-calendar-view="year"><?=Yii::t('dealsModule','Year');?></button>
                        <button class="btn btn-warning active" data-calendar-view="month"><?=Yii::t('dealsModule','Month');?></button>
                        <button class="btn btn-warning" data-calendar-view="week"><?=Yii::t('dealsModule','Week');?></button>
                        <button class="btn btn-warning" data-calendar-view="day"><?=Yii::t('dealsModule','Day');?></button>
                    </div>*/;?>
                </div>

                <h3></h3>
                <!--<small>To see example with events navigate to march 2013</small>-->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="calendar"></div>

                </div>
            </div>
            <div class="clearfix"></div>

            <div class="modal fade" id="calendar_events_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Event</h3>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-10 col-xs-10 col-sm-10 col-lg-10">

                            </div>
                            <div class="col-md-2 col-xs-2 col-sm-2 col-lg-2">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('core','Close');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                (function($) {

                    "use strict";

                    var options = {
                        tmpl_path: "/js/bootstrap-calendar/tmpls/",
                        //day: '2015-11-27',
                        day: '<?=date("Y-m-d",time());?>',
                        language: 'ru-RU',
                        events_source: '<?=Yii::app()->createUrl("/deals/frontend/catalog/calendar", array("deal_id" => $deal->id));?>',
                        view: 'month',
                        tmpl_cache: false,
                        onAfterEventsLoad: function(events) {
                            if(!events) {
                                return;
                            }
                            var list = $('#eventlist');
                            list.html('');

                            $.each(events, function(key, val) {
                                $(document.createElement('li'))
                                    .html('<a href="' + val.url + '">' + val.title + '</a>')
                                    .appendTo(list);
                            });
                        },
                        onAfterViewLoad: function(view) {
                            $('.page-header h3').text(this.getTitle());
                            $('.btn-group button').removeClass('active');
                            $('button[data-calendar-view="' + view + '"]').addClass('active');
                        },
                        classes: {
                            months: {
                                general: 'label'
                            }
                        },
                        modal : "#calendar_events_modal",
                        modal_type : "template",
                        modal_title : function (e) { return e.title },
                        modal_description : function (e) { return e.description }
                    };

                    var calendar = $('#calendar').calendar(options);

                    $('.btn-group button[data-calendar-nav]').each(function() {
                        var $this = $(this);
                        $this.click(function() {
                            calendar.navigate($this.data('calendar-nav'));
                        });
                    });

                    $('.btn-group button[data-calendar-view]').each(function() {
                        var $this = $(this);
                        $this.click(function() {
                            calendar.view($this.data('calendar-view'));
                        });
                    });

                    $('#first_day').change(function(){
                        var value = $(this).val();
                        value = value.length ? parseInt(value) : null;
                        calendar.setOptions({first_day: value});
                        calendar.view();
                    });

                    $('#language').change(function(){
                        calendar.setLanguage($(this).val());
                        calendar.view();
                    });

                    $('#events-in-modal').change(function(){
                        var val = $(this).is(':checked') ? $(this).val() : null;
                        calendar.setOptions({modal: val});
                    });
                    $('#format-12-hours').change(function(){
                        var val = $(this).is(':checked') ? true : false;
                        calendar.setOptions({format12: val});
                        calendar.view();
                    });
                    $('#show_wbn').change(function(){
                        var val = $(this).is(':checked') ? true : false;
                        calendar.setOptions({display_week_numbers: val});
                        calendar.view();
                    });
                    $('#show_wb').change(function(){
                        var val = $(this).is(':checked') ? true : false;
                        calendar.setOptions({weekbox: val});
                        calendar.view();
                    });
                    $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
                        //e.preventDefault();
                        //e.stopPropagation();
                    });
                }(jQuery));



            </script>
        </div>
    </div>
</div>

