<?php

class DictionaryController extends FrontendController
{
    /**
    * Manages all models.
    */
    public function actionIndex(){

        $enAlphabet = Dictionary::$enAlphabet;
        $rusAlphabet = Dictionary::$rusAlphabet;
        $criteria = new CDbCriteria();
        $criteria->addInCondition('letter',$rusAlphabet,'OR');
        $rusModels = Dictionary::model()->findAll($criteria);
        unset($criteria);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('letter',$enAlphabet,'OR');
        $criteria->order = 'name ASC';
        $enModels = Dictionary::model()->findAll($criteria);
        $this->render(
            'index',
            array(
                'rusModels'=>$rusModels,
                'enModels'=>$enModels,
                'enAlphabet'=>$enAlphabet,
                'rusAlphabet'=>$rusAlphabet,
            )
        );
    }

    /**
     * @param string $letter
     */
    public function actionLetter($letter){
        $enAlphabet = Dictionary::$enAlphabet;
        $rusAlphabet = Dictionary::$rusAlphabet;
        if($letter == "A-Z"){
            $criteria = new CDbCriteria();
            $criteria->addInCondition('letter',$enAlphabet,'OR');
            $criteria->order = 'name ASC';
            $models = Dictionary::model()->findAll($criteria);
        }
        else{
            $models = Dictionary::model()->findAllByAttributes(array('letter' => $letter));
        }
        $this->render(
            'letter',
            array(
                'models'=>$models,
                'enAlphabet'=>$enAlphabet,
                'rusAlphabet'=>$rusAlphabet,
                'letter'=>$letter,
            )
        );
    }

    /**
     * @param int|string $id
     */
    public function actionView($id){
        $model = $this->loadModel($id);
        $enAlphabet = Dictionary::$enAlphabet;
        $rusAlphabet = Dictionary::$rusAlphabet;
        $this->render(
            'view',
            array(
                'model'=>$model,
                'enAlphabet'=>$enAlphabet,
                'rusAlphabet'=>$rusAlphabet,
            )
        );

    }

    /**
     * @param $id
     * @return Dictionary
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Dictionary::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='dictionary-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
