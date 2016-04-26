<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 02.03.2015
 */

class SaveCreatedDateBehavior extends CActiveRecordBehavior{

    public $createdDateAttribute = NULL;
    public $formattedCreatedDateAttribute = 'formattedCreatedDate';

    public function beforeSave($event){
        /**
         * @var $model Feedback
         */
        $model = $this->getOwner();
        if($model->isNewRecord && ($this->createdDateAttribute !== null)) {
            $model->{$this->createdDateAttribute} = time();
        }
    }

    public function afterFind($event){
        $model = $this->getOwner();
        $model->{$this->formattedCreatedDateAttribute} = date("d.m.Y", $model->{$this->createdDateAttribute});
    }

}