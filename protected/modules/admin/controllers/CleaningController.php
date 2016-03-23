<?php
/**
 * Created by PhpStorm.
 * User: Mikhail
 * Date: 01.04.2015
 * Time: 21:39
 */

class CleaningController extends BackendController{
    /*public function actionAssets(){

            $this->full_del_dir(Yii::app()->assetManager->basePath);

        //Yii::app()->user->setFlash('success', 'Assets очищены');
        //$this->redirect(Yii::app()->createUrl('admin'));
    }*/
    public function actionCache(){
        Yii::app()->cache->flush();
        Yii::app()->user->setFlash('success', 'cache очищен');
        $this->redirect(Yii::app()->createUrl('admin'));
    }
    function full_del_dir ($directory)
    {
        $dir = opendir($directory);
        while (($file = readdir($dir))) {
            if (is_file($directory . "/" . $file)) {
                unlink($directory . "/" . $file);
            } else if (is_dir($directory . "/" . $file) &&
                ($file != ".") && ($file != "..")
            ) {
                full_del_dir($directory . "/" . $file);
            }
        }
        closedir($dir);
    }
}