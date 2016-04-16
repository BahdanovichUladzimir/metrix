<?php
/**
 * @var CmsPage $model
 */
;?>

<?php echo $form->textFieldGroup($model,'name'); ?>
<?php echo $form->dropDownListGroup(
    $model,
    'parentId',
    array(
        'wrapperHtmlOptions' => array(
            //'class' => 'col-sm-5 col-md-5 col-xs-12',
        ),
        'widgetOptions' => array(
            'data' => $model->getParentOptionTree(),
            'htmlOptions' => array(),
        )
    )
); ?>

<div class="form-group">
    <label class="control-label" for="CmsPage_dictionary"><?=Yii::t("cmsModule",'Dictionary');?></label>
    <div>
        <?php
        $this->widget(
            'bootstrap.widgets.TbSelect2',
            array(
                'model' => $model,
                'attribute' => 'dictionary',
                'data' => CHtml::listData(Dictionary::model()->findAll(),'id','name'),
                'htmlOptions' => array(
                    'multiple' => 'multiple',
                ),
            )
        );?>
    </div>
</div>
<?php echo $form->dropDownListGroup(
    $model,
    'type',
    array(
        'wrapperHtmlOptions' => array(
            //'class' => 'col-sm-5 col-md-5 col-xs-12',
        ),
        'widgetOptions' => array(
            'data' => $model->getTypeOptions(),
            'htmlOptions' => array(),
        )
    )
); ?>
<?php echo $form->checkboxGroup($model,'published') ?>