<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 18.01.2015
 */

class DefaultController extends BackendController{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'

        $sizeOfUsers = User::model()->count();
        $sizeOfDeals = Deals::model()->count();
        $sizeOfNotPublishedDeals = Deals::model()->countByAttributes(array('status_id' => 2));
        $sizeOfModeratedDeals = Deals::model()->countByAttributes(array('status_id' => 3));


        // Последний день, неделя, месяц
        $criteria = new CDbCriteria();
        $criteria->condition = 'create_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
        $sizeOfLastMonthNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'created_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))';
        $sizeOfLastMonthNewDeals = Deals::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'create_at >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
        $sizeOfLastWeekNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'created_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 WEEK))';
        $sizeOfLastWeekNewDeals = Deals::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'create_at >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
        $sizeOfLastDayNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'created_date >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL 1 DAY))';
        $sizeOfLastDayNewDeals = Deals::model()->count($criteria);


        // Текущие день, неделя, месяц
        $criteria = new CDbCriteria();
        $criteria->condition = 'MONTH(`create_at`) = MONTH(NOW()) AND YEAR(`create_at`) = YEAR(NOW())';
        $sizeOfCurrentMonthNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'MONTH(FROM_UNIXTIME(`created_date`)) = MONTH(NOW()) AND YEAR(FROM_UNIXTIME(`created_date`)) = YEAR(NOW())';
        $sizeOfCurrentMonthNewDeals = Deals::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'WEEK(`create_at`) = WEEK(NOW()) AND YEAR(`create_at`) = YEAR(NOW())';
        $sizeOfCurrentWeekNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'WEEK(FROM_UNIXTIME(`created_date`)) = WEEK(NOW()) AND MONTH(FROM_UNIXTIME(`created_date`)) = MONTH(NOW()) AND YEAR(FROM_UNIXTIME(`created_date`)) = YEAR(NOW())';
        $sizeOfCurrentWeekNewDeals = Deals::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'DAY(`create_at`) = DAY(NOW()) AND YEAR(`create_at`) = YEAR(NOW())';
        $sizeOfCurrentDayNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->condition = 'DAY(FROM_UNIXTIME(`created_date`)) = DAY(NOW()) AND MONTH(FROM_UNIXTIME(`created_date`)) = MONTH(NOW()) AND YEAR(FROM_UNIXTIME(`created_date`)) = YEAR(NOW())';
        $sizeOfCurrentDayNewDeals = Deals::model()->count($criteria);
        unset($criteria);

        // Статистика за вчера
        $criteria = new CDbCriteria();
        $criteria->condition = 'DAY(`create_at`) = DAY(NOW() - INTERVAL 1 DAY) AND YEAR(`create_at`) = YEAR(NOW())';
        $sizeOfYesterdayNewUsers = User::model()->count($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        //$now00 = strtotime(date("Y-m-d\T00:00:00\Z", time()));
        //$yesterday00 = strtotime(date("Y-m-d\T00:00:00\Z", time() - 24*60*60));
        $criteria->condition = 'DAY(FROM_UNIXTIME(`created_date`)) = DAY(NOW() - INTERVAL 1 DAY) AND MONTH(FROM_UNIXTIME(`created_date`)) = MONTH(NOW()) AND YEAR(FROM_UNIXTIME(`created_date`)) = YEAR(NOW()) AND t.user_id NOT IN('.Yii::app()->config->get('DEALS_MODULE.HIDDEN_USERS').')';
        //$criteria->addBetweenCondition('created_date',$yesterday00,$now00);
        $sizeOfYesterdayNewDeals = Deals::model()->count($criteria);
        unset($criteria);

        //по городам
        $cities = Cities::model()->findAll();

        $this->render(
            'index',
            array(
                'sizeOfUsers' => $sizeOfUsers,
                'sizeOfDeals' => $sizeOfDeals,
                'sizeOfNotPublishedDeals' => $sizeOfNotPublishedDeals,
                'sizeOfModeratedDeals' => $sizeOfModeratedDeals,
                'sizeOfLastMonthNewUsers' => $sizeOfLastMonthNewUsers,
                'sizeOfLastMonthNewDeals' => $sizeOfLastMonthNewDeals,
                'sizeOfLastWeekNewUsers' => $sizeOfLastWeekNewUsers,
                'sizeOfLastWeekNewDeals' => $sizeOfLastWeekNewDeals,
                'sizeOfLastDayNewUsers' => $sizeOfLastDayNewUsers,
                'sizeOfLastDayNewDeals' => $sizeOfLastDayNewDeals,
                'sizeOfCurrentMonthNewUsers' => $sizeOfCurrentMonthNewUsers,
                'sizeOfCurrentMonthNewDeals' => $sizeOfCurrentMonthNewDeals,
                'sizeOfCurrentWeekNewUsers' => $sizeOfCurrentWeekNewUsers,
                'sizeOfCurrentWeekNewDeals' => $sizeOfCurrentWeekNewDeals,
                'sizeOfCurrentDayNewUsers' => $sizeOfCurrentDayNewUsers,
                'sizeOfCurrentDayNewDeals' => $sizeOfCurrentDayNewDeals,
                'sizeOfYesterdayNewUsers' => $sizeOfYesterdayNewUsers,
                'sizeOfYesterdayNewDeals' => $sizeOfYesterdayNewDeals,
                'cities' => $cities
            )
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}