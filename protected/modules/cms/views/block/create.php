<?php
/**
 * @var $model CmsBlock
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Block')=>array('index'),
    Yii::t('adminModule','Create'),
);
?>
<h1><?php echo "Создание блока" ?></h1>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm');
?>

<?php $this->renderPartial('_form', array('form' => $form, 'model' => $model)); ?>

<?php $this->renderPartial('cms.views.node._formActions', array('model' => $model)); ?>

<?php $this->endWidget(); ?>
