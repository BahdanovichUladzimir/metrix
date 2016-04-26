<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class UserFrontendController extends FrontendController{

	public $layout = '//layouts/main';
	public $defaultAction = 'index';
    public $pageClass = 'user-page';
    public $userId = NULL;
    public $user = NULL;

    public function init(){
        parent::init();
        $this->userId = Yii::app()->user->getId();
        $this->user = User::model()->findByPk($this->userId);
    }

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
}