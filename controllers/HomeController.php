<?php

namespace app\controllers;

class HomeController extends \yii\web\Controller
{
    public function actionIndex()
    {

    	$test = '248735435';
        return $this->render('index',[
        		'test' => $test,
        	]);
    }

}
