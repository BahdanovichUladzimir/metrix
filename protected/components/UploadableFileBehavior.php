<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 05.03.2015
 */

class UploadableFileBehavior extends CActiveRecordBehavior{
    /**
     * @var string название атрибута, хранящего в себе файл
     */
    public $fileAttributeName='file';

    /**
     * @var string название атрибута, хранящего в себе имя файла
     */
    public $fileNameAttributeName='image';

    /**
     * @var string Имя аттрибута идентификатора
     */
    public $idAttributeName='id';

    /**
     * @var bool Создавать ли поддиректорию для изображения
     */
    public $isCreateSubfolder=true;
    /**
     * @var string Этот атрибут будет использован в качестве имени поддиректории для изображений
     * например webroot.uploads.{subfolder}.your_image
     */
    public $subFolderNameAttributeName = 'id';
    /**
     * @var string алиас директории, куда будем сохранять файлы
     */
    public $savePathAlias='webroot.uploads';
    /**
     * @var array сценарии валидации к которым будут добавлены правила валидации
     * загрузки файлов
     */
    public $scenarios=array('insert','update', 'updateMainSettings');
    /**
     * @var string типы файлов, которые можно загружать (нужно для валидации)
     */
    public $fileTypes='png, gif, jpeg, jpg';

    public $largeThumbEmptyUrl = NULL;
    public $mediumThumbEmptyUrl = NULL;
    public $smallThumbEmptyUrl = NULL;
    public $largeThumbEmptyPath = NULL;
    public $mediumThumbEmptyPath = NULL;
    public $smallThumbEmptyPath = NULL;
    public $emptyImageUrl = NULL;
    public $emptyImagePath = NULL;

    public $largeThumbWidth = 1000;
    public $largeThumbHeight = 800;
    public $mediumThumbWidth = 500;
    public $mediumThumbHeight = 400;
    public $smallThumbWidth = 100;
    public $smallThumbHeight = 100;
    public $smallThumbPrefix = 'small_';
    public $mediumThumbPrefix = 'medium_';
    public $largeThumbPrefix = 'large_';

    /**
     * Шорткат для Yii::getPathOfAlias($this->savePathAlias).DIRECTORY_SEPARATOR.
     * Возвращает путь к директории, в которой будут сохраняться файлы.
     * @return string путь к директории, в которой сохраняем файлы
     */
    public function getSavePath(){
        if($this->isCreateSubfolder){
            return Yii::getPathOfAlias($this->savePathAlias).DIRECTORY_SEPARATOR.$this->owner->{$this->subFolderNameAttributeName}.DIRECTORY_SEPARATOR;
        }
        else{
            return Yii::getPathOfAlias($this->savePathAlias).DIRECTORY_SEPARATOR;
        }
    }

    public function attach($owner){
        parent::attach($owner);

        if(in_array($owner->scenario,$this->scenarios)){
            // добавляем валидатор файла
            $fileValidator=CValidator::createValidator(
                'file',
                $owner,
                $this->fileAttributeName,
                array(
                    'types'=>$this->fileTypes,
                    'allowEmpty'=>true,
                    'maxSize' => 5242880 // 5Mb
                )
            );
            $owner->validatorList->add($fileValidator);
        }
    }

    // имейте ввиду, что методы-обработчики событий в поведениях должны иметь
    // public-доступ начиная с 1.1.13RC
    public function afterSave($event){
        if(in_array($this->owner->scenario,$this->scenarios) &&
            ($file=CUploadedFile::getInstance($this->owner,$this->fileAttributeName))){
            $this->deleteFiles(); // старый файл удалим, потому что загружаем новый
            $fileName = md5(Yii::app()->user->id.microtime().$this->owner->{$this->idAttributeName}).".".$file->getExtensionName();
            $imagesDirPath = $this->getSavePath();
            if($this->_createSubFolder($imagesDirPath)){
                $originalImagePath = $imagesDirPath.$fileName;
                if($file->saveAs($originalImagePath)){
                    $this->owner->updateByPk($this->owner->{$this->idAttributeName}, array($this->fileNameAttributeName=>$fileName));
                    chmod($originalImagePath,0777);
                    $largeThumbPath = $imagesDirPath.$this->largeThumbPrefix.$fileName;
                    $mediumThumbPath = $imagesDirPath.$this->mediumThumbPrefix.$fileName;
                    $smallThumbPath = $imagesDirPath.$this->smallThumbPrefix.$fileName;

                    // Загружаем оригинальный файл, делаем тумбы и сохраняем их
                    $image = Yii::app()->image->load($originalImagePath);
                    $image->resize($this->largeThumbWidth, $this->largeThumbHeight);
                    $image->save($largeThumbPath);
                    chmod($largeThumbPath,0777);
                    $image->resize($this->mediumThumbWidth, $this->mediumThumbHeight, Image::WIDTH);
                    $image->save($mediumThumbPath);
                    chmod($mediumThumbPath,0777);
                    $image->resize($this->smallThumbWidth,$this->smallThumbHeight);
                    $image->save($smallThumbPath);
                    chmod($smallThumbPath,0777);
                }
            };
        }
        return parent::afterSave($event);
    }

    // имейте ввиду, что методы-обработчики событий в поведениях должны иметь
    // public-доступ начиная с 1.1.13RC
    public function beforeDelete($event){
        return $this->deleteFiles(); // удалили модель? удаляем и файл, связанный с ней
    }

    /**
     * @return bool
     */
    public function deleteFiles(){
        $fileName = $this->owner->getAttribute($this->fileNameAttributeName);
        $imagePath=$this->getSavePath().$fileName;
        $largeThumbPath = $this->getSavePath().$this->largeThumbPrefix.$fileName;
        $mediumThumbPath = $this->getSavePath().$this->mediumThumbPrefix.$fileName;
        $smallThumbPath = $this->getSavePath().$this->smallThumbPrefix.$fileName;
        if(@is_file($imagePath)){
            @unlink($imagePath);
        }
        if(@is_file($largeThumbPath)){
            @unlink($largeThumbPath);
        }
        if(@is_file($mediumThumbPath)){
            @unlink($mediumThumbPath);
        }
        if(@is_file($smallThumbPath)){
            @unlink($smallThumbPath);
        }
        if($this->isCreateSubfolder && is_dir($this->getSavePath())){
            rmdir($this->getSavePath());
        }
        if(!is_file($imagePath) && !is_file($largeThumbPath) && !is_file($mediumThumbPath) && !is_file($smallThumbPath) && $this->_deleteSubFolder($this->getSavePath())){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @param string $dirPath Путь директории изображений
     * @return bool
     */
    private function _createSubFolder($dirPath){
        if(!is_dir($dirPath)){
            if(mkdir($dirPath)){
                chmod($dirPath, 0775);
            }
        }
        if(is_dir($dirPath)){
            return true;
        }
        return false;
    }

    /**
     * @param string $dirPath Путь директории изображений
     * @return bool
     */
    private function _deleteSubFolder($dirPath){
        if(is_dir($dirPath) && (sizeof(glob($dirPath."/*")) == 0)){
            rmdir($dirPath);
        }
        if(!is_dir($dirPath)){
            return true;
        }
        return false;
    }
}