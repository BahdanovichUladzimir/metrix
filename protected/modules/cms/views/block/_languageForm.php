<div class="control-group">
    <?php echo $form->labelEx($model,'['.$model->locale.']body') ?>
    <?php
    $this->widget('booster.widgets.TbCKEditor', array(
        'model' => $model,
        'attribute' => '['.$model->locale.']body',
        'language' => 'ru',
        'editorTemplate' => 'full',
    ));
    ?>
</div>
