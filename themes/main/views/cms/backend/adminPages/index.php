<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 22.06.2015
 * @var $model CmsPage
 * @var $dataProvider CActiveDataProvider
 */
;?>
<?php
$this->breadcrumbs=array(
    Yii::t("core",$type),
);
?>
<h1 class="title section-title h1">
    <?=Yii::t("core",$type);?>
</h1>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php $this->widget('zii.widgets.CListView',array(
            'id'=>'stories-grid',
            'dataProvider'=>$dataProvider,
            'itemView'=>'_story',
            //'filter'=>$model,
            //'sortableRows'=>true,
            'sortableAttributes'=>array(
                'title',
                'create_time'=>'Post Time',
            ),
            'template' => '{pager}{items}{pager}',
            'enablePagination' => true,
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
            //'ajaxUpdate'=>false,
        )); ?>
    </div>
</div>