<?php

namespace app\controllers;


use yii\filters\Cors;
use yii\rest\ActiveController;

class BaseController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter']['class'] = Cors::className();
        return $behaviors;
    }

    public function runAction($id, $params=array()){
        $params = array_merge(\Yii::$app->request->getBodyParams(), $params);

        return parent::runAction($id, $params);
    }
}