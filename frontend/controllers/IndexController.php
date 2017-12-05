<?php
namespace frontend\controllers;
use yii;
use yii\web\Controller;
class IndexController extends Controller{

    public function actionIndex(){
       echo  $_GET['echostr'];
    }
}