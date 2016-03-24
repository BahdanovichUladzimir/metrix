<?php

/**
 * @var $models Dictionary[]
 * @var string $letter
 * @var array $rusAlphabet
 * @var $models $enAlphabet
 */
$this->breadcrumbs=array(
	Yii::t('cmsModule','Dictionary')
);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h1><?=Yii::t('Dictionary','Dictionary');?></h1>
        <?php foreach($rusAlphabet as $rusLetter):?>
            <?php if($letter == $rusLetter):?>
                <span class="dictionary-menu-letter active"><?=CHtml::link($rusLetter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $rusLetter)));?></span>
            <?php else:?>
                <span class="dictionary-menu-letter"><?=CHtml::link($rusLetter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $rusLetter)));?></span>
            <?php endif;?>
        <?php endforeach;?>
        <?php if($letter == "A-Z"):?>
            <span class="dictionary-menu-letter active"><?=CHtml::link(Yii::t('cmsModule','A-Z'),Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => "A-Z")));?></span>
        <?php else:?>
            <span class="dictionary-menu-letter"><?=CHtml::link(Yii::t('cmsModule','A-Z'),Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => "A-Z")));?></span>
        <?php endif;?>
        <span class="dictionary-menu-letter"><?=CHtml::link(Yii::t('cmsModule','All'),Yii::app()->createUrl("/cms/frontend/dictionary/index"));?></span>
        <h2 class="dictionary-letter"><?=CHtml::link($letter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $letter)));?></h2>
        <div class="row">
            <?php foreach($models as $model):?>
                <div class="col-lg-3 col-md-3  col-sm-4 col-xs-6">
                    <?=CHtml::link(ucfirst($model->name),Yii::app()->createUrl("/cms/frontend/dictionary/view", array('id' => $model->id)), array('class' => 'dictionary-word'));?>
                </div>
            <?php endforeach;?>
        </div>
        <hr class="dictionary-hr">
    </div>
</div>
