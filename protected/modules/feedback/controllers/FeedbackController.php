<?php

class FeedbackController extends FrontendController
{

    public function actions(){
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate(){
        $user_id = Yii::app()->user->getId();
        $showFormLabel = false;
        if(is_null($user_id)){
            $model=new Feedback('guestCreate');
            $user = NULL;
        }
        else{
            $model=new Feedback('authUserCreate');
            /**
             * @var $user User
             */
            $user = User::model()->findByPk($user_id);
            $model->setAttributes(array(
                'user_id' => $user_id,
                'user_name' => $user->username,
                'user_email' => $user->email,
            ));
        }

        $this->performAjaxValidation($model);

        if(isset($_POST['Feedback'])){
            $model->attributes=$_POST['Feedback'];
            $model->status_id=2;

            /*echo '<pre>';
                 var_dump($model->validate());
                 var_dump($model->getErrors());
            echo '</pre>';
            exit();*/
            if($model->save()){
                Yii::app()->user->setFlash('feedbackSuccess', Yii::t("feedbackModule", "Your message was sent successfully!"));
                $showFormLabel = false;
            }
            else {
                Yii::app()->user->setFlash('feedbackError', Yii::t("feedbackModule", "When sent your message error occurred!"));
                $showFormLabel = true;
            }
        }

        $this->render('create',array(
            'model'=>$model,
            'categoriesList' => FeedbackCategories::getListData(),
            'user' => $user,
            'showFormLabel' => $showFormLabel
        ));
    }

    public function actionGetCurrentQuestions(){
        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['category_id'])){
                $criteria = new CDbCriteria();
                $criteria->condition = "category_id=:category_id AND status_id=:status_id";
                $criteria->params = array(':category_id' => (int)$_POST['category_id'], ':status_id' => 1);
                $questions= FeedbackQuestions::model()->findAll($criteria);
                $output = $this->renderPartial(
                    '_currentQuestions',
                    array(
                        'questions'=>$questions,
                    ),
                    true,
                    true
                );
                echo $output;
                Yii::app()->end();
            }
        }
    }


    /**
     * @param $id
     * @return static
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Feedback::model()->findByPk($id);
        if($model===null){
            throw new CHttpException(404,'The requested page does not exist.');
        }
        return $model;
    }

    /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
    protected function performAjaxValidation($model){
        if(isset($_POST['ajax']) && $_POST['ajax']==='feedback-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
