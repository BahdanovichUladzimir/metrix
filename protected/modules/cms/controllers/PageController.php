<?php

/**
 * NodeController class file.
 * @author Christoffer Niska <christoffer.niska@nordsoftware.com>
 * @copyright Copyright &copy; 2012, Nord Software Ltd
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package cms.controllers
 * @since 2.0.0
 */

/**
 * Page controller.
 * @property CmsModule $module
 */
class PageController extends NodeController {

    //public $layout='//layout/main';

    public function actions() {
        return array(
            'fileUpload' => array(
                'class' => 'ext.redactor.actions.FileUpload',
            //'uploadPath'=>'/path/to/uploads/folder',
            //'uploadUrl'=>'/url/to/uploads/folder',
            //'uploadCreate'=>true,
            //'permissions'=>0664,
            ),
            'imageUpload' => array(
                'class' => 'ext.redactor.actions.ImageUpload',
            //'uploadPath'=>'/path/to/uploads/folder',
            //'uploadUrl'=>'/url/to/uploads/folder',
            //'uploadCreate'=>true,
            //'permissions'=>0664,
            ),
            'imageList' => array(
                'class' => 'ext.redactor.actions.ImageList',
            //'uploadPath'=>'/path/to/uploads/folder',
            //'uploadUrl'=>'/url/to/uploads/folder',
            ),
        );
    }

    /**
     * @return array the action filters for this controller.
     */
    /*public function filters() {
        return array(
            array('cms.components.CmsPageViewFilter + view'),
        );
    }*/

    /**
     * Displays the page to create a new model.
     */
    public function actionCreate() {
        $model = new CmsPage();

        if (isset($_POST['CmsPage'])) {
            $model->attributes = $_POST['CmsPage'];
            $model->dictionary = (isset($_POST['CmsPage']["dictionary"]))?$_POST['CmsPage']["dictionary"]:NULL;
            if ($model->saveWithRelated(array('dictionary'))) {
                Yii::app()->user->setFlash($this->module->flashes['success'], Yii::t('page', 'Page created.'));
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Display the page to update a particular model.
     * @param integer $id the id of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $translations = $this->getTranslations($model);

        if (isset($_POST['CmsPage'], $_POST['CmsPageContent'])) {
            $valid = true;
            foreach ($translations as $language => $content) {
                $content->attributes = $_POST['CmsPageContent'][$language];
                $valid = $valid && $content->validate();
                $translations[$language] = $content;
            }

            if ($valid) {
                $model->attributes = $_POST['CmsPage'];
                $model->dictionary = (isset($_POST['CmsPage']["dictionary"])) ? $_POST['CmsPage']["dictionary"] : NULL;

                $save = $model->saveWithRelated(array('dictionary')); // we need to save the page so that the 'updated' column is updated

                //Config::var_dump($save);

                foreach ($translations as $content)
                    $content->save();

                Yii::app()->user->setFlash($this->module->flashes['success'], Yii::t('page', 'Page updated.'));
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionIndex() {
        $model = new CmsPage('search');
        $model->unsetAttributes(); // clear any default values
        $this->render('index', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the id of the model to be deleted
     */
    public function actionDelete($id) {
        // we only allow deletion via POST request
        $this->loadModel($id)->delete();
        Yii::app()->user->setFlash($this->module->flashes['success'], Yii::t('page', 'Page deleted.'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : Yii::app()->homeUrl);
    }

    /**
     * Displays a particular page.
     * @param integer $id the id of the model to display
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $this->layout = '//layouts/main';
        if ($model->hasContent()) {
            $this->title = $model->pageTitle;
            $this->breadcrumbs = $model->breadcrumbs;
        }

        $this->render('view', array(
            'model' => $model,
            'heading' => $model->heading,
            'content' => $model->render(),
        ));
    }

    /**
     * Returns the form tabs for BootTabbable.
     * @param CForm $form the form model
     * @param CmsPage $model the page model
     * @return array the tabs
     */
    public function getFormTabs($form, $model) {
        return array(
            $this->getContentTab($form, $model),
            //$this->getImagesTab($form, $model),
            //$this->getAttachmentsTab($form, $model),
            $this->getPageTab($form, $model),
                //$this->getPreviewTab(),
        );
    }

    /**
     * Returns the attachment tab for BootTabbable.
     * @param CForm $form the form model
     * @param CmsPage $model the page model
     * @return array the tab configuration
     */
    protected function getAttachmentsTab($form, $model) {
        return array(
            'label' => Yii::t('page', 'Attachments'),
            'content' => $this->renderPartial('_attachmentsForm', array('form' => $form, 'model' => $model), true),
            'active' => isset($_GET['tab']) && $_GET['tab'] === 'attachments',
        );
    }

    /**
     * Returns the page tab for BootTabbable.
     * @param CForm $form the form model
     * @param CmsPage $model the model
     * @return array the tab configuration
     */
    protected function getPageTab($form, $model) {
        return array(
            'label' => Yii::t('page', 'Page'),
            'content' => $this->renderPartial('_form', array('form' => $form, 'model' => $model), true),
            'active' => isset($_GET['tab']) && $_GET['tab'] === 'model',
        );
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
