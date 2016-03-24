<?php

/**
 * @var $rusModels Dictionary[]
 * @var $enModels Dictionary[]
 * @var array $rusAlphabet
 * @var array $enAlphabet
 */
$this->breadcrumbs=array(
	Yii::t('cmsModule','Dictionary')
);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <h1><?=Yii::t('Dictionary','Dictionary');?></h1>
        <?php foreach($rusAlphabet as $rusLetter):?>
            <span class="dictionary-menu-letter"><?=CHtml::link($rusLetter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $rusLetter)));?></span>
        <?php endforeach;?>
        <span class="dictionary-menu-letter"><?=CHtml::link(Yii::t('cmsModule','A-Z'),Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => "A-Z")));?></span>
        <span class="dictionary-menu-letter active"><?=CHtml::link(Yii::t('cmsModule','All'),Yii::app()->createUrl("/cms/frontend/dictionary/index"));?></span>
        <?php foreach($rusAlphabet as $rusLetter):?>
            <h2 class="dictionary-letter"><?=CHtml::link($rusLetter,Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => $rusLetter)));?></h2>
            <?php $rusWords = array();?>
            <?php foreach($rusModels as $rusModel):?>
                <?php if($rusLetter == mb_strtoupper($rusModel->letter)):?>
                    <?php $rusWords[] = $rusModel;?>
                <?php endif;?>
            <?php endforeach;?>
            <div class="row">
                <?php foreach($rusWords as $rusWord):?>
                    <div class="col-lg-3 col-md-3  col-sm-4 col-xs-6">
                        <?=CHtml::link(ucfirst($rusWord->name),Yii::app()->createUrl("/cms/frontend/dictionary/view", array('id' => $rusWord->id)), array('class' => 'dictionary-word'));?>
                    </div>
                <?php endforeach;?>
            </div>
            <?php unset($word);?>
            <hr class="dictionary-hr">
        <?php endforeach;?>
        <h2 class="dictionary-letter"><?=CHtml::link(Yii::t('cmsModule','A-Z'),Yii::app()->createUrl("/cms/frontend/dictionary/letter", array('letter' => "A-Z")));?></h2>
        <div class="row">
            <?php foreach($enModels as $enModel):?>
                <div class="col-lg-3 col-md-3  col-sm-4 col-xs-6">
                    <?=CHtml::link(ucfirst($enModel->name),Yii::app()->createUrl("/cms/frontend/dictionary/view", array('id' => $enModel->id)), array('class' => 'dictionary-word'));?>
                </div>
            <?php endforeach;?>

        </div>
    </div>
</div>
