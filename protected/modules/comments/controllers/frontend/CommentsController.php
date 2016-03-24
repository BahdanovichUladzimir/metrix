<?php

/**
 * Class CommentsController
 * @var $user User
 */
class CommentsController extends FrontendController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
     * @var $user User
     * @var $profile Profile
	 */
	public function actionCreate()
	{
        $user = Yii::app()->user;
        $rUser = User::model()->findByPk($user->getId());
        $model=new Comments;
        $model->user_id = $user->getId();

		$this->performAjaxValidation($model);

		if(isset($_POST['Comments']))
		{
            $model->setScenario('submit');
			$model->attributes=$_POST['Comments'];
            $model->approve = 0;
		}
        if(Yii::app()->request->isAjaxRequest)
        {
            if($model->validate())
            {
                if($model->save())
                {
                    Yii::app()->clientScript->scriptMap = array(
                        'jquery.yiiactiveform.js' => false,
                        'jquery.js' => false,
                        'jquery.min.js' => false,
                    );
                    $data = array(
                        'html' => $this->renderPartial('comments.widgets.comments.views._comment', array('comment' => $model, 'user' => $user, 'rUser' => $rUser),true, true),
                        'status' => "success",
                        'message' => Yii::t("commentsModule","Comment was adding successfully."),
                    );
                }
                else
                {
                    $data = array(
                        'status' => 'error',
                        'message' => Yii::t("commentsModule",'When saving a comment error occurred.')
                    );
                }
                echo CJSON::encode($data);
                unset($data);
                Yii::app()->end();
            }
            else
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
        }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
        $user = Yii::app()->user;
        $rUser = User::model()->findByPk($user->getId());

        if($user->getId() != $model->user_id)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                Yii::app()->clientScript->scriptMap = array(
                    'jquery.yiiactiveform.js' => false,
                    'jquery.js' => false
                );
                $data = array(
                    'status' => 'error',
                    'message' => Yii::t("commentsModule",'Permissions error. Access denied.')
                );
                echo CJSON::encode($data);
                unset($data);
            }
        }

        if(isset($_POST['ajax']) && $_POST['ajax']==='comment_edit_form_'.$id)
        {
            $model->setScenario('validate');
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Comments']))
        {
            $model->setScenario('submit');
            $model->description = $_POST['Comments']['description'];
            if(Yii::app()->request->isAjaxRequest)
            {
                if($model->validate())
                {
                    if($model->save())
                    {
                        Yii::app()->clientScript->scriptMap = array(
                            'jquery.yiiactiveform.js' => false,
                            'jquery.js' => false
                        );
                        $data = array(
                            'html' => $this->renderPartial('modules.comments.widgets.comments.views._comment', array('comment' => $model, 'user' => $user, 'rUser' => $rUser),true,false),
                            'status' => "success",
                            'message' => Yii::t("commentsModule","Comment was saving successfully."),
                        );
                    }
                    else
                    {
                        $data = array(
                            'status' => 'error',
                            'message' => Yii::t("commentsModule",'When saving a comment error occurred.')
                        );
                    }
                    echo CJSON::encode($data);
                    unset($data);
                    Yii::app()->end();

                }
                else
                {
                    echo CActiveForm::validate($model);
                }
                Yii::app()->end();
            }
        }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $model = $this->loadModel($id);
        $user = Yii::app()->user;

        if($user->getId() != $model->user_id)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                $data = array(
                    'status' => 'error',
                    'message' => Yii::t("commentsModule",'Permissions error. Access denied.')
                );
                echo CJSON::encode($data);
                unset($data);
            }
        }
        if(Yii::app()->request->isAjaxRequest)
        {
            if($model->delete())
            {
                $data = array(
                    'message' => Yii::t("commentsModule",'Comment was deleted successfully.'),
                    'status' => "success"
                );
            }
            else
            {
                $data = array(
                    'status' => 'error',
                    'message' => Yii::t("commentsModule",'When deleting a comment error occurred.')
                );
            }
            echo CJSON::encode($data);
            unset($data);
            Yii::app()->end();
        }
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Comments the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Comments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,Yii::t("core",'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Comments $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='comments-form')
		{
            $model->setScenario('validate');
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
