<?php

/**
 * EPictureValidator class.
 *
 * Validates the image
 *
 * @author   Sergey Tsivin <sergey.tsivin@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://www.yiiframework.com/extension/epicturevalidator/
 */
class EPictureValidator extends CValidator
{

    /**
     * @var boolean whether the attribute requires a file to be uploaded or not.
     * Defaults to false, meaning a file is required to be uploaded.
     */
    public $allowEmpty = false;
    /**
     * @var integer the minimum picture width
     */
    public $minWidth;
    /**
     * @var integer the maximum picture width
     */
    public $maxWidth;
    /**
     * @var integer the minimum picture height
     */
    public $minHeight;
    /**
     * @var integer the maximum picture height
     */
    public $maxHeight;

    /**
     * Set the attribute and then validates using {@link validateFile}.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     *
     * @param string $attribute the attribute being validated
     *
     * @return void
     */
    protected function validateAttribute($object, $attribute)
    {
        $file = $object->$attribute;

        if (!$file instanceof CUploadedFile) {
            $file = CUploadedFile::getInstance($object, $attribute);
            if (null === $file)
                return $this->emptyAttribute($object, $attribute);
        }


        /*$type = CFileHelper::getMimeType($file->tempName);
        list($type, $subtype) = @explode('/', $type);
        if ('image' != $type) {
            $message = Yii::t('ext', 'File cannot be uploaded because it is not a valid image file');
            $this->addError($object, $attribute, $message);
            return;
        }*/

        $size = getimagesize($file->tempName);
        if (false === $size) {
            $message = Yii::t('ext', 'File cannot be uploaded because it is not a valid image file');
            $this->addError($object, $attribute, $message);
            return;
        }

        if (!empty($this->minWidth) && $size[0] < $this->minWidth) {
            $message = Yii::t('ext', 'Изображение слишком маленькое: ширина изображения должна быть не менее {minWidth} пикселей');
            $this->addError($object, $attribute, $message, array('{minWidth}' => $this->minWidth));
        }

        if (!empty($this->minHeight) && $size[1] < $this->minHeight) {
            $message = Yii::t('ext', 'Изображение слишком маленькое: высота изображения должна быть не менее {minHeight} пикселей');
            $this->addError($object, $attribute, $message, array('{minHeight}' => $this->minHeight));
        }
        
        if (!empty($this->maxWidth) && $size[0] > $this->maxWidth) {
            $message = Yii::t('ext', 'Изображение слишком большое: ширина изображения должна быть не более {maxWidth} пикселей');
            $this->addError($object, $attribute, $message, array('{maxWidth}' => $this->maxWidth));
        }

        if (!empty($this->maxHeight) && $size[1] > $this->maxHeight) {
            $message = Yii::t('ext', 'Изображение слишком большое: высота изображения должна быть не более {maxHeight} пикселей');
            $this->addError($object, $attribute, $message, array('{maxHeight}' => $this->maxHeight));
        }
    }

    /**
     * Raises an error to inform end user about blank attribute.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     *
     * @return void
     */
    protected function emptyAttribute($object, $attribute)
    {
        if (!$this->allowEmpty) {
            $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} cannot be blank.');
            $this->addError($object, $attribute, $message);
        }
    }

}

?>