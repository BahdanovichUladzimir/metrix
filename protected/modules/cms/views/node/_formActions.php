<?php
/**
 * @var CmsPage $model
 */
;?>
<?php $this->widget('booster.widgets.TbButton', array(
    'buttonType'=>'submit',
    'context'=>'success',
    'label'=>$model->isNewRecord ? Yii::t('core','Create') : Yii::t('core','Save'),
)); ?>

