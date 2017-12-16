<?php
namespace backend\controllers;
use yii;
use yii\web\Controller;

class  ControController extends Controller{



    public $enableCsrfValidation = false;
    public $layouts = false;
    public function actionIndex(){
       return  $this->render('sendAll');
    }
}

