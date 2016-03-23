<?php $checkAccess = Yii::app()->user->checkAccess('Cms.Page.Update');?>
<div class="cms-page <?php echo $checkAccess ? "edit-block" : ""; ?>">
    <section>
        <div class="panel panel-default">
            <div class="panel-body cf">
                <h1>
                    <?php echo CHtml::encode($heading); ?>
                </h1>
                <?php echo $content ?>

            </div>
        </div>
    </section>


    <?php
    if ($checkAccess):
        echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span>', Yii::app()->createUrl('cms/page/update', array('id' => $model->id)), array('class' => 'btn btn-info',
            'title' => 'Изменить страницу'));
    endif;
    ?>

</div>
<?php if($checkAccess):?>
    <style>
        .edit-block {
            position: relative;
        }
        .edit-block:hover>.btn {
            display: block;
            position: absolute;
            top: 0px;
            right: 0px;
            background-color: black;
            border-color: black;
        }
        .edit-block>.btn {
            display: none;

        }
    </style>
<?php endif;?>