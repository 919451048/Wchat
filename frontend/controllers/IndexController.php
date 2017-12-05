<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class IndexController extends Controller{

    public function actionIndex(){
       echo  yii::$app->request->get('echoStr') && $_GET['echoStr'];
    }
}