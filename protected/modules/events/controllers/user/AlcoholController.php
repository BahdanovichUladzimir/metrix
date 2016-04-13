<?php

class AlcoholController extends UserFrontendController
{

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id){
        $this->layout = '//layouts/guests_list';
        $this->bgImage = '/images/alc_bg.jpg';
        $this->pageTitle = Yii::t('eventsModule','Event alcohol and drinks calculation.');
        $this->title = Yii::t('eventsModule','Event alcohol and drinks calculation.');
        $this->pageDescription = Yii::t(
            'eventsModule',
            "<p>Почти у всех готовящихся к свадьба возникает вопрос: сколько и какой алкоголь покупать?
							Обычно на свадьбах пьют водку, вино и шампанское.
							С количеством все гораздо сложнее. Оно зависит от многих факторов:</p>
							<p>- количество гостей и их состав<br />
							- продолжительность свадебного банкета<br />
							- время года<br />
							- до какого состояния вы хотите напоить гостей</p>"
        );
        $model = $this->loadModel($id);
        $consumptionRate = Yii::app()->config->get("EVENTS_MODULE.CONSUMPTION_RATE");
        $degreeConsumption = Alcohol::getAlcoholConsumptionDegrees()[$model->alcohol_consumption];
        $volumes = Alcohol::$alcoholConsumptionDegreesVolumes[$degreeConsumption];
        $season = Alcohol::getSeasons()[$model->season];
        $seasonCoef = Alcohol::$seasonsCoefficients[$season];
        $menVodkaCount = $model->men*$volumes['vodka']['men']*$seasonCoef/6*$model->event_duration*$consumptionRate;
        $menWineCount = $model->men*$volumes['wine']['men']*$seasonCoef/6*$model->event_duration*$consumptionRate;
        $menChampagneCount = $model->men*$volumes['champagne']['men']*$seasonCoef/6*$model->event_duration*$consumptionRate;
        $womenVodkaCount = $model->men*$volumes['vodka']['women']*$seasonCoef/6*$model->event_duration*$consumptionRate;
        $womenWineCount = $model->men*$volumes['wine']['women']*$seasonCoef/6*$model->event_duration*$consumptionRate;
        $womenChampagneCount = $model->men*$volumes['champagne']['women']*$seasonCoef/6*$model->event_duration*$consumptionRate;
        $this->render(
            'view',
            array(
                'model'=>$model,
                'menVodkaCount' => $menVodkaCount,
                'menWineCount' => $menWineCount,
                'menChampagneCount' => $menChampagneCount,
                'womenVodkaCount' => $womenVodkaCount,
                'womenWineCount' => $womenWineCount,
                'womenChampagneCount' => $womenChampagneCount,
            )
        );
    }

    /**
     * @param int|string $event_id
     */
    public function actionCreate($event_id){
        $this->layout = '//layouts/guests_list';
        $this->bgImage = '/images/alc_bg.jpg';
        $this->pageTitle = Yii::t('eventsModule','Event alcohol and drinks calculation.');
        $this->title = Yii::t('eventsModule','Event alcohol and drinks calculation.');
        $this->pageDescription = Yii::t(
            'eventsModule',
            "<p>Почти у всех готовящихся к свадьба возникает вопрос: сколько и какой алкоголь покупать?
							Обычно на свадьбах пьют водку, вино и шампанское.
							С количеством все гораздо сложнее. Оно зависит от многих факторов:</p>
							<p>- количество гостей и их состав<br />
							- продолжительность свадебного банкета<br />
							- время года<br />
							- до какого состояния вы хотите напоить гостей</p>"
        );

        $model = Alcohol::model()->findByAttributes(array('event_id' => $event_id));
        if(is_null($model)){
            $model=new Alcohol();
            $model->event_id = (int)$event_id;
        }
        $this->performAjaxValidation($model);

        if(isset($_POST['Alcohol'])){
            $model->attributes=$_POST['Alcohol'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id){
        $this->title = Yii::t('eventsModule','Alcohol calculator');

        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Alcohol'])){
            $model->attributes=$_POST['Alcohol'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render(
            'update',
            array(
                'model'=>$model,
            )
        );
    }

    /**
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id){

        if(Yii::app()->request->isPostRequest){
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            if(Yii::app()->user->getId() != $model->event->user_id && !Yii::app()->getModule('user')->isModerator()){
                throw new CHttpException(403,'Access denied!');
            }

            if($model->delete()){
                if(!Yii::app()->request->isAjaxRequest){
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/user/profile/privateProfile'));
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'success',
                            'message' => Yii::t("eventsModule", "Alcohol calculation was deleted successfully"),
                        )
                    );
                }
            }
            else{
                if(!Yii::app()->request->isAjaxRequest){
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/user/profile/privateProfile'));
                }
                else{
                    echo CJSON::encode(
                        array(
                            'status' => 'error',
                            'message' => Yii::t("eventsModule", "When delete alcohol calculation error occurred"),
                        )
                    );
                }

            }
        }
        else{
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
    * Manages all models.
    */
    /*public function actionIndex(){
        $model=new Alcohol('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Alcohol'])){
            $model->attributes=$_GET['Alcohol'];
        }

        $this->render(
            'index',
            array(
                'model'=>$model,
            )
        );
    }*/

    /**
     * @param $id
     * @return Alcohol
     * @throws CHttpException
     */
    public function loadModel($id){
        $model=Alcohol::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='alcohol-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
