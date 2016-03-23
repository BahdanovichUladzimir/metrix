<?php

/**
 * This is the model class for table "Profiles".
 *
 * The followings are the available columns in table 'Profiles':
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $description
 * @property string $avatar
 * @property string $city_id
 * @property string $type
 * @property string $facebook
 * @property string $twitter
 * @property string $skype
 * @property string $linkedin
 * @property string $vimeo
 * @property string $vk
 * @property string $ok
 * @property string $youtube
 * @property string $instagram
 *
 * The followings are the available model relations:
 * @property Cities $city
 * @property User $user
 */
class Profile extends CActiveRecord
{
    //public $regMode = false;

    /*private $_model;
    private $_modelReg;
    private $_rules = array();*/

    public $file;

    public $largeThumbUrl = NULL;
    public $mediumThumbUrl = NULL;
    public $smallThumbUrl = NULL;
    public $largeThumbPath = NULL;
    public $mediumThumbPath = NULL;
    public $smallThumbPath = NULL;

    public $imagesDirPath = NULL;
    public $imagesDirUrl = NULL;
    public $originalImagePath = NULL;
    public $originalImageUrl = NULL;
    public $vk_avatar = NULL;
    public $fb_avatar = NULL;

    private $_savePathAlias = "webroot.uploads.user_avatars";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('description, avatar', 'required'),
			array('first_name, last_name, email, avatar', 'length', 'max'=>255, 'on'=>'updateMainSettings'),
			array('facebook, twitter, skype, linkedin, vimeo, vk, ok, youtube, instagram', 'length', 'max'=>255, 'on'=>'updateContacts'),
			array('facebook, twitter, linkedin, vimeo, vk, ok, youtube, instagram', 'url', 'on'=>'updateContacts'),
			array('facebook', 'url', 'pattern' => '/^(https?):\/\/(www\.)*facebook.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid facebook url'), 'on'=>'updateContacts'),
			array('twitter', 'url', 'pattern' => '/^(https?):\/\/(www\.)*twitter.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid twitter url'), 'on'=>'updateContacts'),
			array('linkedin', 'url', 'pattern' => '/^(https?):\/\/(www\.)*linkedin.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid linkedin url'), 'on'=>'updateContacts'),
			array('vimeo', 'url', 'pattern' => '/^(https?):\/\/(www\.)*vimeo.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid vimeo url'), 'on'=>'updateContacts'),
			array('vk', 'url', 'pattern' => '/^(https?):\/\/(www\.)*vk.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid vkontakte url'), 'on'=>'updateContacts, vkCreate'),
			array('ok', 'url', 'pattern' => '/^(https?):\/\/(www\.)*ok.ru\/*/', 'message'=>Yii::t('dealsModule','Enter a valid odnoklassniki url'), 'on'=>'updateContacts'),
			array('youtube', 'url', 'pattern' => '/^(https?):\/\/(www\.)*youtube.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid youtube url'), 'on'=>'updateContacts'),
			array('instagram', 'url', 'pattern' => '/^(https?):\/\/(www\.)*instagram.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid instagram url'), 'on'=>'updateContacts'),
			array('phone', 'length', 'max'=>50, 'on'=>'updateContacts'),
			array('type', 'length', 'max'=>50, 'on'=>'updateMainSettings'),
            array('email','email', 'on'=>'updateContacts'),
			array('description', 'length', 'max'=>1000, 'on'=>'updateMainSettings'),
			array('city_id', 'length', 'max'=>10, 'on'=>'updateMainSettings'),

            //admin
            array('first_name, last_name, email', 'length', 'max'=>255, 'on'=>'adminUpdate, adminCreate'),
            array('city_id', 'length', 'max'=>10, 'on'=>'adminUpdate, adminCreate'),
            array('type', 'length', 'max'=>50, 'on'=>'adminUpdate, adminCreate'),
            array('description', 'length', 'max'=>1000, 'on'=>'adminUpdate, adminCreate'),
            array('email', 'email', 'on'=>'adminUpdate, adminCreate'),
            array('facebook, twitter, skype, linkedin, vimeo, vk, ok, youtube, instagram', 'length', 'max'=>255, 'on'=>'adminUpdate, adminCreate'),
            array('facebook, twitter, linkedin, vimeo, vk, ok, youtube, instagram', 'url', 'on'=>'adminUpdate, adminCreate'),
            array('phone', 'length', 'max'=>50, 'on'=>'adminUpdate, adminCreate'),
            array('facebook', 'url', 'pattern' => '/^(https?):\/\/(www\.)*facebook.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid facebook url'), 'on'=>'adminUpdate, adminCreate'),
            array('twitter', 'url', 'pattern' => '/^(https?):\/\/(www\.)*twitter.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid twitter url'), 'on'=>'adminUpdate, adminCreate'),
            array('linkedin', 'url', 'pattern' => '/^(https?):\/\/(www\.)*linkedin.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid linkedin url'), 'on'=>'adminUpdate, adminCreate'),
            array('vimeo', 'url', 'pattern' => '/^(https?):\/\/(www\.)*vimeo.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid vimeo url'), 'on'=>'adminUpdate, adminCreate'),
            array('vk', 'url', 'pattern' => '/^(https?):\/\/(www\.)*vk.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid vkontakte url'), 'on'=>'adminUpdate, adminCreate'),
            array('ok', 'url', 'pattern' => '/^(https?):\/\/(www\.)*ok.ru\/*/', 'message'=>Yii::t('dealsModule','Enter a valid odnoklassniki url'), 'on'=>'adminUpdate, adminCreate'),
            array('youtube', 'url', 'pattern' => '/^(https?):\/\/(www\.)*youtube.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid youtube url'), 'on'=>'adminUpdate, adminCreate'),
            array('instagram', 'url', 'pattern' => '/^(https?):\/\/(www\.)*instagram.com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid instagram url'), 'on'=>'adminUpdate, adminCreate'),


            // vk auth
            array('vk, first_name, last_name', 'length', 'max'=>255, 'on'=>'vkCreate'),
			array('vk_avatar, vk', 'url', 'on'=>'vkCreate'),

            // fb auth
            array('facebook, first_name, last_name', 'length', 'max'=>255, 'on'=>'fbCreate'),
			array('fb_avatar, facebook', 'url', 'on'=>'fbCreate'),


			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, first_name, last_name, phone, email, description, avatar, city_id, type, facebook, twitter, skype, linkedin, vimeo, vk, ok, youtube, instagram', 'safe', 'on'=>'search'),
		);
	}

    public function behaviors(){
        return array(
            'uploadableVkAvatar'=>array(
                'avatarAttributeName' => 'vk_avatar',
                'fileNameAttributeName' => 'avatar',
                'idAttributeName' => 'user_id',
                'subFolderNameAttributeName' => 'user_id',
                //'isCreateSubfolder' => false,
                'class'=>'application.components.UploadableVkAvatarBehavior',
                'savePathAlias'=>'webroot.uploads.user_avatars',
                //'fileTypes'=>Yii::app()->config->get('USER_MODULE.AVATAR_ALLOWED_IMAGES_FILE_TYPES'),
                'largeThumbEmptyUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_EMPTY_URL"),
                'largeThumbEmptyPath' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_EMPTY_PATH"),
                'mediumThumbEmptyUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_EMPTY_URL"),
                'mediumThumbEmptyPath' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_EMPTY_PATH"),
                'smallThumbEmptyUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_EMPTY_URL"),
                'smallThumbEmptyPath' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_EMPTY_PATH"),
                'emptyImageUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_ORIGINAL_IMG_EMPTY_URL"),
                'emptyImagePath' => Yii::app()->config->get("USER_MODULE.AVATAR_ORIGINAL_IMG_EMPTY_PATH"),
                'largeThumbWidth' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_WIDTH"),
                'largeThumbHeight' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_HEIGHT"),
                'mediumThumbWidth' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_WIDTH"),
                'mediumThumbHeight' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_HEIGHT"),
                'smallThumbWidth' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_WIDTH"),
                'smallThumbHeight' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_HEIGHT"),
                'smallThumbPrefix' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_PREFIX"),
                'mediumThumbPrefix' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX"),
                'largeThumbPrefix' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_PREFIX"),
            ),
            'uploadableFbAvatar'=>array(
                'avatarAttributeName' => 'fb_avatar',
                'fileNameAttributeName' => 'avatar',
                'idAttributeName' => 'user_id',
                'subFolderNameAttributeName' => 'user_id',
                //'isCreateSubfolder' => false,
                'class'=>'application.components.UploadableFbAvatarBehavior',
                'savePathAlias'=>'webroot.uploads.user_avatars',
                //'fileTypes'=>Yii::app()->config->get('USER_MODULE.AVATAR_ALLOWED_IMAGES_FILE_TYPES'),
                'largeThumbEmptyUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_EMPTY_URL"),
                'largeThumbEmptyPath' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_EMPTY_PATH"),
                'mediumThumbEmptyUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_EMPTY_URL"),
                'mediumThumbEmptyPath' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_EMPTY_PATH"),
                'smallThumbEmptyUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_EMPTY_URL"),
                'smallThumbEmptyPath' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_EMPTY_PATH"),
                'emptyImageUrl' => Yii::app()->config->get("USER_MODULE.AVATAR_ORIGINAL_IMG_EMPTY_URL"),
                'emptyImagePath' => Yii::app()->config->get("USER_MODULE.AVATAR_ORIGINAL_IMG_EMPTY_PATH"),
                'largeThumbWidth' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_WIDTH"),
                'largeThumbHeight' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_HEIGHT"),
                'mediumThumbWidth' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_WIDTH"),
                'mediumThumbHeight' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_HEIGHT"),
                'smallThumbWidth' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_WIDTH"),
                'smallThumbHeight' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_HEIGHT"),
                'smallThumbPrefix' => Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_PREFIX"),
                'mediumThumbPrefix' => Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX"),
                'largeThumbPrefix' => Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_PREFIX"),
            ),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('userModule','User'),
			'first_name' => Yii::t('userModule','First Name'),
			'last_name' => Yii::t('userModule','Last Name'),
			'phone' => Yii::t('userModule','Phone'),
			'Public email' => Yii::t('userModule','Email'),
			'description' => Yii::t('userModule','About'),
			'avatar' => Yii::t('userModule','Avatar'),
			'city_id' => Yii::t('userModule','City'),
			'type' => Yii::t('userModule','Type'),
			'facebook' => Yii::t('userModule','Facebook'),
			'twitter' => Yii::t('userModule','Twitter'),
			'skype' => Yii::t('userModule','Skype'),
			'linkedin' => Yii::t('userModule','Linkedin'),
			'vimeo' => Yii::t('userModule','Vimeo'),
			'vk' => Yii::t('userModule','Vk'),
			'ok' => Yii::t('userModule','Ok'),
			'youtube' => Yii::t('userModule','Youtube'),
			'instagram' => Yii::t('userModule','Instagram'),
			'file' => Yii::t('userModule','Avatar'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('facebook',$this->facebook,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('linkedin',$this->linkedin,true);
		$criteria->compare('vimeo',$this->vimeo,true);
		$criteria->compare('vk',$this->vk,true);
		$criteria->compare('ok',$this->ok,true);
		$criteria->compare('youtube',$this->youtube,true);
		$criteria->compare('instagram',$this->instagram,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getUserTypes(){
        return array(
            'seller' => Yii::t("userModule",'Seller'),
            'buyer' => Yii::t("userModule",'Buyer'),
        );
    }

    protected function afterFind(){
        parent::afterFind();
        $this->imagesDirPath = realpath(Yii::app()->getBasePath()."/../uploads/user_avatars/").DIRECTORY_SEPARATOR.$this->user_id.DIRECTORY_SEPARATOR;
        $this->imagesDirUrl = Yii::app( )->getBaseUrl( )."/uploads/user_avatars/".$this->user_id."/";
        $this->largeThumbUrl = $this->imagesDirUrl.Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_PREFIX").$this->avatar;
        $this->mediumThumbUrl = $this->imagesDirUrl.Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX").$this->avatar;
        $this->smallThumbUrl = $this->imagesDirUrl.Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_PREFIX").$this->avatar;
        $this->largeThumbPath = $this->imagesDirPath.Yii::app()->config->get("USER_MODULE.AVATAR_LARGE_THUMB_PREFIX").$this->avatar;
        $this->mediumThumbPath = $this->imagesDirPath.Yii::app()->config->get("USER_MODULE.AVATAR_MEDIUM_THUMB_PREFIX").$this->avatar;
        $this->smallThumbPath = $this->imagesDirPath.Yii::app()->config->get("USER_MODULE.AVATAR_SMALL_THUMB_PREFIX").$this->avatar;
        $this->originalImagePath = $this->imagesDirPath.$this->avatar;
        $this->originalImageUrl = $this->imagesDirUrl.$this->avatar;

    }
    public function getLargeThumbUrl(){
        if(file_exists($this->largeThumbPath) && is_file($this->largeThumbPath)){
            return $this->largeThumbUrl;
        }
        else{
            return $this->largeThumbEmptyUrl;
        }
    }
    public function getMediumThumbUrl(){
        if(file_exists($this->mediumThumbPath) && is_file($this->mediumThumbPath)){
            return $this->mediumThumbUrl;
        }
        else{
            return $this->mediumThumbEmptyUrl;
        }

    }
    public function getSmallThumbUrl(){
        if(file_exists($this->smallThumbPath) && is_file($this->smallThumbPath)){
            return $this->smallThumbUrl;
        }
        else{
            return $this->smallThumbEmptyUrl;
        }

    }
    public function getImageUrl(){
        if(file_exists($this->originalImagePath) && is_file($this->originalImagePath)){
            return $this->originalImageUrl;
        }
        else{
            return $this->largeThumbEmptyUrl;
        }

    }

    public function getLinkedinLink(){
        if(strlen($this->linkedin)>0){
            return CHtml::link('',$this->linkedin,array('class' => 'linkedin', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getSkypeLink(){
        if(strlen($this->skype)>0){
            return CHtml::link('','skype:'.$this->skype."?chat",array('class' => 'skype', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getVimeoLink(){
        if(strlen($this->vimeo)>0){
            return CHtml::link('',$this->vimeo,array('class' => 'vimeo', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getTwitterLink(){
        if(strlen($this->twitter)>0){
            return CHtml::link('',$this->twitter,array('class' => 'twitter', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getFacebookLink(){
        if(strlen($this->facebook)>0){
            return CHtml::link('',$this->facebook,array('class' => 'facebook', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getVkLink(){
        if(strlen($this->vk)>0){
            return CHtml::link('',$this->vk,array('class' => 'vk', 'target' => '_blank'));
        }
        else{
            return false;
        }

    }
    public function getOkLink(){
        if(strlen($this->ok)>0){
            return CHtml::link('',$this->ok,array('class' => 'ok', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getYoutubeLink(){
        if(strlen($this->youtube)>0){
            return CHtml::link('',$this->youtube,array('class' => 'youtube', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }
    public function getInstagramLink(){
        if(strlen($this->instagram)>0){
            return CHtml::link('',$this->instagram,array('class' => 'instagram', 'target' => '_blank'));
        }
        else{
            return false;
        }
    }

    /**
     * Шорткат для Yii::getPathOfAlias($this->savePathAlias).DIRECTORY_SEPARATOR.
     * Возвращает путь к директории, в которой будут сохраняться файлы.
     * @return string путь к директории, в которой сохраняем файлы
     */
    public function getAvatarSavePath(){
        return Yii::getPathOfAlias($this->_savePathAlias).DIRECTORY_SEPARATOR.$this->user_id.DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $dirPath Путь директории изображений
     * @return bool
     */

    public function createSubFolder($dirPath){
        if(!is_dir($dirPath)){
            if(mkdir($dirPath)){
                chmod($dirPath, 0775);
            }
        }
        if(is_dir($dirPath)){
            return true;
        }
        return false;
    }

    /**
     * @param string $dirPath Путь директории изображений
     * @return bool
     */
    public function deleteSubFolder($dirPath){
        if(is_dir($dirPath) && (sizeof(glob($dirPath."/*")) == 0)){
            rmdir($dirPath);
        }
        if(!is_dir($dirPath)){
            return true;
        }
        return false;
    }

    public function beforeSave(){
        if(isset($this->phone) && !is_null($this->phone) && strlen(trim($this->phone))>0){
            $this->phone = preg_replace("/[^0-9]/", "", $this->phone);
        }
        return parent::beforeSave();
    }


}
