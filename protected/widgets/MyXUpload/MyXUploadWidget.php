<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 02.06.2015
 */
Yii::import('ext.xupload.*');
class MyXUploadWidget extends XUpload{

    /**
     * @var null|Deals
     */
    public $deal = NULL;

    //public $filesContainer = "#files";

    /**
     * Publishes the required assets
     */
    public function init(){
        parent::init();
        $this -> publishAssets();
    }

    /**
     * Generates the required HTML and Javascript
     */
    public function run(){

        if(is_null($this->deal) || !$this->deal instanceof Deals){
            return false;
        }

        list($name, $id) = $this -> resolveNameID();

        $model = $this -> model;

        if ($this -> uploadTemplate === null) {
            $this -> uploadTemplate = "#template-upload";
        }
        if ($this -> downloadTemplate === null) {
            $this -> downloadTemplate = "#template-download";
        }

        $this -> render($this->uploadView);
        $this -> render($this->downloadView);

        if (!isset($this -> htmlOptions['enctype'])) {
            $this -> htmlOptions['enctype'] = 'multipart/form-data';
        }

        if (!isset($this -> htmlOptions['id'])) {
            $this -> htmlOptions['id'] = get_class($model) . "-form";
        }

        $this->options['url'] = $this->url;
        $this->options['autoUpload'] = $this -> autoUpload;
        //$this->options['filesContainer'] = $this->filesContainer;
        $this->options['previewMaxWidth'] = 128;
        $this->options['previewMaxHeight'] = 128;
        $this->options['previewMinWidth'] = 128;
        $this->options['previewMinHeight'] = 128;

        if (!$this->multiple) {
            $this->options['maxNumberOfFiles'] = 1;
        }

        $options = CJavaScript::encode($this -> options);

        Yii::app() -> clientScript -> registerScript(__CLASS__ . '#' . $this -> htmlOptions['id'], "jQuery('#{$this->htmlOptions['id']}').fileupload({$options});", CClientScript::POS_READY);
        $htmlOptions = array();
        if ($this -> multiple) {
            $htmlOptions["multiple"] = true;
            /* if($this->hasModel()){
                 $this -> attribute = "[]" . $this -> attribute;
             }else{
                 $this -> attribute = "[]" . $this -> name;
             }*/
        }
        $data = array(
            'htmlOptions' => $htmlOptions,
            'deal' => $this->deal
        );
        $this -> render($this->formView, $data);

    }

}