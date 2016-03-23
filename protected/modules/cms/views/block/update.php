<?php
/**
 * @var $model CmsBlock
 */
$this->breadcrumbs=array(
    Yii::t('adminModule','Admin')=>Yii::app()->createUrl('/admin'),
    Yii::t('adminModule','Block')=>array('index'),
    Yii::t('adminModule','Update'),
);
?>
<h1><?php echo $model->name; ?></h1>
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm'); ?>

<?php $this->renderPartial('_form', array('form' => $form, 'model' => $model));?>
<?php $this->renderPartial('cms.views.node._contentForm', array('form' => $form, 'model' => $model)); ?>
<?php $this->renderPartial('cms.views.node._formActions'); ?>
<?php $this->endWidget(); ?>
