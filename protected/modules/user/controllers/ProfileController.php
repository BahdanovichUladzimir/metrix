<?php

class ProfileController extends UserFrontendController
{
	public $defaultAction = 'profile';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;


    /**
     * @param mixed $id
     */
    public function actionPublicProfile($id){
        $model = $this->loadUserById($id);
        $this->render('public_profile',array(
            'model'=>$model,
            'profile'=>$model->profile,
        ));
    }

    public function actionPrivateProfile(){
        $model = $this->loadUser();
        Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/jquery.fancybox.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.fancybox.pack.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-buttons.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-media.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fancyBox/source/helpers/jquery.fancybox-thumbs.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-cookie/src/jquery.cookie.js');

        $this->render('private_profile',array(
            'model'=>$model,
            'profile'=>$model->profile,
        ));
    }


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEditMainSettings()
	{

		$model = $this->loadUser();
		$profile=$model->profile;
        $profile->setScenario('updateMainSettings');


        // ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
                Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',Yii::t('userModule',"Changes is saved."));
				$this->redirect(array('/user/profile/editContactsSettings'));
			} else $profile->validate();
		}

		$this->render('main_settings',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

    /**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEditContactsSettings()
	{

		$model = $this->loadUser();
		$profile=$model->profile;
        $profile->setScenario('updateContacts');


        // ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}

		if(isset($_POST['Profile']))
		{
			$profile->attributes=$_POST['Profile'];

			if($profile->validate()) {
				$profile->save();
                Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',Yii::t('userModule',"Changes is saved."));
				$this->redirect(array('/user/profile/privateProfile'));
			} else $profile->validate();
		}

		$this->render('contacts_settings',array(
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',Yii::t('userModule',"New password is saved."));
						$this->redirect(array("privateProfile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

    public function actionRemoveAvatar(){
        $model = $this->loadUser();
        $profile=$model->profile;
        if(file_exists($profile->originalImagePath)){
            $profile->avatar = '';
            if($profile->save() && unlink($profile->originalImagePath)){
                unlink($profile->largeThumbPath);
                unlink($profile->mediumThumbPath);
                unlink($profile->smallThumbPath);
                rmdir($profile->imagesDirPath);
                echo CJSON::encode(array(
                    'status' => "success",
                    'message' => Yii::t('userModule',"Avatar was deleted successfully."),
                    'default_image_url' => $profile->getMediumThumbUrl()
                ));
            }
            else{
                echo CJSON::encode(array(
                    'status' => "error",
                    'message' => Yii::t('userModule',"When delete avatar error occurred.")
                ));
            }
        }
        else{
            echo CJSON::encode(array(
                'status' => "error",
                'message' => Yii::t('userModule',"Avatar file not found.")
            ));
        }
    }

    private function _removeAvatar(){
        $model = $this->loadUser();
        $profile=$model->profile;
        if(file_exists($profile->originalImagePath)){
            $profile->avatar = '';
            if($profile->save() && unlink($profile->originalImagePath)){
                unlink($profile->largeThumbPath);
                unlink($profile->mediumThumbPath);
                unlink($profile->smallThumbPath);
                rmdir($profile->imagesDirPath);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

	public function actionUploadAvatar(){
		$model = $this->loadUser();
		$profile=$model->profile;
		$profile->setScenario('updateMainSettings');
        if(isset($_FILES['file'])){
            $file = $_FILES['file'];
            $tmp_name = $file['tmp_name'];
            $name = $file['name'];


            $this->_removeAvatar(); // старый файл удалим, потому что загружаем новый
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $fileName = md5(microtime().$profile->user_id).".".$ext;
            $imagesDirPath = $profile->getAvatarSavePath();
            if($profile->createSubFolder($imagesDirPath)){
                $originalImagePath = $imagesDirPath.$fileName;
                // Upload file
                if(move_uploaded_file($tmp_name, $originalImagePath)){
                    $profile->updateByPk($profile->user_id, array('avatar'=>$fileName));
                    chmod($originalImagePath,0777);
                    $returnImg = $profile->imagesDirUrl.$fileName;
                    $largeThumbPath = $imagesDirPath.Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_PREFIX").$fileName;
                    $mediumThumbPath = $imagesDirPath.Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX").$fileName;
                    $smallThumbPath = $imagesDirPath.Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_PREFIX").$fileName;

                    // Загружаем оригинальный файл, делаем тумбы и сохраняем их
                    $image = Yii::app()->image->load($originalImagePath);
                    $image->resize(Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_WIDTH"), Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_HEIGHT"));
                    $image->save($largeThumbPath);
                    chmod($largeThumbPath,0777);
                    $image->resize(Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_WIDTH"), Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_HEIGHT"), Image::WIDTH);
                    if($image->save($mediumThumbPath)&& chmod($mediumThumbPath,0777)){
                        $returnImg = $profile->imagesDirUrl.Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX").$fileName;
                    };
                    $image->resize(Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_WIDTH"),Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_HEIGHT"));
                    $image->save($smallThumbPath);
                    chmod($smallThumbPath,0777);
                    echo CJSON::encode(array(
                        'status' => "success",
                        'image' => $returnImg,
                    ));

                }

            };

        }

	}

    /**
     * @return User|null
     */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}

    /**
     * @param $id
     * @return User
     * @throws CHttpException
     */
    public function loadUserById($id){

        $user = User::model()->findByPk($id);
        if(is_null($user)){
            throw new CHttpException(403,'User not found!');
        }
        return $user;
    }
}