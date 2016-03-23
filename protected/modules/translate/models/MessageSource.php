<?php

/**
 * MessageSource Class file
 * 
 * CActiveRecord that handles message source DB 
 * 
 * @author Antonio Ramirez 
 * @link http://www.ramirezcobos.com 
 * 
 * 
 * THIS SOFTWARE IS PROVIDED BY THE CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @property int $id
 * @property string $message
 * @property string $category
 * @property Message[] $mt
 */
class MessageSource extends CActiveRecord {

	public $language;

	static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function onDelete()
	{
		if ($this->mt)
		{
			/* ADO is faster but we do not know the database component id */
			foreach ($this->mt as $msg)
				$msg->delete();
		}
	}

	public function missing()
	{
		$this->getDbCriteria()
				->addCondition('not exists (select `id` from `' . Message::model()->tableName() . '` `m` where `m`.`language`=:lang and `m`.id=`t`.`id`)')
			->params[':lang'] = $this->language;
		;
		return $this;
	}

	public function tableName()
	{
		return Yii::app()->getMessages()->sourceMessageTable;
	}

	public function rules()
	{
		return array(
			array('category,message', 'required'),
			array('category', 'length', 'max' => 32),
			array('message', 'safe'),
			array('id, category, message,language', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'mt' => array(self::HAS_MANY, 'Message', 'id', 'joinType' => 'inner join'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translate', 'ID'),
			'category' => Yii::t('translate', 'Category'),
			'message' => Yii::t('translate', 'Message'),
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		//$criteria->with = array('mt');

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.category', $this->category);
		$criteria->compare('t.message', $this->message, true);

		return new CActiveDataProvider(
            get_class($this),
            array(
				'criteria' => $criteria,
                'pagination'=>array(
                    'pageSize'=>50, //could put 1, 2, 3, 10, 20, 30, etc. however many you want to display per page.
                ),
			));
	}

	public function loadMessage($lang = null)
	{
		if (null == $lang)
			$lang = Yii::app()->getLanguage();

		$message = Message::model()->findByPk(array('id' => $this->id, 'language' => $lang));

		return null === $message ? new Message() : $message;
	}

    public static function getCurrentLanguageTranslation($lang){
        $criteria = new CDbCriteria();
        $criteria->with = 'mt';
        $criteria->condition = "mt.language=:language";
        $criteria->params = array(":language"=> $lang);
        $translations = self::model()->findAll($criteria);
        $translationsArray = array();
        foreach($translations as $translation){
            $translationsArray[] = array(
                'id' => $translation->id,
                'message' => CHtml::encode($translation->message),
                'category' => $translation->category,
                'translation' => CHtml::encode($translation->mt[0]->translation)
            );
        }
        return $translationsArray;
    }

    public function getTranslationByLang($lang){
        foreach($this->mt as $message){
            if($message->language == $lang){
                return $message->translation;
            }
        }
    }

    public function getTranslationsString(){
        $translations = array();
        foreach($this->mt as $translation)
        {
            /**
             * @var $category DealsCategories
             */
            $translations[$translation->id] = $translation->language;
        }
        return implode(', ', $translations);
    }

}