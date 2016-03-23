<?php $checkAccess = Yii::app()->user->checkAccess('Cms.Block.Update');?>
<div <?php echo $checkAccess ? "class=\"edit-block\"" : ""; ?>>
    <?php echo $content; 
    if ($checkAccess):
        echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span>', Yii::app()->createUrl('cms/block/update', array('id' => $model->id)), array('class' => 'btn btn-info',
            'title' => 'Изменить Блок'));
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
