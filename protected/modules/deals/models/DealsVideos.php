<?php

/**
 * This is the model class for table "DealsVideos".
 *
 * The followings are the available columns in table 'DealsVideos':
 * @property string $id
 * @property string $name
 * @property string $file_name
 * @property string $ext
 * @property string $path
 * @property string $url
 * @property string $description
 * @property string $dir_path
 * @property string $dir_url
 * @property integer $width
 * @property integer $height
 * @property string $duration
 * @property string $deal_id
 * @property integer $approve
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property Deals $deal
 */
class DealsVideos extends CActiveRecord
{

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
	public $largeThumbEmptyUrl = NULL;
	public $mediumThumbEmptyUrl = NULL;
	public $smallThumbEmptyUrl = NULL;
	public $largeThumbEmptyPath = NULL;
	public $mediumThumbEmptyPath = NULL;
	public $smallThumbEmptyPath = NULL;
	public $originalThumbEmptyUrl = NULL;
	public $originalThumbEmptyPath = NULL;

	public function init(){
		$this->largeThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_EMPTY_URL");
		$this->mediumThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_URL");
		$this->smallThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_EMPTY_URL");
		$this->largeThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_EMPTY_PATH");
		$this->mediumThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_EMPTY_PATH");
		$this->smallThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_EMPTY_PATH");
		$this->originalThumbEmptyUrl = Yii::app()->config->get("DEALS_MODULE.EMPTY_ORIGINAL_IMG_URL");
		$this->originalThumbEmptyPath = Yii::app()->config->get("DEALS_MODULE.EMPTY_ORIGINAL_IMG_PATH");
	}


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'DealsVideos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('width, height, approve', 'numerical', 'integerOnly'=>true),
			array('name, file_name, path, url, dir_path, dir_url, alias', 'length', 'max'=>255),
			array('description', 'length', 'max'=>400),
			array('ext', 'length', 'max'=>5),
			array('approve', 'length', 'max'=>1),
			array('duration, deal_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, file_name, ext, path, url, width, height, duration, deal_id, dir_path, dir_url, alias', 'safe', 'on'=>'search'),
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
			'deal' => array(self::BELONGS_TO, 'Deals', 'deal_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('dealsModule','Video Name'),
			'file_name' => Yii::t('dealsModule','File name'),
			'ext' => Yii::t('dealsModule','File extensions'),
			'path' => Yii::t('dealsModule','File path'),
			'url' => Yii::t('dealsModule','Url'),
			'description' => Yii::t('dealsModule','Description'),
			'dir_path' => Yii::t('dealsModule','Directory path'),
			'dir_url' => Yii::t('dealsModule','Directory Url'),
			'width' => Yii::t('dealsModule','Width'),
			'height' => Yii::t('dealsModule','Height'),
			'duration' => Yii::t('dealsModule','Duration'),
			'deal_id' => Yii::t('dealsModule','Deal ID'),
			'approve' => Yii::t('dealsModule','Approve label'),
			'alias' => Yii::t('dealsModule','Alias'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('dir_path',$this->dir_path,true);
		$criteria->compare('dir_url',$this->dir_url,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('duration',$this->duration,true);
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('approve',$this->approve,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('dir_path',$this->dir_path,true);
		$criteria->compare('dir_url',$this->dir_url,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('duration',$this->duration,true);
		$criteria->compare('deal_id',$this->deal_id,true);
		$criteria->compare('approve',$this->approve,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DealsVideos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterFind(){
		parent::afterFind();
		$this->thumbsUrl = $this->dir_url."thumbs/";
		$this->thumbsPath = $this->dir_path."thumbs".DIRECTORY_SEPARATOR;
		$this->originalThumbUrl = $this->thumbsUrl.$this->name.".jpg";
		$this->largeThumbUrl = $this->thumbsUrl.Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX").$this->name.".jpg";
		$this->mediumThumbUrl = $this->thumbsUrl.Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX").$this->name.".jpg";
		$this->smallThumbUrl = $this->thumbsUrl.Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX").$this->name.".jpg";
		$this->originalThumbPath = $this->thumbsPath.$this->name.".jpg";
		$this->largeThumbPath = $this->thumbsPath.Yii::app()->config->get("DEALS_MODULE.LARGE_THUMB_PREFIX").$this->name.".jpg";
		$this->mediumThumbPath = $this->thumbsPath.Yii::app()->config->get("DEALS_MODULE.MEDIUM_THUMB_PREFIX").$this->name.".jpg";
		$this->smallThumbPath = $this->thumbsPath.Yii::app()->config->get("DEALS_MODULE.SMALL_THUMB_PREFIX").$this->name.".jpg";
	}

    public function beforeSave(){
        if(!Yii::app()->getModule('user')->isModerator()){
            $this->approve = 0;
            /*if(!is_null($this->deal->user) && !is_null($this->deal->user->email) && strlen(trim($this->deal->user->email))>0){
                $name = (!is_null($this->alias) && strlen(trim($this->alias))>0) ? $this->alias : $this->file_name;
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

	protected function beforeDelete(){
		if(file_exists($this->path)){
			unlink($this->path);
		};
		if(file_exists($this->originalThumbPath)){
			unlink($this->originalThumbPath);
		};
		if(file_exists($this->largeThumbPath)){
			unlink($this->largeThumbPath);
		};
		if(file_exists($this->mediumThumbPath)){
			unlink($this->mediumThumbPath);
		};
		if(file_exists($this->smallThumbPath)){
			unlink($this->smallThumbPath);
		};
		if(!file_exists($this->path) && !file_exists($this->originalThumbPath) && !file_exists($this->largeThumbPath) && !file_exists($this->mediumThumbPath) && !file_exists($this->smallThumbPath)){
            if(!is_null($this->deal->user) && !is_null($this->deal->user->email) && strlen(trim($this->deal->user->email))>0 && ($this->deal->user_id != Yii::app()->user->getId())){
                $name = (!is_null($this->alias) && strlen(trim($this->alias))>0) ? $this->alias : $this->file_name;
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
            return parent::beforeDelete();
		}
		else{
			return false;
		}
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
	public function getOriginalThumbUrl(){
		if(file_exists($this->originalThumbPath) && is_file($this->originalThumbPath)){
			return $this->originalThumbUrl;
		}
		else{
			return $this->originalThumbEmptyUrl;
		}

	}
	public static function getApproveListData(){
		return array(0=>'Not approved',1=>'Approved');
	}


}
