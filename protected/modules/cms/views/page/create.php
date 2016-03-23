<?php
/**
 * @var $model CmsPage
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Page')=>array('index'),
    Yii::t('adminModule','Create'),
);
?>
<h1><?php echo 'Создание страницы' ?></h1>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm');
?>

<?php $this->renderPartial('_form', array('form' => $form, 'model' => $model)); ?>

<?php $this->renderPartial('cms.views.node._formActions', array('model' => $model)); ?>

<?php $this->endWidget(); ?>
