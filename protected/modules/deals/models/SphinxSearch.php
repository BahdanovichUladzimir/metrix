<?php

/**
 * This is the model class for Sphinx search.
 *
 * The followings are the available columns in table 'Items':
 * @property string $sphinxQuery
 * @var $search DGSphinxSearch
 */
class SphinxSearch extends CFormModel{


    public $sphinxQuery;


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            //array('sphinxQuery', 'safe', 'on' => 'sphinxSearch'),
            array('sphinxQuery', 'length', 'max' => 70),
		);
	}

    // extended validation, run before the rules set above
    protected function beforeValidate()
    {
        if (!empty($this->sphinxQuery) && substr_count($this->sphinxQuery, '"') % 2 !== 0) {
            $this->addError("sphinxQuery", "Odd number of quotes");
            // return false; // stop validation
        }
        return parent::beforeValidate();
    }

    /** @return boolean Continue the validation process? */
    /*protected function customValidateForStrangedata($attribute, $params)
    {
        $this->addError($attribute, "validation failed");
        return false;
    }*/


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
            'sphinxQuery' => 'Query'
        );
	}

    /**
     * @return bool|CActiveDataProvider
     */
    public function dealsSearch()
    {
        if(!is_null($this->sphinxQuery))
        {
            $matchesIds = array();

            $search = Yii::app()->search;
            $client = new SphinxClient();

            /**
             * @var $search DGSphinxSearch
             */
            $searchString = $client->EscapeString($this->sphinxQuery);

            $fieldWeights = array(
                'name' => 1000,
                'intro' => 500,
                'description' => 300,
            );
            $search->setFieldWeights($fieldWeights);
            $search->select('*')->
            from('a4h_deal, a4h_deal_delta')->
            where("*".$searchString."*")->
            orderby(array('dealName' => 'ASC'))->
            limit(0, 1000);
            //$resIterator = $search->search(); // interator result
            /* OR */
            $resArray = $search->searchRaw(); // array result

            if(sizeof($resArray['matches'])>0)
            {
                foreach($resArray['matches'] as $key => $val)
                {
                    $matchesIds[] = $key;
                }

            }
            $criteria = new CDbCriteria;
            $criteria->condition = 'status_id=:status_id AND approve=:approve AND archive=:archive';
            $criteria->params = array(
                ':status_id' => 1,
                ':approve' => 1,
                ':archive' => 0
            );
            $criteria->addInCondition('id',$matchesIds);
            //$criteria->select = 't.ID, t.Name, t.Views, t.ImageName, t.Intro, t.Year';
            $dataProvider = new CActiveDataProvider('Deals',array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>array(
                        'Name'=>CSort::SORT_ASC,
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));
            return $dataProvider;
        }
        else
        {
            return false;
        }
    }
    /**
     * @return bool|CActiveDataProvider
     */
    public function categoriesSearch()
    {
        if(!is_null($this->sphinxQuery))
        {
            $matchesIds = array();

            $search = Yii::app()->search;
            $client = new SphinxClient();

            /**
             * @var $search DGSphinxSearch
             */
            $searchString = $client->EscapeString($this->sphinxQuery);
            $search->select('*')->
                from('a4h_category, a4h_category_delta')->
                where("*".$searchString."*")->
                orderby(array('categoryName' => 'ASC'))->
                limit(0, 1000);
            //$resIterator = $search->search(); // interator result
            /* OR */
            $resArray = $search->searchRaw(); // array result

            if(sizeof($resArray['matches'])>0) {
                foreach ($resArray['matches'] as $key => $val) {
                    $matchesIds[] = $key;
                }
            }
            $criteria = new CDbCriteria;
            $criteria->condition = 'status_id=:status_id';
            $criteria->params = array(
                ':status_id' => 1,
            );
            $criteria->addInCondition('id',$matchesIds);
            //$criteria->select = 't.ID, t.Name, t.Views, t.ImageName, t.Intro, t.Year';
            $dataProvider = new CActiveDataProvider('DealsCategories',array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>array(
                        'Name'=>CSort::SORT_ASC,
                    ),
                ),
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));
            return $dataProvider;
        }
        else
        {
            return false;
        }
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Deals the static model class
	 */
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
}
