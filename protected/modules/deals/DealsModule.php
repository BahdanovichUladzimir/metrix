<?php

class DealsModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'deals.models.*',
			'deals.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public static function rules()
	{
        $sql = 'SELECT `key` from Cities';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $citiesArray = array();
        foreach ($dataReader as $row) {
            array_push($citiesArray, $row['key']);
        }
        $cities = implode("|",$citiesArray);

        $sql = 'SELECT `url_segment` from DealsCategories';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        $urlSegmentsArray = array();
        foreach ($dataReader as $row) {
            array_push($urlSegmentsArray, $row['url_segment']);
        }
        $urlSegments = implode("|",$urlSegmentsArray);

		return array(
            '/deal/update-photo/<id:\d+>' => '/deals/user/userDeals/photo',
            '/deal/update-video/<id:\d+>' => '/deals/user/userDeals/video',
            '/deal/update-social-media-video/<id:\d+>' => '/deals/user/userDeals/socialMediaVideo',
            '/user/favorites-deals' => '/deals/user/favorites/index',
            //'/search' => '/deals/frontend/search/index',
            '/search' => '/deals/frontend/search/yaSearch',
            '/deal/create' => '/deals/user/userDeals/create',
            '/deal/update' => '/deals/user/userDeals/update',
            "<city:$cities>/<urlSegment:$urlSegments>/<dealUrlSegment>-<id:\d+>" => '/deals/frontend/catalog/deal',
            "<city:$cities>/<urlSegment:$urlSegments>/page/<Deals_page:\d+>" => '/deals/frontend/catalog/index',
            "<city:$cities>/<urlSegment:$urlSegments>" => '/deals/frontend/catalog/index',
            "<city:$cities>" => '/deals/frontend/catalog/index',
			'/admin/deals/params'             => '/deals/backend/dealsParams/index',
			'/admin/deals/paramstypes'        => '/deals/backend/dealsParamsTypes/index',
			'/admin/deals/categoriesstatuses' => '/deals/backend/dealsCategoriesStatuses/index',
			'/admin/deals/categories'         => '/deals/backend/dealsCategories/index',
			'/user/deals'                     => '/deals/user/index',
            '' => 'deals/frontend/catalog/index',
        );
	}
}
