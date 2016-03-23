<?php

class DefaultController extends MainController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}