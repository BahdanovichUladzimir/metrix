<?php

/**
 * @var $insufficientImagesCountDealsDataProvider CActiveDataProvider
 * @var $tooManyImagesCountDealsDataProvider CActiveDataProvider
 * @var $insufficientDescLengthDealsDataProvider CActiveDataProvider
 * @var $deactivatedDealsDataProvider CActiveDataProvider
 */
$this->breadcrumbs=array(
	Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
	Yii::t('dealsModule','Deals statistics')=>array('index'),
	Yii::t('dealsModule','Bad deals'),
);
?>

<h1><?=Yii::t('dealsModule','Bad deals');?></h1>
<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#insufficientImagesCount" aria-controls="general" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Insufficient images count deals");?></a></li>
        <li role="presentation"><a href="#tooManyImagesCountDeals" aria-controls="lastMonth" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Too many images count deals");?></a></li>
        <li role="presentation"><a href="#insufficientDescLength" aria-controls="lastWeek" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Insufficient Description length");?></a></li>
        <li role="presentation"><a href="#deactivatedDeals" aria-controls="lastDay" role="tab" data-toggle="tab"><?=Yii::t("adminModule","Deactivated deals");?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="insufficientImagesCount">
            <?php $this->widget('booster.widgets.TbGridView',array(
                'id'=>'bad_deals_insufficient_images_count_grid',
                'dataProvider'=>$insufficientImagesCountDealsDataProvider,
                'columns'=>array(
                    array(
                        'name' => 'id',
                        'headerHtmlOptions' => array(
                            'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
                        ),
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name,$data->getPublicUrl())',
                    ),
                    array(
                        'name' => 'user_id',
                        'header' => 'User',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
                    ),
                    array(
                        'header' => 'Images count',
                        'type' => 'raw',
                        'value' => 'sizeof($data->dealsImages)',
                    ),
                ),
            )); ?>

        </div>
        <div role="tabpanel" class="tab-pane" id="tooManyImagesCountDeals">
            <?php $this->widget('booster.widgets.TbGridView',array(
                'id'=>'bad_deals_tooMany_images_count_grid',
                'dataProvider'=>$tooManyImagesCountDealsDataProvider,
                'columns'=>array(
                    array(
                        'name' => 'id',
                        'headerHtmlOptions' => array(
                            'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
                        ),
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name,$data->getPublicUrl())',
                    ),
                    array(
                        'name' => 'user_id',
                        'header' => 'User',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
                    ),
                    array(
                        'header' => 'Images count',
                        'type' => 'raw',
                        'value' => 'sizeof($data->dealsImages)',
                    ),
                ),
            )); ?>

        </div>
        <div role="tabpanel" class="tab-pane" id="insufficientDescLength">
            <?php $this->widget('booster.widgets.TbGridView',array(
                'id'=>'bad_deals_insufficientDescLength_grid',
                'dataProvider'=>$insufficientDescLengthDealsDataProvider,
                'columns'=>array(
                    array(
                        'name' => 'id',
                        'headerHtmlOptions' => array(
                            'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
                        ),
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name,$data->getPublicUrl())',
                    ),
                    array(
                        'name' => 'user_id',
                        'header' => 'User',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
                    ),
                    array(
                        'header' => 'Description length',
                        'type' => 'raw',
                        'value' => 'strlen($data->description)',
                    ),
                ),
            )); ?>


        </div>
        <div role="tabpanel" class="tab-pane" id="deactivatedDeals">
            <?php $this->widget('booster.widgets.TbGridView',array(
                'id'=>'bad_deals_deactivatedDeals_grid',
                'dataProvider'=>$deactivatedDealsDataProvider,
                'columns'=>array(
                    array(
                        'name' => 'id',
                        'headerHtmlOptions' => array(
                            'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
                        ),
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name,$data->getPublicUrl())',
                    ),
                    array(
                        'name' => 'user_id',
                        'header' => 'User',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->user->id." (".$data->user->username.")",$data->user->getAdminUrl())',
                    ),
                    array(
                        'name' => 'status_id',
                        'header' => 'Status',
                        'type' => 'raw',
                        'value' => '$data->status->label',
                    ),
                    array(
                        'name' => 'approve',
                        'header' => 'Approve',
                        'headerHtmlOptions' => array(
                            'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
                        ),
                        'type' => 'raw',
                        'value' => function($data) {
                            if($data->approve == 0){
                                $html = "<h5 class='text-danger'><i class='glyphicon glyphicon-ban-circle'></i></h5>";
                            }
                            elseif($data->approve == 1){
                                $html = "<h5 class='text-success'><i class='glyphicon glyphicon-ok'></i></h5>";
                            }
                            elseif($data->approve == 2){
                                $html = "<h5 class='text-warning'><i class='glyphicon glyphicon-question-sign'></i></h5>";
                            }
                            else{
                                $html = "<h5>Undefined approve status</h5>";
                            }
                            return $html;
                        },
                    ),
                    array(
                        'name' => 'archive',
                        'header' => 'Archive',
                        'headerHtmlOptions' => array(
                            'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
                        ),
                        'type' => 'raw',
                        'value' => function($data) {
                            if($data->archive == 0){
                                $html = "<h5 class='text-danger'><i class='glyphicon glyphicon-ban-circle'></i></h5>";
                            }
                            elseif($data->archive == 1){
                                $html = "<h5 class='text-success'><i class='glyphicon glyphicon-ok'></i></h5>";
                            }
                            else{
                                $html = "<h5>Undefined archive status</h5>";
                            }
                            return $html;
                        },
                    ),
                ),
            )); ?>


        </div>
    </div>

</div>


