<?php

/**
 * @var $model Comments
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('commentsModule','Comments')=>array('index'),
    Yii::t('core','Manage'),
);
?>

<h1><?=Yii::t('commentsModule','Manage Comments');?></h1>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?=CHtml::ajaxButton(
            'Approve selected',
            Yii::app()->createUrl('/comments/backend/comments/approveSelected'),
            array(
                'type' => 'POST',
                'data' => 'js:{value : $.fn.yiiGridView.getChecked("comments-grid","approve_check")}',
                'success'=>'js:function(data){
					 $.fn.yiiGridView.update("comments-grid");
		}'
            ),
            array(
                'class' => 'btn btn-success'
            )

        );?>

    </div>
</div>
<?php $this->widget('booster.widgets.TbGridView',array(
    'id'=>'comments-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'id'=>'approve_check',
            'header' => 'Approve',
            'selectableRows' => 2,
            'disabled' => '$data->approve'
        ),
        //'title',
        'description',
        /*array(
            'name' => 'app_category_id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->appCategory->name,array("/admin/appCategories/update", "id" => $data->appCategory->id))',
        ),*/
        array(
            //'name' => 'app_category_id',
            'header' => 'App category item',
            'type' => 'raw',
            'value' => '$data->getAppCategoryItemLink()',
        ),
        //'app_category_item_id',
        array(
            'name' => 'approve',
            'header' => 'Approve',
            'headerHtmlOptions' => array(
                'class' => 'col-xs-1 col-sm-1 col-md-1 col-lg-1'
            ),
            'type' => 'raw',
            'value' => function($data) {
                $html = $data->approve ? "<h5 class='text-success'><i class='glyphicon glyphicon-ok'></i></h5>" : "<h5 class='text-danger'><i class='glyphicon glyphicon-ban-circle'></i></h5>";
                return $html;
            },
            'filter' => Comments::getApproveListData(),
        ),
        array(
            'name' => 'user_id',
            'header' => 'User',
            'type' => 'raw',
            'value' => 'CHtml::link($data->user->username,Yii::app()->createUrl("admin/users/default/view", array("id" => $data->user_id)))',
            'filter' => Comments::getApproveListData(),
        ),
        'user_id',
        /*'approve',
        'created_date',
        'published_date',
        */
        array(
            'header' => Yii::t('ses', 'Edit'),
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions' => array('class' => 'col-lg-3 button-column'),
            'template'=>'{approve} {unapprove} {update} {delete}',
            'buttons'=>array(
                'delete' => array(
                    'options' => array('class' => 'btn btn-danger delete'),
                    'visible' => 'Yii::app()->user->checkAccess("Comments.Backend.Comments.Delete")',
                ),
                'approve' => array(
                    'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                    'url'=>'Yii::app()->createUrl("/comments/backend/comments/approve", array("id" => $data->id))',
                    //'imageUrl'=>'...',
                    'options' => array(
                        'class' => 'btn btn-default',
                        'rel' => 'tooltip',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('commentsModule', 'Approve'),
                        'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("comments-grid")}')
                    ),
                    //'click'=>'...',
                    'visible'=>'$data->approve == 0',
                ),
                'unapprove' => array(
                    'label'=>'<i class="glyphicon glyphicon-ok"></i>',
                    'url'=>'Yii::app()->createUrl("/comments/backend/comments/unApprove", array("id" => $data->id))',
                    //'imageUrl'=>'...',
                    'options' => array(
                        'class' => 'btn btn-success',
                        'rel' => 'tooltip',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('commentsModule', 'UnApprove'),
                        'ajax' => array('type' => 'get', 'url'=>'js:$(this).attr("href")', 'success' => 'js:function(data) { $.fn.yiiGridView.update("comments-grid")}')
                    ),
                    //'click'=>'...',
                    'visible'=>'$data->approve == 1',
                ),
                /*'view' => array(
                    'options' => array('class' => 'btn btn-info view'),
                    'url'=>'$data->getAdminUrl()',
                ),*/
                'update' => array(
                    'options' => array('class' => 'btn btn-success update'),
                    'visible' => "Yii::app()->user->checkAccess('Comments.Backend.Comments.Update')",
                ),
            ),
        ),
    ),
)); ?>
