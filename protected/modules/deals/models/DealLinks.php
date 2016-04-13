<?php

/**
 * This is the model class for table "DealLinks".
 *
 * The followings are the available columns in table 'DealLinks':
 * @property string $id
 * @property string $link
 * @property string $thumb
 * @property string $link_type
 * @property string $deal_id
 * @property string|null $alias
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Deals $deal
 * @property integer $approve
 */
class DealLinks extends CActiveRecord
{
    public $largeThumbWidth = 1000;
    public $largeThumbHeight = 800;
    public $mediumThumbWidth = 500;
    public $mediumThumbHeight = 400;
    public $smallThumbWidth = 128;
    public $smallThumbHeight = 128;
    public $smallThumbPrefix = 'small_';
    public $mediumThumbPrefix = 'medium_';
    public $largeThumbPrefix = 'large_';


    public $thumbsUrl = NULL;
    public $thumbsPath = NULL;
    public $originalThumbUrl = NULL;
    public $largeThumbUrl = NULL;
    public $mediumThumbUrl = NULL;
    public $smallThumbUrl = NULL;
    public $largeThumbPath = NULL;
    public $originalThumbPath = NULL;
    public $mediumThumbPath = NULL;
    public $smallThumbPath = NULL;


    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealLinks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, alias', 'length', 'max'=>255),
			array('thumb', 'length', 'max'=>255, 'allowEmpty'=>true),
			array('link', 'required'),
			array('link', 'url','pattern' => '/^(https?):\/\/(www\.)*(youtube|player.vimeo|vimeo).com\/*/', 'message'=>Yii::t('dealsModule','Enter a valid youtube url. (For example: http://www.youtube.com)')),
			//array('thumb', 'url'),
			array('link_type', 'length', 'max'=>50),
            array('approve', 'length', 'max'=>1),
            array('deal_id', 'length', 'max'=>11),
            array('description', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, link, thumb, link_type, deal_id, approve, alias, description', 'safe', 'on'=>'search'),
		);
	}
    public function afterSave(){
        $thumbUrl = NULL;
        if($this->link_type == 'youtube'){
            $thumbUrl = json_decode(file_get_contents(sprintf('https://www.youtube.com/oembed?url=%s&format=json', urlencode($this->link))))->thumbnail_url;
        }
        elseif($this->link_type == 'vimeo'){
            $url = $this->link;
            $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
            $videoId = (int)$urlParts[count($urlParts)-1];

            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$videoId.".php"));
            $thumbUrl = $hash[0]['thumbnail_large'];
        }
        else{

        }
        if(!is_null($thumbUrl) && is_string($thumbUrl) && (strlen($thumbUrl)>0)){
            $file = $thumbUrl;
            if($f=@fopen($file, 'rb')){
                $this->deleteFiles(); // старый файл удалим, потому что загружаем новый
                $extension = "jpg";
                $fileName = md5(microtime().$this->id).".".$extension;
                $linksDirPath = Yii::getPathOfAlias("webroot.uploads.deals").DIRECTORY_SEPARATOR.$this->deal_id.DIRECTORY_SEPARATOR."links".DIRECTORY_SEPARATOR;
                $imagesDirPath = Yii::getPathOfAlias("webroot.uploads.deals").DIRECTORY_SEPARATOR.$this->deal_id.DIRECTORY_SEPARATOR."links".DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR;
                $originalImagePath = $imagesDirPath.$fileName;
                $largeThumbPath = $imagesDirPath.$this->largeThumbPrefix.$fileName;
                $mediumThumbPath = $imagesDirPath.$this->mediumThumbPrefix.$fileName;
                $smallThumbPath = $imagesDirPath.$this->smallThumbPrefix.$fileName;
                if($this->_createSubFolders($linksDirPath, $imagesDirPath)){
                    /**
                     * @var $ih CImageHandler
                     */
                    $ih = Yii::app()->ih;
                    $ih->load($file);
                    $ih->save($originalImagePath);
                    chmod($originalImagePath,0777);
                    $this->updateByPk($this->id, array('thumb'=>$fileName));
                    $ih->reload();
                    $ih->adaptiveThumb($this->largeThumbWidth, $this->largeThumbHeight);
                    $ih->save($largeThumbPath);
                    chmod($largeThumbPath,0777);
                    $ih->reload();
                    $ih->adaptiveThumb($this->mediumThumbWidth, $this->mediumThumbHeight);
                    $ih->save($mediumThumbPath);
                    chmod($mediumThumbPath,0777);
                    $ih->reload();
                    $ih->adaptiveThumb($this->smallThumbWidth, $this->smallThumbHeight);
                    $ih->save($smallThumbPath);
                    chmod($smallThumbPath,0777);
                    unset($f);
                };
            }

        }
    }
    public function beforeSave(){
        if(mb_strpos(mb_strtolower($this->link),"youtube")){
            $this->link_type = 'youtube';
        }
        elseif(mb_strpos(mb_strtolower($this->link),"vimeo")){
            $this->link_type = 'vimeo';
            $url = $this->link;
            $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
            $videoId = (int)$urlParts[count($urlParts)-1];
            $this->link = "https://player.vimeo.com/video/".$videoId;
        }
        else{
            return false;
        }
		if(!Yii::app()->getModule('user')->isModerator()){
			$this->approve = 0;
			/*if(!is_null($this->deal->user) && !is_null($this->deal->user->email) && strlen(trim($this->deal->user->email))>0){
				$name = (!is_null($this->alias) && strlen(trim($this->alias))>0) ? $this->alias : $this->link;
                $message = Yii::t(
                    'dealsModule',
                    "Dear {userName}! Video \"{name}\" was sent to moderation.",
                    array(
                        '{userName}' => $this->deal->user->username,
                        '{name}' => $name
                    )
                );
				$messagesModel = new EmailMessages();
				$messagesModel->from = Yii::app()->params['adminEmail'];
				$messagesModel->to = $this->deal->user->email;
				$messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
				$messagesModel->message = $message;
				$messagesModel->type_id = 1;
				$messagesModel->is_sent = 0;
				$messagesModel->created_date = time();
                $messagesModel->recipient_id = $this->deal->user->id;
                $messagesModel->save();
                UserMessages::sendMessage(1,$this->deal->user_id,$message);
            }*/
		}
		return parent::beforeSave();
    }

    public function beforeDelete(){
        if(!is_null($this->deal->user) && !is_null($this->deal->user->email) && strlen(trim($this->deal->user->email))>0 && ($this->deal->user_id != Yii::app()->user->getId())){
            $name = (!is_null($this->alias) && strlen(trim($this->alias))>0) ? $this->alias : $this->link;
            $message = Yii::t(
                'dealsModule',
                "Dear {userName}! Video \"{name}\" was deleted.",
                array(
                    '{userName}' => $this->deal->user->username,
                    '{name}' => $name
                )
            );
            /*$messagesModel = new EmailMessages();
            $messagesModel->from = Yii::app()->params['adminEmail'];
            $messagesModel->to = $this->deal->user->email;
            $messagesModel->subject = Yii::t('dealsModule','Message from all4holidays.com');
            $messagesModel->message = $message;
            $messagesModel->type_id = 1;
            $messagesModel->is_sent = 0;
            $messagesModel->created_date = time();
            $messagesModel->recipient_id = $this->deal->user->id;
            $messagesModel->save();*/
			UserMessages::sendMessage(1,$this->deal->user_id,$message);
		}
        $this->deleteFiles();
        return parent::beforeDelete();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dealsModule','ID'),
			'link' => Yii::t('dealsModule','Link'),
			'thumb' => Yii::t('dealsModule','Thumb'),
			'link_type' => Yii::t('dealsModule','Link type'),
			'deal_id' => Yii::t('dealsModule','Deal ID'),
            'approve' => Yii::t('dealsModule','Approve label'),
            'alias' => Yii::t('dealsModule','Title'),
            'description' => Yii::t('dealsModule','Description'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('link_type',$this->link_type,true);
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('approve',$this->approve,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
    public function adminSearch()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order='approve ASC';

		$criteria->compare('id',$this->id,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('link_type',$this->link_type,true);
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('approve',$this->approve,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function dealSearch($dealId)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('deal_id',$dealId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealLinks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getLinksTypes(){
        return array(
            1 => 'youtube',
            2 => 'vimeo'
        );
    }
    public function getLargeThumbUrl(){
        if(file_exists($this->largeThumbPath) && is_file($this->largeThumbPath)){
            return $this->largeThumbUrl;
        }
        else{
            if($this->link_type == "youtube"){
                return "/images/YT_269x215.png";
            }
            else{
                return "/images/V_269x215.png";
            }

        }
    }
    public function getMediumThumbUrl(){
        if(file_exists($this->mediumThumbPath) && is_file($this->mediumThumbPath)){
            return $this->mediumThumbUrl;
        }
        else{
            if($this->link_type == "youtube"){
                return "/images/YT_128x128.png";
            }
            else{
                return "/images/V_128x128.png";
            }

        }

    }


    public function getSmallThumbUrl(){
        if(file_exists($this->smallThumbPath) && is_file($this->smallThumbPath)){
            return $this->smallThumbUrl;
        }
        else{
            if($this->link_type == "youtube"){
                return "/images/YT.png";
            }
            else{
                return "/images/V.png";
            }

        }
    }

    private function _createSubFolders($dealLinksDirPath, $linksImagesDirPath){
        if(!is_dir($dealLinksDirPath)){
            if(mkdir($dealLinksDirPath)){
                chmod($dealLinksDirPath, 0775);
            }
        }
        if(!is_dir($linksImagesDirPath)){
            if(mkdir($linksImagesDirPath)){
                chmod($linksImagesDirPath, 0775);
            }
        }
        if(is_dir($linksImagesDirPath) && is_dir($dealLinksDirPath)){
            return true;
        }
        return false;
    }

    public function deleteFiles(){
        $fileName = $this->getAttribute('thumb');
        $imagePath=$this->getSavePath().$fileName;
        $largeThumbPath = $this->getSavePath().$this->largeThumbPrefix.$fileName;
        $mediumThumbPath = $this->getSavePath().$this->mediumThumbPrefix.$fileName;
        $smallThumbPath = $this->getSavePath().$this->smallThumbPrefix.$fileName;
        if(@is_file($imagePath)){
            @unlink($imagePath);
        }
        if(@is_file($largeThumbPath)){
            @unlink($largeThumbPath);
        }
        if(@is_file($mediumThumbPath)){
            @unlink($mediumThumbPath);
        }
        if(@is_file($smallThumbPath)){
            @unlink($smallThumbPath);
        }
        if(is_dir($this->getSavePath())){
            rmdir($this->getSavePath());
        }
        if(!is_file($imagePath) && !is_file($largeThumbPath) && !is_file($mediumThumbPath) && !is_file($smallThumbPath) && !is_dir($this->getSavePath())){
            return true;
        }
        else{
            return false;
        }
    }

    public function getSavePath(){
        return Yii::getPathOfAlias("webroot.uploads.deals").DIRECTORY_SEPARATOR.$this->deal_id.DIRECTORY_SEPARATOR."links".DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR;
    }

    public function getThumbsUrl(){
        return Yii::app()->request->baseUrl."/uploads/deals/".$this->deal_id."/links/".$this->id."/";
    }

    protected function afterFind(){
        parent::afterFind();
        $this->thumbsUrl = $this->getThumbsUrl();
        $this->thumbsPath = $this->getSavePath();
        $this->originalThumbUrl = $this->thumbsUrl.$this->thumb;
        $this->largeThumbUrl = $this->thumbsUrl.$this->largeThumbPrefix.$this->thumb;
        $this->mediumThumbUrl = $this->thumbsUrl.$this->mediumThumbPrefix.$this->thumb;
        $this->smallThumbUrl = $this->thumbsUrl.$this->smallThumbPrefix.$this->thumb;
        $this->originalThumbPath = $this->thumbsPath.$this->thumb;
        $this->largeThumbPath = $this->thumbsPath.$this->largeThumbPrefix.$this->thumb;
        $this->mediumThumbPath = $this->thumbsPath.$this->mediumThumbPrefix.$this->thumb;
        $this->smallThumbPath = $this->thumbsPath.$this->smallThumbPrefix.$this->thumb;
    }

}
