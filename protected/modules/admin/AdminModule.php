<?php
/**
* Backend module class file.
*
* @author Bahdanovich Uladzimir <bahdanovich.uladzimir@lgmail.com>
*
*/
class AdminModule extends CWebModule
{
	public function init()
	{
		// Set required classes for import.
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));

		// Normally the default controller is Assignment.
		$this->defaultController = 'default';

	}

	public static function rules()
	{
		return array(
			'admin/countries/<id:\d+>' => 'admin/countries/view',
			'/admin/cities/<id:\d+>' => '/admin/cities/view',
		);
	}

}
