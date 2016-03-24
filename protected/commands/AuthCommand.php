<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 17.05.2015
 */

class AuthCommand extends CConsoleCommand{


    /**
     * @var RDbAuthManager
     */
    public $auth;

    private static $_users = array();
    private static $_userRoles = array();

    public function actionReinstall(){
        $this->auth = Yii::app()->authManager;

        self::$_users = User::model()->findAll();
        foreach(self::$_users as $user){
            $userRoles = $this->auth->getRoles($user->id);
            self::$_userRoles[$user->id] = $userRoles;
        }
        if($this->actionClearAll()){
            $this->actionCreateAuthAll();
        }
    }

    public function actionClearAll(){
        /**
         * @var $auth RDbAuthManager
         */
        $this->auth->clearAll();
        return true;
    }

    public function actionCreateAuthAll(){
        $sql = "
        INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
            ('Admin', 2, 'Администратор', NULL, 'N;'),
            ('Authenticated', 2, 'Зарегистрированный пользователь', NULL, 'N;'),
            ('Guest', 2, 'Гость', NULL, 'N;');

        ";
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $command->execute();
        $command->reset();


        $this->_createTask('Admin.AppCategories.*');
        $this->_createTask('Admin.Cities.*');
        $this->_createTask('Admin.Cleaning.*');
        $this->_createTask('Admin.Config.*');
        $this->_createTask('Admin.Countries.*');
        $this->_createTask('Admin.Currencies.*');
        $this->_createTask('Admin.Default.*');
        $this->_createTask('Admin.ListItems.*');
        $this->_createTask('Admin.Lists.*');
        $this->_createTask('Admin.My.*');
        $this->_createTask('Admin.Underground.*');
        $this->_createTask('Cms.Block.*');
        $this->_createTask('Cms.Language.*');
        $this->_createTask('Cms.Page.*');
        $this->_createTask('Cms.Backend.Dictionary.*');
        $this->_createTask('Cms.Frontend.Dictionary.*');
        $this->_createTask('Comments.Backend.Comments.*');
        $this->_createTask('Comments.Frontend.Comments.*');
        $this->_createTask('Deals.Backend.Deals.*');
        $this->_createTask('Deals.Backend.DealsCategories.*');
        $this->_createTask('Deals.Backend.DealsCategoriesRatings.*');
        $this->_createTask('Deals.Backend.DealsCategoriesStatuses.*');
        $this->_createTask('Deals.Backend.DealsImages.*');
        $this->_createTask('Deals.Backend.DealsLinks.*');
        $this->_createTask('Deals.Backend.DealsParams.*');
        $this->_createTask('Deals.Backend.DealsParamsTypes.*');
        $this->_createTask('Deals.Backend.DealsStatistics.*');
        $this->_createTask('Deals.Backend.DealsStatuses.*');
        $this->_createTask('Deals.Backend.DealsVideos.*');
        $this->_createTask('Deals.Backend.Ratings.*');
        $this->_createTask('Deals.Frontend.Catalog.*');
        $this->_createTask('Deals.Frontend.Search.*');
        $this->_createTask('Deals.User.DealLinks.*');
        $this->_createTask('Deals.User.DealsStatistics.*');
        $this->_createTask('Deals.User.Favorites.*');
        $this->_createTask('Deals.User.UserDeals.*');
        $this->_createTask('Deals.User.Calendar.*');
        $this->_createTask('Email.Default.*');
        $this->_createTask('Feedback.Backend.Feedback.*');
        $this->_createTask('Feedback.Backend.FeedbackCategories.*');
        $this->_createTask('Feedback.Backend.FeedbackCategoriesStatuses.*');
        $this->_createTask('Feedback.Backend.FeedbackQuestions.*');
        $this->_createTask('Feedback.Backend.FeedbackQuestionsStatuses.*');
        $this->_createTask('Feedback.Backend.FeedbackStatuses.*');
        $this->_createTask('Feedback.Feedback.*');
        $this->_createTask('Messages.Backend.Dialogues.*');
        $this->_createTask('Messages.Backend.UserMessages.*');
        $this->_createTask('Messages.User.Dialogues.*');
        $this->_createTask('Messages.User.UserMessages.*');
        $this->_createTask('Payment.Backend.Payments.*');
        $this->_createTask('Payment.User.Payments.*');
        $this->_createTask('Payment.User.WebMoney.*');
        $this->_createTask('Translate.Translate.*');
        $this->_createTask('Translate.Backend.MessageSource.*');
        $this->_createTask('User.Activation.*');
        $this->_createTask('User.Backend.Default.*');
        $this->_createTask('User.Default.*');
        $this->_createTask('User.Gmail.*');
        $this->_createTask('User.Login.*');
        $this->_createTask('User.Logout.*');
        $this->_createTask('User.Profile.*');
        $this->_createTask('User.Recovery.*');
        $this->_createTask('User.Registration.*');
        $this->_createTask('User.User.*');
        $this->_createTask('User.Agreement.*');
        $this->_createTask('Yiiseo.DealsCategoriesSeo.*');
        $this->_createTask('Yiiseo.Default.*');
        $this->_createTask('Yiiseo.Seo.*');
        $this->_createTask('Site.*');
        $this->_createTask('Robots.*');
        $this->_createTask('Sitemap.*');
        $this->_createTask('Events.*');
        $this->_createTask('Events.Backend.Events.*');
        $this->_createTask('Events.User.Events.*');
        $this->_createTask('Events.User.Alcohol.*');
        $this->_createTask('Events.User.EventsGuests.*');
        $this->_createTask('Events.User.EventsDoings.*');
        $this->_createTask('Events.User.DailySchedules.*');
        $this->_createTask('Events.User.DailySchedulesEvents.*');
        $this->_createTask('Events.Backend.EventsGuests.*');
        $this->_createTask('Events.Backend.Events.InvitedUsers.*');
        $this->_createTask('Banners.*');
        $this->_createTask('Banners.User.Banners.*');

        $this->_createOperation('Deals.Frontend.Catalog.Index');
        $this->_createOperation('Deals.Frontend.Catalog.Deal');
        $this->_createOperation('Deals.Frontend.Catalog.SetDealRating');
        $this->_createOperation('Deals.Frontend.Catalog.GetTotalDealRating');
        $this->_createOperation('Deals.Frontend.Catalog.ProofOfAge');
        $this->_createOperation('Deals.Frontend.Catalog.ShowPhone');
        $this->_createOperation('Deals.Frontend.Catalog.Calendar');
        $this->_createOperation('Deals.Frontend.Catalog.GetDealContacts');
        $this->_createOperation('Deals.Frontend.Catalog.SetContactsQuality');
        $this->_createOperation('Deals.User.UserDeals.AddToFavorites');
        $this->_createOperation('Deals.User.UserDeals.DeleteFromFavorites');
        $this->_createOperation('Site.Articles');
        $this->_createOperation('Site.News');
        $this->_createOperation('Site.Error');
        $this->_createOperation('Site.InviteCodeEvent');
        $this->_createOperation('Site.Unsubscribe');
        $this->_createOperation('User.Profile.PublicProfile');
        $this->_createOperation('User.Agreement.Agreement');
        $this->_createOperation('Robots.Robots');
        $this->_createOperation('Events.User.Events.View');
        $this->_createOperation('Events.User.Events.Login');
        $this->_createOperation('User.Registration.Authorization');
        $this->_createOperation('User.Registration.Captcha');
        $this->_createOperation('User.Registration.SetInviteCode');
        $this->_createOperation('Payment.User.WebMoney.Result');
        $this->_createOperation('Payment.User.WebMoney.Success');
        $this->_createOperation('Payment.User.WebMoney.Fail');




        $this->_addItemChild("Admin",'Admin.AppCategories.*');
        $this->_addItemChild("Admin",'Admin.Cities.*');
        $this->_addItemChild("Admin",'Admin.Cleaning.*');
        $this->_addItemChild("Admin",'Admin.Config.*');
        $this->_addItemChild("Admin",'Admin.Countries.*');
        $this->_addItemChild("Admin",'Admin.Currencies.*');
        $this->_addItemChild("Admin",'Admin.Default.*');
        $this->_addItemChild("Admin",'Admin.ListItems.*');
        $this->_addItemChild("Admin",'Admin.Lists.*');
        $this->_addItemChild("Admin",'Admin.My.*');
        $this->_addItemChild("Admin",'Admin.Underground.*');
        $this->_addItemChild("Admin",'Cms.Block.*');
        $this->_addItemChild("Admin",'Cms.Language.*');
        $this->_addItemChild("Admin",'Cms.Page.*');
        $this->_addItemChild("Admin",'Cms.Frontend.Dictionary.*');
        $this->_addItemChild("Admin",'Cms.Backend.Dictionary.*');
        $this->_addItemChild("Admin",'Comments.Backend.Comments.*');
        $this->_addItemChild("Admin",'Comments.Frontend.Comments.*');
        $this->_addItemChild("Admin",'Deals.Backend.Deals.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsCategories.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsCategoriesRatings.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsCategoriesStatuses.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsImages.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsLinks.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsParams.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsParamsTypes.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsStatistics.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsStatuses.*');
        $this->_addItemChild("Admin",'Deals.Backend.DealsVideos.*');
        $this->_addItemChild("Admin",'Deals.Backend.Ratings.*');
        $this->_addItemChild("Admin",'Deals.Frontend.Catalog.*');
        $this->_addItemChild("Admin",'Deals.Frontend.Search.*');
        $this->_addItemChild("Admin",'Deals.User.DealLinks.*');
        $this->_addItemChild("Admin",'Deals.User.DealsStatistics.*');
        $this->_addItemChild("Admin",'Deals.User.Favorites.*');
        $this->_addItemChild("Admin",'Deals.User.UserDeals.*');
        $this->_addItemChild("Admin",'Deals.User.Calendar.*');
        $this->_addItemChild("Admin",'Email.Default.*');
        $this->_addItemChild("Admin",'Feedback.Backend.Feedback.*');
        $this->_addItemChild("Admin",'Feedback.Backend.FeedbackCategories.*');
        $this->_addItemChild("Admin",'Feedback.Backend.FeedbackCategoriesStatuses.*');
        $this->_addItemChild("Admin",'Feedback.Backend.FeedbackQuestions.*');
        $this->_addItemChild("Admin",'Feedback.Backend.FeedbackQuestionsStatuses.*');
        $this->_addItemChild("Admin",'Feedback.Backend.FeedbackStatuses.*');
        $this->_addItemChild("Admin",'Feedback.Feedback.*');
        $this->_addItemChild("Admin",'Messages.Backend.Dialogues.*');
        $this->_addItemChild("Admin",'Messages.Backend.UserMessages.*');
        $this->_addItemChild("Admin",'Messages.User.Dialogues.*');
        $this->_addItemChild("Admin",'Messages.User.UserMessages.*');
        $this->_addItemChild("Admin",'Payment.Backend.Payments.*');
        $this->_addItemChild("Admin",'Payment.User.Payments.*');
        $this->_addItemChild("Admin",'Payment.User.WebMoney.*');
        $this->_addItemChild("Admin",'Translate.Translate.*');
        $this->_addItemChild("Admin",'Translate.Backend.MessageSource.*');
        $this->_addItemChild("Admin",'User.Activation.*');
        $this->_addItemChild("Admin",'User.Backend.Default.*');
        $this->_addItemChild("Admin",'User.Default.*');
        $this->_addItemChild("Admin",'User.Gmail.*');
        $this->_addItemChild("Admin",'User.Login.*');
        $this->_addItemChild("Admin",'User.Logout.*');
        $this->_addItemChild("Admin",'User.Profile.*');
        $this->_addItemChild("Admin",'User.Recovery.*');
        $this->_addItemChild("Admin",'User.Registration.*');
        $this->_addItemChild("Admin",'User.User.*');
        $this->_addItemChild("Admin",'User.Agreement.*');
        $this->_addItemChild("Admin",'Yiiseo.DealsCategoriesSeo.*');
        $this->_addItemChild("Admin",'Yiiseo.Default.*');
        $this->_addItemChild("Admin",'Yiiseo.Seo.*');
        $this->_addItemChild("Admin",'Site.*');
        $this->_addItemChild("Admin",'Robots.*');
        $this->_addItemChild("Admin",'Sitemap.*');
        $this->_addItemChild("Admin",'Events.*');
        $this->_addItemChild("Admin",'Banners.*');


        $this->_addItemChild("Authenticated",'Comments.Frontend.Comments.*');
        $this->_addItemChild("Authenticated",'Deals.Frontend.Catalog.*');
        $this->_addItemChild("Authenticated",'Deals.Frontend.Search.*');
        $this->_addItemChild("Authenticated",'Deals.User.DealLinks.*');
        $this->_addItemChild("Authenticated",'Deals.User.DealsStatistics.*');
        $this->_addItemChild("Authenticated",'Deals.User.Favorites.*');
        $this->_addItemChild("Authenticated",'Deals.User.UserDeals.*');
        $this->_addItemChild("Authenticated",'Deals.User.Calendar.*');
        $this->_addItemChild("Authenticated",'Feedback.Feedback.*');
        $this->_addItemChild("Authenticated",'Messages.User.Dialogues.*');
        $this->_addItemChild("Authenticated",'Messages.User.UserMessages.*');
        $this->_addItemChild("Authenticated",'Payment.User.Payments.*');
        $this->_addItemChild("Authenticated",'Payment.User.WebMoney.*');
        $this->_addItemChild("Authenticated",'User.Activation.*');
        $this->_addItemChild("Authenticated",'User.Default.*');
        $this->_addItemChild("Authenticated",'User.Gmail.*');
        $this->_addItemChild("Authenticated",'User.Login.*');
        $this->_addItemChild("Authenticated",'User.Logout.*');
        $this->_addItemChild("Authenticated",'User.Profile.*');
        $this->_addItemChild("Authenticated",'User.Recovery.*');
        $this->_addItemChild("Authenticated",'User.Registration.*');
        $this->_addItemChild("Authenticated",'User.User.*');
        $this->_addItemChild("Authenticated",'User.Agreement.Agreement');
        $this->_addItemChild("Authenticated",'Site.Articles');
        $this->_addItemChild("Authenticated",'Site.News');
        $this->_addItemChild("Authenticated",'Site.InviteCodeEvent');
        $this->_addItemChild("Authenticated",'Site.Unsubscribe');
        $this->_addItemChild("Authenticated",'Robots.Robots');
        $this->_addItemChild("Authenticated",'Sitemap.*');
        $this->_addItemChild("Authenticated",'Events.User.Events.*');
        $this->_addItemChild("Authenticated",'Events.User.Alcohol.*');
        $this->_addItemChild("Authenticated",'Events.User.EventsDoings.*');
        $this->_addItemChild("Authenticated",'Events.User.EventsGuests.*');
        $this->_addItemChild("Authenticated",'Events.User.DailySchedules.*');
        $this->_addItemChild("Authenticated",'Events.User.DailySchedulesEvents.*');
        $this->_addItemChild("Authenticated",'Banners.User.Banners.*');
        $this->_addItemChild("Authenticated",'Cms.Frontend.Dictionary.*');


        //$this->_addItemChild("Guest",'Deals.Frontend.Catalog.*');
        $this->_addItemChild("Guest",'Feedback.Feedback.*');
        $this->_addItemChild("Guest",'User.Gmail.*');
        $this->_addItemChild("Guest",'User.Login.*');
        $this->_addItemChild("Guest",'User.Logout.*');
        $this->_addItemChild("Guest",'User.Recovery.*');
        $this->_addItemChild("Guest",'User.Registration.Authorization');
        $this->_addItemChild("Guest",'User.Registration.Captcha');
        $this->_addItemChild("Guest",'User.Profile.PublicProfile');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.Index');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.Deal');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.GetTotalDealRating');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.ProofOfAge');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.ShowPhone');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.Calendar');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.GetDealContacts');
        $this->_addItemChild("Guest",'Deals.Frontend.Catalog.SetContactsQuality');
        $this->_addItemChild("Guest",'Deals.Frontend.Search.*');
        $this->_addItemChild("Guest",'Deals.User.UserDeals.AddToFavorites');
        $this->_addItemChild("Guest",'Deals.User.UserDeals.DeleteFromFavorites');
        $this->_addItemChild("Guest",'Deals.User.Favorites.*');
        $this->_addItemChild("Guest",'Site.Articles');
        $this->_addItemChild("Guest",'Site.News');
        $this->_addItemChild("Guest",'Site.Error');
        $this->_addItemChild("Guest",'Site.Unsubscribe');
        $this->_addItemChild("Guest",'Robots.Robots');
        $this->_addItemChild("Guest",'Sitemap.*');
        $this->_addItemChild("Guest",'Events.User.Events.View');
        $this->_addItemChild("Guest",'Events.User.Events.Login');
        $this->_addItemChild("Guest",'Payment.User.WebMoney.Result');
        $this->_addItemChild("Guest",'Payment.User.WebMoney.Success');
        $this->_addItemChild("Guest",'Payment.User.WebMoney.Fail');
        $this->_addItemChild("Guest",'Cms.Frontend.Dictionary.*');

        $this->_assignUsers();

        echo "Command \"auth reinstall\" was finished.\r\n";
    }

    private function _createTask($task){
        $this->auth->createTask($task);
        echo "Task \"".$task."\" was created successfully.\r\n";
    }

    private function _createOperation($operation){
        $this->auth->createOperation($operation);
        echo "Operation \"".$operation."\" was created successfully.\r\n";
    }

    private function _addItemChild($parent,$child){
        $this->auth->addItemChild($parent,$child);
        echo "Child \"".$child."\" was added to parent \"".$parent."\" successfully.\r\n";
    }

    private function _assignUsers(){
        foreach(self::$_users as $user){
            echo $user->id."\r\n";
            $roles = self::$_userRoles[$user->id];
            //var_dump($roles);
            foreach($roles as $role){
                $this->_assign($role->name,$user->id);
            }
        }
    }
    private function _assign($role,$userId){
        $sql = "
            INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
            ('".$role."', '".$userId."', NULL, 'N;');
        ";
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $command->execute();
        $command->reset();
        echo "User ".$userId." was assigned to role \"".$role."\" successfully.\r\n";

    }

    public function actionAssignAuthenticatedRoleToAllUsers(){

        foreach(User::model()->findAll() as $user){
            $this->_assign("Authenticated",$user->id);
            echo $user->id."\r\n";
        }
    }
}