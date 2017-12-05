<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
class IndexController extends Controller{
    public $enableCsrfValition=false;
    public function actionIndex(){
        echo $_GET['echoStr'];
    }

}
