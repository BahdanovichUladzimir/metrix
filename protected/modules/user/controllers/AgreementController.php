<?php

class AgreementController extends FrontendController
{
	public $defaultAction = 'agreement';

	
	/**
	 * Activation user account
	 */
	public function actionAgreement(){
		$userModel=User::model()->findByPk(Yii::app()->user->getId());
		$userModel->setScenario('agreement');
		$model = $this->loadModel(1);
		$returnUrl = isset($_GET['returnUrl']) ? $_GET['returnUrl'] : Yii::app()->user->returnUrl;
		if ($model->hasContent()) {
			$this->title = $model->pageTitle;
			$this->breadcrumbs = $model->breadcrumbs;
		}

		if(isset($_POST['User']) && isset($_POST['User']['agreement'])){
			$userModel->agreement=$_POST['User']['agreement'];
			if($userModel->save()){
                if($userModel->agreement = '1'){
                    if (Yii::app()->user->returnUrl=='/index.php'){
                        $this->redirect(Yii::app()->controller->module->returnUrl);
                    }
                    else{
                        $this->redirect(isset($_POST['User']['returnUrl']) ? $_POST['User']['returnUrl'] : $returnUrl);
                    }
                }
			}
		}

		$this->render('agreement',array(
			'model'=>$model,
			'returnUrl' => $returnUrl,
            'userModel' => $userModel,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CmsPage the model
	 * @throws CHttpException if the node does not exist
	 */
	public function loadModel($id) {
		$model = CmsPage::model()->findByPk($id);

		if ($model === null)
			throw new CHttpException(404, Yii::t('CmsModule.core', 'The requested page does not exist.'));

		return $model;
	}

}