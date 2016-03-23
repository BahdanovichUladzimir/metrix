<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 13.06.14
 * @var $dataProvider CActiveDataProvider
 * @var $categoriesDataProvider CActiveDataProvider
 * @var $model Deals
 * @var string $messageStatus
 * @var string $message
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.highlight.js');
if(isset($query) && !is_null($query))
{
    Yii::app()->clientScript->registerScript('search_highlight', "
    $(document).ready(function(){
        $('.deal-name, .ellipsis, .search-result-categories-list-item').highlight(\"".trim(CHtml::encode($query))."\");
    });
");
}

;?>

<div class="row">
    <section class="col-lg-9">
        <div class="cf">
            <?php $this->widget('widgets.currencySelect.CurrencySelectWidget');?>
            <h1 class="title section-title h1"><?=$this->h1;?></h1>
        </div>
        <div class="alert alert-<?=$messageStatus;?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?=$message;?>
        </div>
        <?php if(is_null($categoriesDataProvider) && is_null($dataProvider)):?>
            <h3></h3>
        <?php else:?>
            <?php if(!is_null($categoriesDataProvider)):?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$categoriesDataProvider,
                    'itemView'=>'_category',   // refers to the partial view named '_item'
                    'ajaxUpdate'=>false,
                    'emptyText' => '',
                    'template'=>'<ul class="categories-search-result-list">{items}</ul>',
                ));?>
            <?php endif;?>

            <?php if(!is_null($dataProvider)):?>
                <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_item',   // refers to the partial view named '_item'
                    'ajaxUpdate'=>false,
                    'pagerCssClass' => 'pagerCssClass',
                    'template'=>'<div class="row search-list-info"><div class="col-xs-6">{summary}</div><div class="col-xs-6">{sorter}</div></div>{items}{pager}',
                    'emptyText' => '',
                    'pager' => array(
                        'maxButtonCount' => 12,
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'footer' => '</nav>',
                        'header' => '<nav>',
                        'selectedPageCssClass' => 'active',
                        'htmlOptions' => array(
                            'class' => 'pagination'
                        )
                    ),
                ));?>
            <?php endif;?>
        <?php endif;?>

    </section>
    <section class="col-lg-3">


    </section>


</div>
<div class="row">
    <div class="col-lg-9 col-sm-12 col-xs-12 col-md-9">
        <?=$this->seoText;?>
    </div>
</div>


