<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 16.03.2015
 */
;?>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="" name="description">
<meta content="" name="author">

<script>
    var bootstrapButton, bootstrapTooltip;
</script>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/backend.css');?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/bootstrap.min.css', CClientScript::POS_END);?>


<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/jquery.fancybox.css?v=2.1.5');?>


<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5');?>

<?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7');?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/jquery.fancybox.pack.js?v=2.1.5', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js?v=1.0.6', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/uppod-0.5.9.js', CClientScript::POS_END);?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/backend.js', CClientScript::POS_END);?>





