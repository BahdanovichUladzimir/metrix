<?php

class SiteController extends FrontendController
{
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
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest){
                echo "<pre>";
                var_dump($error['trace']);
                echo "</pre>";
                //echo $error['message'];
            }

			else{
                if(Yii::app()->getModule('user')->isAdmin()){
                    Config::var_dump($error['trace']);
                }
				$this->render('error', $error);
			}
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionNews(){
        $dataProvider = new CActiveDataProvider(
            'CmsPage',
            array(
                'criteria' => array(
                    'condition' => 'type=2 and published=1',
                    'order' => 'created desc',
                    ),
                'pagination' => array(
                    'pageSize' => 20,
                    ),
                )
        );
        $this->render(
            'stories',
            array(
                'dataProvider' => $dataProvider,
				'type'=>'Новости',
                'model' => new CmsPage()
            )
        );
    }
    public function actionArticles(){
        $dataProvider = new CActiveDataProvider(
            'CmsPage',
            array(
                'criteria' => array(
                    'condition' => 'type=0 and published=1',
                    'order' => 'created desc',
                ),
                'pagination' => array(
                    'pageSize' => 20,
                ),
            )
        );
        $this->render(
            'stories',
            array(
                'dataProvider' => $dataProvider,
				'type'=>'Статьи',
                'model' => new CmsPage()
            )
        );
    }

    private function _cmp($a, $b){
        return $a['allPoints'] - $b['allPoints'];
    }

	public function actionInviteCodeEvent(){

        $connection=Yii::app()->db; // так можно делать, если в конфигурации настроен компонент соединения "db"
        $sql = '
            SELECT
				u1.id userId,
				u1.username as userName,
   				(SELECT COUNT(*) FROM Deals d WHERE d.created_date>1451606400 AND d.user_id=u1.id AND d.approve=1 AND d.archive=0 AND d.status_id=1) AS dealsCount,
   				(SELECT COUNT(*) FROM Users u2 WHERE u1.invitekey=u2.invitecode AND u1.id<>u2.id) as invitedUsersCount,
   				(SELECT COUNT(*) FROM Deals d2 LEFT JOIN Users u3 ON d2.user_id=u3.id WHERE d2.created_date>1451606400 AND d2.approve=1 AND d2.archive=0 AND d2.status_id=1 AND u1.invitekey=u3.invitecode AND u1.id<>u3.id) AS invitedUsersDealsCount
			FROM Users u1
			WHERE u1.id NOT IN (1,35);
            ';
        $command=$connection->createCommand($sql);
		$rows=$command->queryAll();
        $users = array();
		foreach($rows as $row){
            if($row['dealsCount']>0 || $row['invitedUsersCount']>0 || $row['invitedUsersDealsCount']>0){
                $users[] = array(
                    'userId' => $row['userId'],
                    'userName' => $row['userName'],
                    'dealsCount' => $row['dealsCount'],
                    'invitedUsersCount' => $row['invitedUsersCount'],
                    'invitedUsersDealsCount' => $row['invitedUsersDealsCount'],
                    'pointsForAddedDeals' => $row['dealsCount']*1,
                    'pointsForInvitedUsersAddedDeals' => $row['invitedUsersDealsCount']*0.5,
                    'allPoints' => $row['dealsCount']*1+$row['invitedUsersDealsCount']*0.5,
                );
            }
        }
        usort($users, array($this, '_cmp'));
        $users = array_reverse($users);
        $this->render(
            'inviteCodeEvent',
            array(
                'users' => $users,
            )
        );
	}

	public function actionUnsubscribe($user_id, $activkey){
		$user = User::model()->findByPk($user_id);
        if(!is_null($user) && $user->activkey == $activkey){
            $user->setScenario('unsubscribe');
            $user->subscribe = "0";
            if($user->save()){
                $message = Yii::t('userModule','You have successfully unsubscribed from the mailing list.');
            }
            else{
                $message = Yii::t('userModule','When performing this operation, an error occurred. Please try again later.');
            }
            $this->render('unsubscribe', array('message' => $message));
        }
        else{
            throw new CHttpException(404,Yii::t('core','Page not found'));
        }
	}

}