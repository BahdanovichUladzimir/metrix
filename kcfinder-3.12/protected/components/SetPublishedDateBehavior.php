<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 02.03.2015
 */

class SetPublishedDateBehavior extends CActiveRecordBehavior{

    public $publishedDateAttribute = 'published_date';
    public $publishedStatusId = 1;
    public $notPublishedStatusId = 2;
    public $statusIdAttribute = 'status_id';
    public $formattedPublishedDateAttribute = 'formattedPublishedDate';

    public function beforeSave($event){
        $model = $this->getOwner();
        if($model->{$this->statusIdAttribute} == $this->publishedStatusId) {
            $model->{$this->publishedDateAttribute} = time();
        }
        elseif($model->{$this->statusIdAttribute} == $this->notPublishedStatusId){
            $model->{$this->publishedDateAttribute} = 0;
        }
    }

    public function afterFind($event){
        $model = $this->getOwner();
        if($model->{$this->statusIdAttribute} == $this->publishedStatusId) {
            $model->{$this->formattedPublishedDateAttribute} = date("d.m.Y", $model->{$this->publishedDateAttribute});
        }
    }
}