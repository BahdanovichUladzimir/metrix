<?php

class TranslateModule extends CWebModule {

    /**
     *
     */

    public $languages = array(
        'ru' => 'Russian',
        'en' => 'English',
    );
	public function init()
	{
		$this->defaultController = 'Translate';
		$this->setImport(array(
			'translate.models.*',
			'translate.controllers.*',
			'translate.components.*',
			'translate.widgets.*'
		));
		return parent::init();
	}

}