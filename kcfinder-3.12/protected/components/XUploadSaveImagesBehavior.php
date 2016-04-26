<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 15.01.2015
 */

class XUploadSaveImagesBehavior extends CActiveRecordBehavior
{
    public $imagesPath = NULL;
    public $imagesUrl = NULL;
    public $largeThumbWidth = NULL;
    public $largeThumbHeight = NULL;
    public $mediumThumbWidth = NULL;
    public $mediumThumbHeight = NULL;
    public $smallThumbWidth = NULL;
    public $smallThumbHeight = NULL;
    public $largeThumbPrefix = "large_";
    public $mediumThumbPrefix = "medium_";
    public $smallThumbPrefix = "small_";

    public function afterSave($event){
        $model = $this->owner;
        $user = Yii::app()->user;
        $userImages = array();
        if($user->hasState('images')){
            $userImages = $user->getState('images');
            $user->setState('images', NULL);
        }
        // если в сессии пришли картинки
        if($userImages){
            $imagesDir = $this->imagesPath.$model->id."/";
            // создаём директорию для всех изображений товара, если такой не существует
            if(!is_dir($imagesDir)){
                mkdir($imagesDir);
            }
            foreach($userImages as $image){
                $originalPath = $imagesDir.$image['filename'];
                $largeThumbPath = $imagesDir.$this->largeThumbPrefix.$image['filename'];
                $mediumThumbPath = $imagesDir.$this->mediumThumbPrefix.$image['filename'];
                $smallThumbPath = $imagesDir.$this->smallThumbPrefix.$image['filename'];
                // перемещаем временный файл в директорию изображений товара на пмж :)
                if(rename($image['path'],$originalPath)){
                    // удаляем старый тумб, он нам больше не нужен
                    unlink($image['thumb']);
                    // грузим новый файл и создаём тумбы
                    $normalImage = Yii::app()->image->load($originalPath);
                    $normalImage->resize($this->largeThumbWidth, $this->largeThumbHeight);
                    $normalImage->save($largeThumbPath);
                    $normalImage->resize($this->mediumThumbWidth, $this->mediumThumbHeight);
                    $normalImage->save($mediumThumbPath);
                    $normalImage->resize($this->smallThumbWidth,$this->smallThumbHeight);
                    $normalImage->save($smallThumbPath);
                };
                $imageSize = getimagesize($originalPath);
                $imagesModel = new DealsImages();
                $imagesModel->file_name = $image['filename'];
                $imagesModel->path = $image['path'];
                $imagesModel->ext = $image['ext'];
                $imagesModel->name = $image['fileNameWithoutExt'];
                $imagesModel->width = $imageSize[0];
                $imagesModel->height = $imageSize[1];
                $imagesModel->url = $this->imagesUrl.$model->id."/".$image['filename'];
                $imagesModel->deal_id = $model->id;
                if($imagesModel->validate()){
                    $imagesModel->save();
                }
                else{
                    echo json_encode( array(
                        array( "error" => $model->getErrors(),
                        ) ) );
                    Yii::log( "XUploadSaveImagesBehavior: ".CVarDumper::dumpAsString( $model->getErrors( ) ),
                        CLogger::LEVEL_ERROR, "XUploadSaveImagesBehavior"
                    );
                }
            }
        }
    }

    public function afterFind($event){

    }
}