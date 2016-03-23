<?php
/**
 * CmsModule class file.
 * @author Christoffer Niska <christoffer.niska@nordsoftware.com>
 * @copyright Copyright &copy; 2011, Nord Software Ltd
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package nord.cms
 * @version 2.0.0
 */

class CmsModule extends CWebModule
{
	/**
	 * @var string[] page types.
	 */
	public $pageTypes = array('stories','page','news');
	/**
	 * @var array flash message categories.
	 */
	public $flashes = array();
	/**
	 * @var string administration layout.
	 */
	public $adminLayout = 'application.views.layouts.adminmain';
	/**
	 * @var string page layout.
	 */
	public $pageLayout = 'application.views.layouts.main';

	/**
	 * Initializes the module.
	 */
	public function init()
	{
		// Register module imports.
		$this->setImport(array(
			'cms.components.*',
			'cms.controllers.*',
			'cms.models.*',
		));

	    $this->flashes = CMap::mergeArray(array(
		    'error' => 'error',
		    'info' => 'info',
		    'success' => 'success',
		    'warning' => 'warning',
	    ), $this->flashes);

		$this->defaultController = 'page';
	}

	/**
	 * Performs access check to this module.
	 * @param CController $controller the controller to be accessed
	 * @param CAction $action the action to be accessed
	 * @return boolean whether the action should be executed
	 * @throws CHttpException if access is denied.
	 */
	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
		{
			$publicRoutes = array('page/view', 'language/change');
			$route = $controller->id.'/'.$action->id;
			if (!in_array($route, $publicRoutes) && !Yii::app()->cms->checkAccess())
				throw new CHttpException(403, Yii::t('CmsModule.core', 'You are not allowed to access this page.'));

			return true;
		}

		return false;
	}

	/**
	 * Returns the module version number.
	 * @return string the version
	 */
	public function getVersion() 
	{
		return '2.0.0';
	}
}
