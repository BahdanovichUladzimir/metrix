<?php
/**
 * @var CmsPageContent $model
 */
;?>
<script src="<?php echo Yii::app()->baseUrl.'/js/ckeditor/ckeditor.js'; ?>"></script>

<?php echo $form->textFieldGroup($model,'['.$model->locale.']heading',array('class'=>'input-xxlarge')); ?>
        <?php 
        $attribute='['.$model->locale.']body';?>
<?php /*echo $form->labelEx($model,$attribute) */?>
    <?php
    $_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
    $_SESSION['KCFINDER']['uploadURL'] = Yii::app()->baseUrl."/uploads/cmsModule/"; // URL for the uploads folder
    $_SESSION['KCFINDER']['uploadDir'] = Yii::app()->basePath."/../uploads/cmsModule/"; // path to the uploads folder
?>

<?php echo $form->labelEx($model,$attribute); ?>
<?php echo $form->textArea($model, $attribute, array('id'=>'ckeditor_'.$model->locale)); ?>
<?php echo $form->error($model,$attribute); ?>
<script type="text/javascript">
    CKEDITOR.replace( 'ckeditor_<?=$model->locale;?>', {
        filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder-3.12/browse.php?type=files',
        filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder-3.12/browse.php?type=images',
        filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder-3.12/browse.php?type=flash',
        filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder-3.12/upload.php?type=files',
        filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder-3.12/upload.php?type=images',
        filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder-3.12/upload.php?type=flash'
    });
</script>

<hr />

<h3><?php echo Yii::t('CmsModule.core','Properties'); ?></h3>

<?php echo $form->textFieldGroup($model,'['.$model->locale.']url',array('class'=>'input-xxlarge')) ?>
<?php echo $form->textFieldGroup($model,'['.$model->locale.']pageTitle',array('class'=>'input-xxlarge')) ?>
<?php echo $form->textFieldGroup($model,'['.$model->locale.']breadcrumb',array('class'=>'input-xxlarge')) ?>
<?php echo $form->textFieldGroup($model,'['.$model->locale.']metaTitle',array('class'=>'input-xxlarge')) ?>
<?php echo $form->textAreaGroup($model,'['.$model->locale.']metaDescription',array('class'=>'input-xxlarge','rows'=>3)) ?>
<?php echo $form->textFieldGroup($model,'['.$model->locale.']metaKeywords',array('class'=>'input-xxlarge')) ?>
<div class="form-group">
    <?php if(!$model->isNewRecord):?>
        <?=CHtml::link(
            Yii::t('cmsModule',"Publish on Vkontakte"),
            Yii::app()->createUrl(
                "/cms/socialMediaPosting/create",
                array(
                    "item_id" => $model->id,
                    "network" => 1,
                    "type" => 1,
                )
            ),
            array('class' => 'btn btn-success')
        );?>
        <?=CHtml::link(
            Yii::t('cmsModule',"Publish on Facebook"),
            Yii::app()->createUrl(
                "/cms/socialMediaPosting/create",
                array(
                    "item_id" => $model->id,
                    "network" => 1,
                    "type" => 1,
                )
            ),
            array('class' => 'btn btn-success'));?>
    <?php endif;?>
</div>
